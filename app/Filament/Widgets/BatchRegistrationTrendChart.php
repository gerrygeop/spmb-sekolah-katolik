<?php

namespace App\Filament\Widgets;

use App\Enums\SchoolLevel;
use App\Enums\UserRole;
use App\Models\Registration;
use App\Models\RegistrationBatch;
use Filament\Widgets\ChartWidget;

class BatchRegistrationTrendChart extends ChartWidget
{
    protected ?string $heading = 'Tren Pendaftaran per Periode';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $batches = RegistrationBatch::orderBy('id', 'asc')->get();
        $schoolLevel = $this->getRoleSchoolLevel();

        $counts = $batches->map(function ($batch) use ($schoolLevel) {
            $query = Registration::query()->where('registration_batch_id', $batch->id);

            if ($schoolLevel) {
                $query->where('school_level', $schoolLevel->value);
            }

            return $query->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pendaftar',
                    'data' => $counts->toArray(),
                    'fill' => 'start',
                    'tension' => 0.3,
                    'borderColor' => '#10b981', // Hijau Emerald
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'pointBackgroundColor' => '#10b981',
                    'pointRadius' => 5,
                ],
            ],
            // Nama-nama gelombang sebagai label di sumbu X
            'labels' => $batches->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
