<?php

namespace App\Filament\Resources\RegistrationBatches\Pages;

use App\Filament\Resources\RegistrationBatches\RegistrationBatchResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRegistrationBatch extends EditRecord
{
    protected static string $resource = RegistrationBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
