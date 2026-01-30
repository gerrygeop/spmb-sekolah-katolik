<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    protected $fillable = [
        'registration_id',
        'proof_file',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
