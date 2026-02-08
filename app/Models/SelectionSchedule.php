<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SelectionSchedule extends Model
{
    protected $fillable = [
        'registration_batch_id',
        'school_level',
        'title',
        'scheduled_at',
        'end_time',
        'location',
        'requirements',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'end_time' => 'datetime',
        'school_level' => \App\Enums\SchoolLevel::class,
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(RegistrationBatch::class, 'registration_batch_id');
    }

    protected function waktu(): Attribute
    {
        return Attribute::make(
            get: function () {
                $start = Carbon::parse($this->scheduled_at)->format('H:i');
                if (!$this->end_time) return "{$start} - Selesai";
                $end = Carbon::parse($this->end_time)->format('H:i');

                return "{$start} - {$end}";
            },
        );
    }
}
