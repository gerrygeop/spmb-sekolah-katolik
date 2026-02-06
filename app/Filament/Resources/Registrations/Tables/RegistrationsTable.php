<?php

namespace App\Filament\Resources\Registrations\Tables;

use App\Enums\RegistrationStatus;
use App\Enums\SchoolLevel;
use App\Enums\UserRole;
use App\Filament\Exports\RegistrationExporter;
use App\Models\RegistrationBatch;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration_code')
                    ->label('Nomor Pendaftaran')
                    ->disabledClick()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('student.full_name')
                    ->label('Nama Lengkap')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('student.nisn')
                    ->label('NISN')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('student.email')
                    ->label('Email')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('student.phone_number')
                    ->label('No. Hp')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('school_level')
                    ->label('Jenjang Pendidikan')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('status')
                    ->toggleable()
                    ->badge(),

                TextColumn::make('total_amount')
                    ->label('Total Pembayaran')
                    ->money('IDR', true)
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(
                        collect(RegistrationStatus::cases())
                            ->mapWithKeys(fn(RegistrationStatus $status) => [
                                $status->value => $status->getLabel()
                            ])
                    ),

                SelectFilter::make('registration_batch_id')
                    ->label('Periode/Gelombang')
                    ->options(RegistrationBatch::pluck('name', 'id'))
                    ->default(fn() => RegistrationBatch::query()->active()->first()?->id)
                    ->selectablePlaceholder(false),

                SelectFilter::make('school_level')
                    ->label('Jenjang Pendidikan')
                    ->visible(auth()->user()->role === UserRole::ADMIN)
                    ->options(
                        collect(SchoolLevel::cases())
                            ->mapWithKeys(fn(SchoolLevel $level) => [
                                $level->value => str()->upper($level->value)
                            ])
                    )
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                ExportBulkAction::make()
                    ->exporter(RegistrationExporter::class)
                    ->columnMappingColumns(2)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ]);
    }
}
