<?php

namespace App\Filament\Widgets;

use App\Enums\RegistrationStatus;
use App\Enums\SchoolLevel;
use App\Enums\UserRole;
use App\Models\Registration;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class RegistrationStatusChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    public function getHeading(): ?string
    {
        $schoolLevel = $this->getRoleSchoolLevel();

        if (!$schoolLevel) {
            return 'Status Pendaftaran';
        }

        return 'Status Pendaftaran - ' . str($schoolLevel->value)->upper();
    }

    protected function getData(): array
    {
        $batchId = $this->pageFilters['batch_id'] ?? null;
        $schoolLevel = $this->getRoleSchoolLevel();

        $query = Registration::query()
            ->when($batchId, fn(Builder $query) => $query->where('registration_batch_id', $batchId))
            ->when($schoolLevel, fn(Builder $query) => $query->where('school_level', $schoolLevel->value));

        $raw = $query
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statuses = RegistrationStatus::cases();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pendaftar',
                    'data' => array_map(
                        fn(RegistrationStatus $status) => $raw[$status->value] ?? 0,
                        $statuses
                    ),
                    'backgroundColor' => [
                        '#60a5fa',
                        '#f97316',
                        '#facc15',
                        '#38bdf8',
                        '#22c55e',
                        '#a78bfa',
                        '#f87171',
                    ],
                ],
            ],
            'labels' => array_map(
                fn(RegistrationStatus $status) => $status->getLabel(),
                $statuses
            ),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
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
