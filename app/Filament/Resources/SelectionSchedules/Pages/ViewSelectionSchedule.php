<?php

namespace App\Filament\Resources\SelectionSchedules\Pages;

use App\Filament\Resources\SelectionSchedules\SelectionScheduleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSelectionSchedule extends ViewRecord
{
    protected static string $resource = SelectionScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
