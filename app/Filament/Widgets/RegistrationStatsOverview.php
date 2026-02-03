<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use App\Models\RegistrationBatch;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class RegistrationStatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $batch = RegistrationBatch::query()->active()->first();
        $batchId = $this->pageFilters['batch_id'] ?? null;

        $query = Registration::query()
            ->when($batchId, fn(Builder $query) => $query->where('registration_batch_id', $batchId))->get();

        return [
            Stat::make('Total Pendaftar', $query->count())
                ->description('Total seluruh pendaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Menunggu Verifikasi', $query->where('status', 'pending')->count())
                ->description('Perlu segera diperiksa')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Selesai/Lulus', $query->where('status', 'verified')->count())
                ->description('Data siap seleksi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
