<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'service_id',
        'event_name',
        'event_type',
        'start_date',
        'end_date',
        'message',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function assignees()
    {
        return $this->hasMany(Assignee::class);
    }
    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'reservation_items')->withPivot('quantity');
    }   
    public function reservationItems()
    {
        return $this->hasMany(ReservationItems::class);
    }

    public function payPeriod()
    {
        return $this->hasMany(payPeriod::class);
    }

}
