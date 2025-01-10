<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItems extends Model
{
    use HasFactory;


    protected $fillable = [
        'reservation_id', 
        'inventory_id', 
        'quantity',
    ];



    public function reservations()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

}

