<?php

namespace App\Filament\Resources\Registrations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration_code')
                    ->label('Nomor Pendaftaran')
                    ->searchable(),

                TextColumn::make('student.full_name')
                    ->label('Nama Lengkap')
                    ->searchable(),

                TextColumn::make('student.email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('school_level')
                    ->label('Jenjang Pendidikan')
                    ->formatStateUsing(fn(string $state): string => str()->upper($state))
                    ->sortable(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('total_amount')
                    ->label('Total Pembayaran')
                    ->money('IDR', true)
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
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
