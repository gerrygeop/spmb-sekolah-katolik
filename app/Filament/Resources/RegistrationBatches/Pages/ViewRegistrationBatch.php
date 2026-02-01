<?php

namespace App\Filament\Resources\RegistrationBatches\Pages;

use App\Filament\Resources\RegistrationBatches\RegistrationBatchResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRegistrationBatch extends ViewRecord
{
    protected static string $resource = RegistrationBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
