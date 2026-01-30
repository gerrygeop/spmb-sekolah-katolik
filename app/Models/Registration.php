<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    /** @use HasFactory<\Database\Factories\RegistrationFactory> */
    use HasFactory;

    protected $fillable = [
        'registration_code',
        'school_level',
        'status',
        'notes',
        'total_amount',
    ];

    protected $casts = [
        'school_level' => \App\Enums\SchooleLevel::class,
        'status' => \App\Enums\RegistrationStatus::class,
    ];

    public function student()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function parent()
    {
        return $this->hasOne(ParentProfile::class);
    }

    public function documents()
    {
        return $this->hasMany(RegistrationDocument::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(RegistrationLog::class);
    }
}
