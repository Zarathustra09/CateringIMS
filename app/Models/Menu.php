<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'reservationmenu_id' // Add this line
    ];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_menus');
    }
}
