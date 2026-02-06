<?php

namespace App\Services;

use App\Enums\RegistrationStatus;
use App\Models\Registration;
use App\Models\RegistrationBatch;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    public function createOrUpdate(
        bool $isEdit,
        ?string $registrationCode,
        ?RegistrationBatch $batch,
        string $schoolLevel,
        array $studentData,
        array $parentData,
        array $uploadedDocuments,
        ?object $paymentProof
    ): Registration {
        return DB::transaction(function () use (
            $isEdit,
            $registrationCode,
            $batch,
            $schoolLevel,
            $studentData,
            $parentData,
            $uploadedDocuments,
            $paymentProof
        ) {
            if ($isEdit) {
                $registration = Registration::where('registration_code', $registrationCode)
                    ->lockForUpdate()
                    ->firstOrFail();

                $registration->changeStatus(
                    RegistrationStatus::VERIFIKASI,
                    'Pendaftar mengedit data'
                );

                $registration->student()->update($studentData);
                $registration->parent()->update($parentData);
            } else {
                if (!$batch) {
                    throw new \RuntimeException('Batch pendaftaran tidak tersedia.');
                }

                $registration = Registration::createNew(
                    $batch,
                    $schoolLevel
                );

                $registration->student()->create($studentData);
                $registration->parent()->create($parentData);
            }

            $this->storeDocuments($registration, $uploadedDocuments);
            $this->storePaymentProof($registration, $paymentProof, $isEdit);

            return $registration;
        });
    }

    private function storeDocuments(Registration $registration, array $uploadedDocuments): void
    {
        foreach ($uploadedDocuments as $documentId => $file) {
            if (!$file) {
                continue;
            }

            $old = $registration->documents()
                ->where('document_id', $documentId)
                ->first();

            if ($old && $old->file_path) {
                Storage::disk('public')->delete($old->file_path);
            }

            $path = $file->store('documents', 'public');
            $registration->documents()->updateOrCreate(
                ['document_id' => $documentId],
                ['file_path' => $path]
            );
        }
    }

    private function storePaymentProof(Registration $registration, ?object $paymentProof, bool $isEdit): void
    {
        if (!$paymentProof || !$isEdit) {
            return;
        }

        $path = $paymentProof->store('payment-proofs', 'public');
        $oldPath = $registration->payment?->proof_file;

        $registration->payment()->updateOrCreate(
            ['registration_id' => $registration->id],
            ['proof_file' => $path]
        );

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }
    }
}
