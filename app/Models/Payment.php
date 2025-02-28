<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reservation_id',
        'checkout_link',
        'external_id',
        'status',
        'total',
    ];
    
    protected $casts = [
        'created_at' => 'datetime', // Ensure created_at is treated as a date
    ];
}
