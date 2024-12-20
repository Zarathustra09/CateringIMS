<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'department',
        'salary',
        'hired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->where('role_id', 0);
    }
}
