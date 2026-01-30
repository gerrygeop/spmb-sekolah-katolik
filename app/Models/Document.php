<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_required',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(RegistrationDocument::class);
    }
}
