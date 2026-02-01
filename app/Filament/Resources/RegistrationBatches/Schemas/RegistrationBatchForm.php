<?php

namespace App\Filament\Resources\RegistrationBatches\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities;
use Filament\Schemas\Schema;

class RegistrationBatchForm
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
                        TextInput::make('name')
                            ->label('Nama')
                            ->placeholder('Contoh: Penerimaan Murid Baru 2026/2027')
                            ->autofocus()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Utilities\Get $get, Utilities\Set $set, ?string $old, ?string $state) {
                                if (($get('slug') ?? '') !== str()->slug($old)) {
                                    return;
                                }

                                $set('slug', str()->slug($state));
                            })
                            ->required(),

                        TextInput::make('slug')
                            ->unique()
                            ->required(),

                        DateTimePicker::make('registration_start')
                            ->label('Tanggal buka pendaftaran')
                            ->required(),
                        DateTimePicker::make('registration_end')
                            ->label('Tanggal tutup pendaftaran')
                            ->required(),

                        Repeater::make('timeline')
                            ->label('Jadwal Pendaftaran')
                            ->columns(3)
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('title')
                                    ->label('Tahapan/Kegiatan')
                                    ->required(),
                                DatePicker::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->required(),
                                DatePicker::make('end_date')
                                    ->label('Tanggal Selesai'),
                            ])
                            ->addActionLabel('Tambah Item')
                            ->required(),
                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->inline(false)
                            ->required(),

                        Textarea::make('description')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
