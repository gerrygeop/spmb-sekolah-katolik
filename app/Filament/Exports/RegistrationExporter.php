<?php

namespace App\Filament\Exports;

use App\Models\Registration;
use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class RegistrationExporter extends Exporter
{
    protected static ?string $model = Registration::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('batch.name')
                ->label('Gelombang'),

            ExportColumn::make('registration_code')
                ->label('Kode Registrasi'),

            ExportColumn::make('school_level')
                ->label('Jenjang'),

            ExportColumn::make('status')
                ->label('Status Pendaftaran'),

            // --- Data Siswa (Relasi: student) ---
            ExportColumn::make('student.full_name')
                ->label('Nama Siswa'),
            ExportColumn::make('student.nisn')
                ->label('NISN'),
            ExportColumn::make('student.email')
                ->label('Email Siswa'),
            ExportColumn::make('student.phone_number')
                ->label('No. HP Siswa'),
            ExportColumn::make('student.gender')
                ->label('Jenis Kelamin'),
            ExportColumn::make('student.ttl')
                ->label('Tempat, Tanggal Lahir'),
            ExportColumn::make('student.address')
                ->label('Alamat')
                ->enabledByDefault(false),
            ExportColumn::make('student.previous_school')
                ->label('Sekolah Asal'),

            // --- Data Orang Tua (Relasi: parent) ---
            ExportColumn::make('parent.father_name')
                ->label('Nama Ayah'),
            ExportColumn::make('parent.father_phone')
                ->label('No. HP Ayah'),
            ExportColumn::make('parent.father_occupation')
                ->label('Pekerjaan Ayah')
                ->enabledByDefault(false),
            ExportColumn::make('parent.mother_name')
                ->label('Nama Ibu'),
            ExportColumn::make('parent.mother_phone')
                ->label('No. HP Ibu'),
            ExportColumn::make('parent.mother_occupation')
                ->label('Pekerjaan Ibu')
                ->enabledByDefault(false),

            // --- Data Keuangan & Waktu ---
            ExportColumn::make('total_amount')
                ->label('Total Biaya')
                ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),

            ExportColumn::make('created_at')
                ->label('Waktu Pendaftaran')
                ->formatStateUsing(fn(string $state): string => Carbon::parse($state)->format('d/m/Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor data pendaftaran selesai. ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' baris selesai diproses.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' baris gagal diekspor.';
        }

        return $body;
    }
}
