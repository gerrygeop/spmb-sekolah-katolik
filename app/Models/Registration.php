<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status' => \App\Enums\RegistrationStatus::class,
    ];

    public function student()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function parentProfile()
    {
        return $this->hasOne(ParentProfile::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
