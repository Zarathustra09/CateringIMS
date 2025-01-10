<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryEvent extends Model
{
    use HasFactory;

    protected $table = 'category_events';

    protected $fillable = ['name'];
    public $timestamps = false;

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
}

