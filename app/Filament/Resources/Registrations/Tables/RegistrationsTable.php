<?php

namespace App\Filament\Resources\Registrations\Tables;

use App\Enums\RegistrationStatus;
use App\Enums\SchooleLevel;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

                SelectFilter::make('school_level')
                    ->label('Jenjang Pendidikan')
                    ->options(
                        collect(SchooleLevel::cases())
                            ->mapWithKeys(fn(SchooleLevel $level) => [
                                $level->value => str()->upper($level->value)
                            ])
                    )
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
