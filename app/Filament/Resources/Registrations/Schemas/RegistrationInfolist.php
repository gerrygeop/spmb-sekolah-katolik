<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;

class RegistrationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->columnSpan(3)
                    ->schema([
                        Section::make('Berkas Pendaftar')
                            ->collapsible()
                            ->schema([
                                RepeatableEntry::make('documents')
                                    ->schema([
                                        // Nama dokumen (dari tabel documents)
                                        TextEntry::make('document.name')
                                            ->hiddenLabel('Jenis Dokumen')
                                            ->weight('bold'),

                                        // Link file
                                        TextEntry::make('file_path')
                                            ->hiddenLabel()
                                            ->icon('heroicon-o-document-text')
                                            ->formatStateUsing(fn() => 'Lihat Berkas')
                                            ->url(fn($state) => $state ? asset('storage/' . $state) : null)
                                            ->openUrlInNewTab()
                                            ->color('primary'),
                                    ])
                                    ->hiddenLabel()
                                    ->grid(4)
                                    ->placeholder('Tidak ada berkas yang diupload'),
                            ])
                            ->footerActions([
                                Action::make('downloadAllDocuments')
                                    ->label('Download Semua Berkas')
                                    ->icon('heroicon-o-arrow-down-tray')
                                    ->color('success')
                                    ->action(function ($record) {
                                        try {
                                            $service = new \App\Services\DownloadDocumentService();
                                            return $service->downloadAllDocuments($record);
                                        } catch (\Exception $e) {
                                            \Filament\Notifications\Notification::make()
                                                ->title('Gagal Download Berkas')
                                                ->body($e->getMessage())
                                                ->danger()
                                                ->send();
                                        }
                                    }),
                            ])
                            ->footerActionsAlignment(Alignment::Right),

                        Section::make('Bukti Pembayaran')
                            ->columns(2)
                            ->collapsible()
                            ->schema([
                                TextEntry::make('payment.proof_file')
                                    ->label('Bukti Transfer')
                                    ->icon('heroicon-o-banknotes')
                                    ->formatStateUsing(fn() => 'Lihat Bukti Pembayaran')
                                    ->url(fn($state) => $state ? asset('storage/' . $state) : null)
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->visible(fn($record) => filled(optional($record->payment)->proof_file)),

                                TextEntry::make('payment.created_at')
                                    ->label('Tanggal Upload')
                                    ->dateTime('d M Y H:i')
                                    ->color('gray')
                                    ->visible(fn($record) => filled(optional($record->payment)->proof_file)),
                            ])
                            ->footerActions([
                                Action::make('downloadProofOfPayment')
                                    ->label('Download Bukti Pembayaran')
                                    ->icon('heroicon-o-arrow-down-tray')
                                    ->color('success')
                                    ->action(function ($record) {
                                        try {
                                            $service = new \App\Services\DownloadDocumentService();
                                            return $service->downloadProofOfPayment($record);
                                        } catch (\Exception $e) {
                                            \Filament\Notifications\Notification::make()
                                                ->title('Gagal Download Bukti Pembayaran')
                                                ->body($e->getMessage())
                                                ->danger()
                                                ->send();
                                        }
                                    }),
                            ])
                            ->footerActionsAlignment(Alignment::Right)
                            ->visible(fn($record) => $record->payment !== null),

                        Section::make('Informasi Siswa')
                            ->columns(2)
                            ->collapsible()
                            ->schema([
                                TextEntry::make('student.full_name')
                                    ->label('Nama Lengkap'),

                                TextEntry::make('student.nisn')
                                    ->label('NISN'),

                                TextEntry::make('student.email')
                                    ->label('Email'),

                                TextEntry::make('student.phone_number')
                                    ->label('Nomor Telepon'),

                                TextEntry::make('student.gender')
                                    ->label('Jenis Kelamin'),

                                TextEntry::make('student.ttl')
                                    ->label('Tempat, Tanggal Lahir'),

                                TextEntry::make('student.address')
                                    ->label('Alamat')
                                    ->columnSpanFull(),

                                TextEntry::make('student.previous_school')
                                    ->label('Sekolah Sebelumnya'),
                            ])
                            ->columns(2),

                        Section::make('Identias Orang Tua')
                            ->columns(2)
                            ->collapsible()
                            ->schema([
                                TextEntry::make('parent.father_name')
                                    ->label('Nama Ayah'),

                                TextEntry::make('parent.father_phone')
                                    ->label('Nomor Telepon Ayah'),

                                TextEntry::make('parent.father_occupation')
                                    ->label('Pekerjaan Ayah')
                                    ->columnSpanFull(),

                                TextEntry::make('parent.mother_name')
                                    ->label('Nama Ibu'),

                                TextEntry::make('parent.mother_phone')
                                    ->label('Nomor Telepon Ibu'),

                                TextEntry::make('parent.mother_occupation')
                                    ->label('Pekerjaan Ibu')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                    ]),

                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make('Status Pendaftaran')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('status')
                                    ->badge(),

                                TextEntry::make('notes')
                                    ->placeholder('-')
                                    ->columnSpanFull(),

                                TextEntry::make('updated_at')
                                    ->label('Terakhir diperbarui')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),

                        Section::make('Informasi Pendaftaran')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('registration_code')
                                    ->label('Nomor Pendaftaran'),

                                TextEntry::make('school_level')
                                    ->label('Jenjang Pendidikan'),

                                TextEntry::make('total_amount')
                                    ->label('Total Biaya')
                                    ->money('IDR', true)
                                    ->placeholder('-')
                                    ->columnSpanFull(),

                                TextEntry::make('created_at')
                                    ->label('Tanggal mendaftar')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                    ]),
            ])
            ->columns(5);
    }
}
