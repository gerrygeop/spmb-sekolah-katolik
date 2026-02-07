<?php

namespace App\Filament\Widgets;

use App\Enums\RegistrationStatus;
use App\Enums\SchoolLevel;
use App\Enums\UserRole;
use App\Models\Registration;
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
        $batchId = $this->pageFilters['batch_id'] ?? null;

        $query = Registration::query()
            ->when($batchId, fn(Builder $query) => $query->where('registration_batch_id', $batchId));

        $schoolLevel = $this->getRoleSchoolLevel();
        if ($schoolLevel) {
            $query->where('school_level', $schoolLevel->value);
        }

        return [
            Stat::make('Total Pendaftar', (clone $query)->count())
                ->description('Total seluruh pendaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Menunggu Verifikasi', (clone $query)->where('status', RegistrationStatus::VERIFIKASI)->count())
                ->description('Perlu segera diperiksa')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Terverifikasi', (clone $query)->where('status', RegistrationStatus::TERVERIFIKASI)->count())
                ->description('Data siap seleksi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }

    public function getColumns(): int | array
    {
        return 3;
    }

    private function getRoleSchoolLevel(): ?SchoolLevel
    {
        $user = auth()->user();

        if (!$user) {
            return null;
        }

        return match ($user->role) {
            UserRole::ADMIN_SMP => SchoolLevel::SMP,
            UserRole::ADMIN_SMA => SchoolLevel::SMA,
            default => null,
        };
    }
}
