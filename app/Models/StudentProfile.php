<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class StudentProfile extends Model
{
    /** @use HasFactory<\Database\Factories\StudentProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'full_name',
        'email',
        'phone_number',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'address',
        'nisn',
        'previous_school',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    protected function ttl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->place_of_birth . ', ' .
                Carbon::parse($this->date_of_birth)->format('d M Y'),
        );
    }
}
