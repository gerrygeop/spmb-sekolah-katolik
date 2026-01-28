<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    protected $fillable = [
        'registration_id',
        'type',
        'file_path',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
