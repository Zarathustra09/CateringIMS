<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EmployeeDetail;
use App\Models\PayPeriod; // Make sure to import PayPeriod model
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $employees = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone_number' => '9876543210',
                'position' => 'Manager',
                'department' => 'Catering',
                'salary' => 60000,
                'pay_period_name' => 'Monthly', // Changed to pay period name
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone_number' => '9876543211',
                'position' => 'Assistant Manager',
                'department' => 'Catering',
                'salary' => 55000,
                'pay_period_name' => 'Bi-Monthly', // Changed to pay period name
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'phone_number' => '9876543212',
                'position' => 'Chef',
                'department' => 'Kitchen',
                'salary' => 50000,
                'pay_period_name' => 'Contractual', // Changed to pay period name
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
                'phone_number' => '9876543213',
                'position' => 'Sous Chef',
                'department' => 'Kitchen',
                'salary' => 45000,
                'pay_period_name' => 'Monthly', // Changed to pay period name
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charlie.davis@example.com',
                'phone_number' => '9876543214',
                'position' => 'Waiter',
                'department' => 'Service',
                'salary' => 30000,
                'pay_period_name' => 'Bi-Monthly', // Changed to pay period name
            ],
            [
                'name' => 'Diana Evans',
                'email' => 'diana.evans@example.com',
                'phone_number' => '9876543215',
                'position' => 'Waitress',
                'department' => 'Service',
                'salary' => 30000,
                'pay_period_name' => 'Contractual', // Changed to pay period name
            ],
            [
                'name' => 'Eve Foster',
                'email' => 'eve.foster@example.com',
                'phone_number' => '9876543216',
                'position' => 'Bartender',
                'department' => 'Bar',
                'salary' => 35000,
                'pay_period_name' => 'Monthly', // Changed to pay period name
            ],
            [
                'name' => 'Frank Green',
                'email' => 'frank.green@example.com',
                'phone_number' => '9876543217',
                'position' => 'Dishwasher',
                'department' => 'Kitchen',
                'salary' => 25000,
                'pay_period_name' => 'Bi-Monthly', // Changed to pay period name
            ],
            [
                'name' => 'Grace Harris',
                'email' => 'grace.harris@example.com',
                'phone_number' => '9876543218',
                'position' => 'Hostess',
                'department' => 'Service',
                'salary' => 32000,
                'pay_period_name' => 'Contractual', // Changed to pay period name
            ],
            [
                'name' => 'Henry Irving',
                'email' => 'henry.irving@example.com',
                'phone_number' => '9876543219',
                'position' => 'Cleaner',
                'department' => 'Maintenance',
                'salary' => 28000,
                'pay_period_name' => 'Monthly', // Changed to pay period name
            ],
        ];

        foreach ($employees as $employee) {
            $user = User::create([
                'name' => $employee['name'],
                'email' => $employee['email'],
                'phone_number' => $employee['phone_number'],
                'password' => Hash::make('password123'),
                'role_id' => 1,
                'employee_id' => strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5)) . '-' . substr(str_shuffle('0123456789'), 0, 5),
            ]);

            // Find the pay_period_id based on pay_period_name
            $payPeriod = PayPeriod::where('name', $employee['pay_period_name'])->first();

            // If pay period is not found, create a new one
            if (!$payPeriod) {
                $payPeriod = PayPeriod::create(['name' => $employee['pay_period_name']]);
            }

            EmployeeDetail::create([
                'user_id' => $user->id,
                'position' => $employee['position'],
                'department' => $employee['department'],
                'salary' => $employee['salary'],
                'pay_period_id' => $payPeriod->id, // Use the correct pay_period_id
                'hired_at' => now(),
            ]);
        }
    }
}
