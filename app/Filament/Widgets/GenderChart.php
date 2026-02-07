<?php

namespace App\Filament\Widgets;

use App\Enums\SchoolLevel;
use App\Enums\UserRole;
use App\Models\StudentProfile;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class GenderChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Rasio Jenis Kelamin';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $batchId = $this->pageFilters['batch_id'] ?? null;
        $schoolLevel = $this->getRoleSchoolLevel();

        $data = StudentProfile::query()
            ->join('registrations', 'student_profiles.registration_id', '=', 'registrations.id')
            ->when($batchId, fn($query) => $query->where('registrations.registration_batch_id', $batchId))
            ->when($schoolLevel, fn($query) => $query->where('registrations.school_level', $schoolLevel->value))
            ->select('student_profiles.gender', DB::raw('count(*) as count'))
            ->groupBy('student_profiles.gender')
            ->pluck('count', 'gender')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jenis Kelamin',
                    'data' => [
                        $data['Laki-laki'] ?? 0,
                        $data['Perempuan'] ?? 0
                    ],
                    'backgroundColor' => [
                        '#3b82f6', // Biru untuk Laki-laki
                        '#ec4899', // Pink untuk Perempuan
                    ],
                    'hoverOffset' => 4
                ],
            ],
            'labels' => ['Laki-laki', 'Perempuan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
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
