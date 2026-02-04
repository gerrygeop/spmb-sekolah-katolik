<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use App\Models\RegistrationBatch;
use Filament\Widgets\ChartWidget;

class BatchRegistrationTrendChart extends ChartWidget
{
    protected ?string $heading = 'Tren Pendaftaran per Periode';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $batches = RegistrationBatch::orderBy('id', 'asc')->get();

        $counts = $batches->map(function ($batch) {
            return Registration::where('registration_batch_id', $batch->id)->count();
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
}
