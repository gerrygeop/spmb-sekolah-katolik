<?php

namespace App\Filament\Resources\SelectionSchedules\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class SelectionScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('registration_batch_id')
                            ->label('Periode Pendaftran')
                            ->relationship(
                                name: 'batch',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)
                            )
                            ->required(),

                        TextInput::make('title')
                            ->label('Nama Kegiatan Seleksi')
                            ->placeholder('Contoh: Tes Potensi Akademik')
                            ->required()
                            ->maxLength(100),

                        DateTimePicker::make('scheduled_at')
                            ->label('Waktu Pelaksanaan')
                            ->native(false)
                            ->required(),

                        TimePicker::make('end_time')
                            ->label('Waktu Selesai')
                            ->required()
                            ->native(false)
                            ->displayFormat('H:i'),

                        TextInput::make('location')
                            ->label('Lokasi/Ruang')
                            ->placeholder('Contoh: Aula Serbaguna Lt. 2')
                            ->required(),

                        Textarea::make('requirements')
                            ->label('Hal yang wajib dibawa')
                            ->placeholder('Contoh: Kartu Identitas, Alat Tulis, dsb')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
