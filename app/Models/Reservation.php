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
        'category_event_id',
        'event_name',
        'start_date',
        'end_date',
        'message',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function categoryEvent()
    {
        return $this->belongsTo(CategoryEvent::class, 'category_event_id');
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
        return $this->hasMany(PayPeriod::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'reservation_id', 'id');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'reservation_menus');
    }
}
