<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignee extends Model
{
    use HasFactory;
    protected $table = 'assignees';
    protected $fillable = ['reservation_id', 'user_id'];

    public function reservations()
    {
        return $this->belongsTo(Reservation::class);
    }
    public function reservation() // Singular
{
    return $this->belongsTo(Reservation::class, 'reservation_id'); // Explicit foreign key
}


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
