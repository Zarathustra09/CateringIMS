<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'quantity', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function reservationItems()
    {
        return $this->hasMany(ReservationItems::class);
    }
}
