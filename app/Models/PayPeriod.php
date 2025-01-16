<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPeriod extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

  
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
