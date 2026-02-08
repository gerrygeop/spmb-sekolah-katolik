<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\RegistrationBatch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $batch = RegistrationBatch::query()
            ->active()
            ->first();

        $timeline = collect($batch?->timeline ?? [])
            ->map(function ($item) {
                return [
                    'title' => $item['title'],
                    'date' => $this->formatDateRange(
                        $item['start_date'],
                        $item['end_date'] ?? null,
                    ),
                ];
            });

        $galleries = Gallery::query()
            ->active()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return view('welcome', compact('batch', 'timeline', 'galleries'));
    }

    private function formatDateRange($start, $end = null)
    {
        $start = Carbon::parse($start);

        if (! $end || $start->isSameDay($end)) {
            return $start->translatedFormat('j F Y');
        }

        $end = Carbon::parse($end);

        return $start->translatedFormat('j F')
            . ' – '
            . $end->translatedFormat('j F Y');
    }
}
