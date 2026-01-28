<?php

namespace App\Services;

use App\Enums\RegistrationStatus;
use App\Models\Payment;
use App\Models\Registration;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        $this->initConfig();
    }

    private function initConfig(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = config('services.midtrans.is_sanitized', true);
        Config::$is3ds = config('services.midtrans.is_3ds', true);
    }

    /**
     * Create Snap token and save payment record
     */
    public function createSnapToken(Registration $registration): array
    {
        $orderId = $this->generateOrderId($registration);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $registration->total_amount,
            ],
            'customer_details' => [
                'first_name' => $registration->student->full_name ?? 'Customer',
                'email' => $registration->student->email ?? 'customer@example.com',
                'phone' => $registration->student->phone_number ?? '08123456789',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Create or update payment record
        $payment = Payment::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'amount' => $registration->total_amount,
                'status' => 'pending',
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]
        );

        Log::info('Snap token created', [
            'registration_code' => $registration->registration_code,
            'order_id' => $orderId,
            'payment_id' => $payment->id,
        ]);

        return [
            'snap_token' => $snapToken,
            'order_id' => $orderId,
        ];
    }

    /**
     * Handle notification from Midtrans webhook
     */
    public function handleNotification(): array
    {
        $notif = new \Midtrans\Notification();

        return [
            'transaction_status' => $notif->transaction_status,
            'payment_type' => $notif->payment_type,
            'order_id' => $notif->order_id,
            'fraud_status' => $notif->fraud_status ?? 'accept',
        ];
    }

    /**
     * Update registration and payment status
     */
    public function updatePaymentStatus(Registration $registration, string $transactionStatus, string $fraudStatus = 'accept'): string
    {
        $newStatus = $this->mapTransactionStatus($transactionStatus, $fraudStatus);
        $paymentStatus = $this->mapPaymentStatus($transactionStatus);

        $registration->update(['status' => $newStatus]);

        // Update payment record
        if ($registration->payment) {
            $registration->payment->update(['status' => $paymentStatus]);
        }

        Log::info('Payment status updated', [
            'registration_code' => $registration->registration_code,
            'transaction_status' => $transactionStatus,
            'new_registration_status' => $newStatus,
            'payment_status' => $paymentStatus,
        ]);

        return $newStatus;
    }

    private function mapTransactionStatus(string $transactionStatus, string $fraudStatus): string
    {
        return match ($transactionStatus) {
            'capture' => $fraudStatus === 'accept' ? RegistrationStatus::PEMBAYARAN_TERVERIFIKASI->value : RegistrationStatus::PEMBAYARAN_TERTUNDA->value,
            'settlement' => RegistrationStatus::PEMBAYARAN_TERVERIFIKASI->value,
            'pending' => RegistrationStatus::PEMBAYARAN_TERTUNDA->value,
            'deny', 'expire', 'cancel' => RegistrationStatus::PEMBAYARAN_TERTUNDA->value,
            default => RegistrationStatus::PEMBAYARAN_TERTUNDA->value,
        };
    }

    private function mapPaymentStatus(string $transactionStatus): string
    {
        return match ($transactionStatus) {
            'capture', 'settlement' => 'success',
            'pending' => 'pending',
            'deny', 'cancel' => 'failed',
            'expire' => 'expired',
            default => 'pending',
        };
    }

    public function parseRegistrationCode(string $orderId): string
    {
        $parts = explode('-', $orderId);
        array_pop($parts);
        return implode('-', $parts);
    }

    private function generateOrderId(Registration $registration): string
    {
        return $registration->registration_code . '-' . time();
    }
}
