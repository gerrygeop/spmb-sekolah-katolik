<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationBatch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'registration_start',
        'registration_end',
        'timeline',
        'is_active',
        'registration_fee',
        'description',
    ];

    protected $casts = [
        'timeline' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($batch) {
            if ($batch->is_active) {
                static::where('id', '!=', $batch->id)
                    ->update(['is_active' => false]);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query
            ->where('is_active', true)
            ->where('registration_start', '<=', now())
            ->where('registration_end', '>=', now());
    }

    public function registration(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
