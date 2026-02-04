<?php

namespace App\Filament\Widgets;

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
        $batchId = $this->tableFilters['batch_id'] ?? null;

        $data = StudentProfile::query()
            ->join('registrations', 'student_profiles.registration_id', '=', 'registrations.id')
            ->when($batchId, fn($query) => $query->where('registrations.registration_batch_id', $batchId))
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
}
