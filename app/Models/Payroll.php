<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pay_period_id',
        'reservation_id',
        'gross_salary',
        'deductions',
        'net_salary',
        'paid_at',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payPeriod()
    {
        return $this->belongsTo(PayPeriod::class);
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function employeeDetails()
    {
        return $this->hasOne(EmployeeDetail::class, 'user_id');
    }
    
}

