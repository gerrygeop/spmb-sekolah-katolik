<?php

namespace App\Filament\Widgets;

use App\Enums\SchoolLevel;
use App\Enums\UserRole;
use App\Models\Registration;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class RegistrationSchoolLevelChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Pendaftar per Jenjang';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $batchId = $this->pageFilters['batch_id'] ?? null;
        $query = Registration::query();

        if ($batchId) {
            $query->where('registration_batch_id', $batchId);
        }

        $schoolLevel = $this->getRoleSchoolLevel();
        if ($schoolLevel) {
            $query->where('school_level', $schoolLevel->value);
        }

        $data = $query->selectRaw('school_level, count(*) as count')
            ->groupBy('school_level')
            ->pluck('count', 'school_level');
        // dd($data);
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Siswa',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => ['#6366f1', '#f59e0b'], // Indigo untuk SMP, Amber untuk SMA
                ],
            ],
            'labels' => $data->keys()->map(fn($key) => str($key)->upper())->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public static function canView(): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        return !in_array($user->role, [UserRole::ADMIN_SMP, UserRole::ADMIN_SMA], true);
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
