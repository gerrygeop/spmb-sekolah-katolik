<?php

namespace App\Filament\Resources\RegistrationBatches\Schemas;

use App\Models\RegistrationBatch;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegistrationBatchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nama'),

                                TextEntry::make('registration_start')
                                    ->label('Tanggal buka pendaftaran')
                                    ->dateTime('d F Y, H:i:s'),
                                TextEntry::make('registration_end')
                                    ->label('Tanggal tutup pendaftaran')
                                    ->dateTime('d F Y, H:i:s'),

                                IconEntry::make('is_active')
                                    ->label('Aktif')
                                    ->boolean(),

                                TextEntry::make('description')
                                    ->label('Keterangan')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                            ]),

                        Section::make()
                            ->schema([
                                RepeatableEntry::make('timeline')
                                    ->label('Jadwal Pendaftaran')
                                    ->schema([
                                        TextEntry::make('title')
                                            ->label('Tahapan/Kegiatan'),

                                        TextEntry::make('start_date')
                                            ->label('Tanggal Mulai')
                                            ->date('d F Y'),

                                        TextEntry::make('end_date')
                                            ->label('Tanggal Selesai')
                                            ->date('d F Y'),
                                    ])
                                    ->columns(3)
                            ])
                    ]),

                Section::make()
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->visible(fn(RegistrationBatch $record): bool => $record->trashed()),
                    ])
            ]);
    }
}
