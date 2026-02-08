<?php

namespace App\Filament\Resources\SelectionSchedules\Tables;

use App\Enums\SchoolLevel;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SelectionSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('batch.name')
                    ->label('Periode Pendaftaran')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('school_level')
                    ->label('Jenjang')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        $level = $state instanceof SchoolLevel ? $state : SchoolLevel::tryFrom((string) $state);

                        return $level?->getLabel() ?? (string) $state;
                    })
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Kegiatan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('scheduled_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('waktu')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->limit(30)
                    ->searchable(),

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
                SelectFilter::make('registration_batch_id')
                    ->relationship('batch', 'name')
                    ->label('Filter Periode'),
                SelectFilter::make('school_level')
                    ->label('Filter Jenjang')
                    ->options(
                        collect(SchoolLevel::cases())
                            ->mapWithKeys(fn(SchoolLevel $level) => [
                                $level->value => $level->getLabel(),
                            ])
                            ->all()
                    )
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
