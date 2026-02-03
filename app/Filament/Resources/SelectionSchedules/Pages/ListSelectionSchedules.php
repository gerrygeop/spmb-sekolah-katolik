<?php

namespace App\Filament\Resources\SelectionSchedules\Pages;

use App\Filament\Resources\SelectionSchedules\SelectionScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSelectionSchedules extends ListRecords
{
    protected static string $resource = SelectionScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
