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
                            ->schema([
                                RepeatableEntry::make('documents')
                                    ->schema([
                                        TextEntry::make('type')
                                            ->hiddenLabel()
                                            ->formatStateUsing(fn(string $state): string => str()->title($state))
                                            ->weight('bold'),
                                        TextEntry::make('file_path')
                                            ->hiddenLabel()
                                            ->icon('heroicon-o-document')
                                            ->url(fn($record) => $record ? asset('storage/' . $record->file_path) : null)
                                            ->openUrlInNewTab()
                                            ->color('primary')
                                            ->copyable(false)
                                            ->formatStateUsing(fn() => 'Lihat Berkas')
                                    ])
                                    ->hiddenLabel()
                                    ->placeholder('Tidak ada berkas yang diupload')
                                    ->grid(4),
                            ])
                            ->collapsible()
                            ->footerActions([
                                Action::make('downloadAll')
                                    ->label('Download Semua Berkas')
                                    ->icon('heroicon-o-arrow-down-tray')
                                    ->color('success')
                                    ->action(function ($record) {
                                        try {
                                            $service = new \App\Services\DownloadDocumentService();
                                            return $service->downloadAllDocuments($record);
                                        } catch (\Exception $e) {
                                            \Filament\Notifications\Notification::make()
                                                ->title('Gagal Download')
                                                ->body($e->getMessage())
                                                ->danger()
                                                ->send();
                                        }
                                    }),
                            ])
                            ->footerActionsAlignment(Alignment::Right),

                        Section::make('Personal Information')
                            ->columns(2)
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

                                TextEntry::make('student.previous_school')
                                    ->label('Sekolah Sebelumnya'),

                                TextEntry::make('student.address')
                                    ->label('Alamat'),
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
                                    ->label('Jenjang Pendidikan')
                                    ->formatStateUsing(fn(string $state): string => str()->upper($state)),

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
