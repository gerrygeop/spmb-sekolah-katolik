<?php

namespace App\Filament\Pages;

use App\Models\RegistrationBatch;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpan(2)
                    ->schema([
                        Select::make('batch_id')
                            ->label('Periode/Gelombang')
                            ->options(RegistrationBatch::pluck('name', 'id'))
                            ->default(fn() => RegistrationBatch::query()->active()->first()?->id)
                            ->placeholder('Semua Periode')
                            ->selectablePlaceholder(false),
                    ])
            ]);
    }
}
