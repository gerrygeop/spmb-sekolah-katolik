<?php

namespace App\Filament\Resources\Registrations\Pages;

use App\Enums\RegistrationStatus;
use App\Filament\Resources\Registrations\RegistrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'verifikasi' => Tab::make()->query(fn($query) => $query->where('status', RegistrationStatus::VERIFIKASI)),
            'menunggu pembayaran' => Tab::make()->query(fn($query) => $query->where('status', RegistrationStatus::PEMBAYARAN_TERTUNDA)),
            'terverifikasi' => Tab::make()->query(fn($query) => $query->where('status', RegistrationStatus::TERVERIFIKASI)),
            'perbaikan' => Tab::make()->query(fn($query) => $query->where('status', RegistrationStatus::PERBAIKAN)),
            'lulus' => Tab::make()->query(fn($query) => $query->where('status', RegistrationStatus::LULUS)),
            'tidak lulus' => Tab::make()->query(fn($query) => $query->where('status', RegistrationStatus::TIDAK_LULUS)),
            'cadangan' => Tab::make()->query(fn($query) => $query->where('status', RegistrationStatus::CADANGAN)),
        ];
    }
}
