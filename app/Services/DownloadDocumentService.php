<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class DownloadDocumentService
{
    public function downloadAllDocuments(Registration $registration): BinaryFileResponse
    {
        // Eager load relationships to prevent N+1 queries
        $registration->load(['documents', 'student']);

        // Validate that there are documents to download
        if ($registration->documents->isEmpty()) {
            throw new \Exception('Tidak ada berkas yang tersedia untuk didownload.');
        }

        // Create ZIP filename: {code}_{student_name}.zip
        $studentName = $registration->student->full_name;
        $code = $registration->registration_code ?? 'unknown';
        $nama = $this->sanitizeFilename($studentName ?? 'unknown');
        $zipFilename = "{$code}_{$nama}.zip";

        // Create temporary directory if not exists
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // Create temporary ZIP file path
        $zipPath = $tempDir . '/' . Str::uuid() . '.zip';

        // Create ZIP archive
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \Exception('Gagal membuat file ZIP.');
        }

        $filesAdded = 0;

        // Add each document to ZIP
        foreach ($registration->documents as $document) {
            $filePath = storage_path('app/public/' . $document->file_path);

            // Check if file exists
            if (!file_exists($filePath)) {
                continue;
            }

            // Get file extension
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);

            // Create sanitized filename for the document
            $documentName = $this->sanitizeFilename($document->type ?? 'document');
            $documentFilename = "{$documentName}.{$extension}";

            // Handle duplicate filenames by appending counter
            $counter = 1;
            // $originalFilename = $documentFilename;
            while ($zip->locateName($documentFilename) !== false) {
                $documentFilename = "{$documentName}_{$counter}.{$extension}";
                $counter++;
            }

            // Add file to ZIP
            $zip->addFile($filePath, $documentFilename);
            $filesAdded++;
        }

        $zip->close();

        // Check if any files were added
        if ($filesAdded === 0) {
            unlink($zipPath);
            throw new \Exception('Tidak ada berkas yang valid untuk didownload.');
        }

        // Return binary file response with automatic deletion
        return response()->download($zipPath, $zipFilename, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }

    public function downloadProofOfPayment(Registration $registration): BinaryFileResponse
    {
        // Pastikan relasi payment ada
        $registration->load('payment', 'student');

        if (!$registration->payment || !$registration->payment->proof_file) {
            throw new \Exception('Bukti pembayaran tidak tersedia.');
        }

        $filePath = storage_path('app/public/' . $registration->payment->proof_file);

        if (!file_exists($filePath)) {
            throw new \Exception('File bukti pembayaran tidak ditemukan.');
        }

        // 🔐 STRICT MIME CHECK
        $mime = $this->detectMimeTypeStrict($filePath);
        $this->validateAllowedMime($mime);

        // Ambil ekstensi file
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $code = $registration->registration_code ?? 'unknown';
        $studentName = $this->sanitizeFilename($registration->student->full_name ?? 'unknown');

        // Buat nama file: {kode}_{nama}_bukti_pembayaran.ext
        $filename = "{$code}_{$studentName}_bukti_pembayaran.{$extension}";

        return response()->download(
            $filePath,
            $filename,
            [
                'Content-Type' => $mime,
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    private function sanitizeFilename(string $filename): string
    {
        // Replace spaces with underscores
        $filename = str_replace(' ', '_', $filename);

        // Remove special characters except underscores, hyphens, and alphanumeric
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '', $filename);

        // Remove multiple consecutive underscores
        $filename = preg_replace('/_+/', '_', $filename);

        // Trim underscores from start and end
        $filename = trim($filename, '_');

        return $filename ?: 'document';
    }

    private function detectMimeTypeStrict(string $filePath): string
    {
        if (!extension_loaded('fileinfo')) {
            throw new \Exception('PHP Fileinfo extension tidak tersedia.');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($filePath);

        if (!$mime) {
            throw new \Exception('Gagal mendeteksi MIME type file.');
        }

        return $mime;
    }

    private function validateAllowedMime(string $mime): void
    {
        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'application/pdf',
        ];

        if (!in_array($mime, $allowedMimes, true)) {
            throw new \Exception('Tipe file tidak diizinkan.');
        }
    }
}
