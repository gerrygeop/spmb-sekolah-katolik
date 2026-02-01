<?php

namespace App\Filament\Resources\RegistrationBatches\Pages;

use App\Filament\Resources\RegistrationBatches\RegistrationBatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRegistrationBatches extends ListRecords
{
    protected static string $resource = RegistrationBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
