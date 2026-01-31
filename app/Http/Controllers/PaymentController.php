<?php

namespace App\Http\Controllers;

use App\Enums\RegistrationStatus;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function upload(Request $request, Registration $registration)
    {
        $request->validate([
            'proof_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::transaction(function () use ($request, $registration) {
            $path = $request->file('proof_file')
                ->store('payment-proofs', 'public');

            Payment::updateOrCreate(
                ['registration_id' => $registration->id],
                ['proof_file' => $path]
            );

            $registration->changeStatus(
                RegistrationStatus::VERIFIKASI,
                'Pendaftar mengunggah bukti pembayaran'
            );
        });

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
