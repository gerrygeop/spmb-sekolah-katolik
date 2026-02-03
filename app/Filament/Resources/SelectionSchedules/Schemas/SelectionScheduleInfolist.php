<?php

namespace App\Filament\Resources\SelectionSchedules\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SelectionScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextEntry::make('batch.name')
                            ->label('Periode Pendaftaran')
                            ->badge(),

                        TextEntry::make('title')
                            ->label('Kegiatan'),

                        TextEntry::make('scheduled_at')
                            ->label('Tanggal')
                            ->dateTime('d F Y'),

                        TextEntry::make('waktu')
                            ->label('Waktu'),

                        TextEntry::make('location')
                            ->label('Lokasi'),

                        TextEntry::make('requirements')
                            ->label('Hal yang wajib dibawa')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make()
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Waktu dibuat')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Terkahir diperbarui')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),
                    ])
            ]);
    }
}
