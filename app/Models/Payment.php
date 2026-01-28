<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    protected $fillable = [
        'registration_id',
        'amount',
        'status',
        'snap_token',
        'order_id',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
