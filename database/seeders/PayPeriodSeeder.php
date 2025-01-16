<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayPeriod;

class PayPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payPeriods = ['Monthly', 'Bi-Monthly', 'Contractual'];

        foreach ($payPeriods as $payPeriod) {
            PayPeriod::create(['name' => $payPeriod]);
        }
    }
}
