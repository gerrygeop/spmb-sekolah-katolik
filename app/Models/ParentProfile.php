<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentProfile extends Model
{
    /** @use HasFactory<\Database\Factories\ParentProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'father_name',
        'father_phone',
        'father_occupation',
        'mother_name',
        'mother_phone',
        'mother_occupation',
        'guardian_name',
        'guardian_phone',
        'guardian_occupation',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
