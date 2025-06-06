<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationMenu extends Model
{
    use HasFactory;

    protected $table = 'reservation_menus';

    protected $fillable = [
        'reservation_id',
        'menu_id'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'reservationmenu_id');
    }
}
