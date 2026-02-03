<?php

namespace App\Filament\Resources\SelectionSchedules\Pages;

use App\Filament\Resources\SelectionSchedules\SelectionScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSelectionSchedule extends EditRecord
{
    protected static string $resource = SelectionScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
