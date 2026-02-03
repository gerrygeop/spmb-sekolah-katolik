<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class RegistrationTrendChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Tren Pendaftaran (7 Hari Terakhir)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $batchId = $this->tableFilters['batch_id'] ?? null;

        // Ambil data 7 hari terakhir
        $data = Registration::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as aggregate'))
            ->when($batchId, fn($query) => $query->where('registration_batch_id', $batchId))
            ->where('created_at', '>=', now()->subDays(6)) // 6 hari lepas + hari ini = 7 hari
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('aggregate', 'date');

        // Pastikan semua 7 hari muncul walaupun tiada pendaftaran (mengisi gap)
        $dates = collect();
        foreach (range(6, 0) as $i) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates->put($date, $data->get($date, 0));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Calon Siswa Baru',
                    'data' => $dates->values()->toArray(),
                    'fill' => 'start',
                    'tension' => 0.4, // Membuat garis melengkung (smooth)
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                ],
            ],
            'labels' => $dates->keys()->map(fn($date) => Carbon::parse($date)->translatedFormat('d M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
