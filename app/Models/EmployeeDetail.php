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
        'pay_period_id',
        'department',
        'salary',
        'hired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->where('role_id', 0);
    }
    public function payPeriod()
    {
        return $this->belongsTo(PayPeriod::class);
    }

    public function payPeriodid()
    {
        return $this->belongsTo(PayPeriod::class, 'pay_period_id');
    }

}
