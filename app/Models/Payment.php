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
        'amount_paid',
        'is_down_payment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'is_down_payment' => 'boolean',
        'amount_paid' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
