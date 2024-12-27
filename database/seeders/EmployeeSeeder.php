<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EmployeeDetail;
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
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone_number' => '9876543211',
                'position' => 'Assistant Manager',
                'department' => 'Catering',
                'salary' => 55000,
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'phone_number' => '9876543212',
                'position' => 'Chef',
                'department' => 'Kitchen',
                'salary' => 50000,
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
                'phone_number' => '9876543213',
                'position' => 'Sous Chef',
                'department' => 'Kitchen',
                'salary' => 45000,
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charlie.davis@example.com',
                'phone_number' => '9876543214',
                'position' => 'Waiter',
                'department' => 'Service',
                'salary' => 30000,
            ],
            [
                'name' => 'Diana Evans',
                'email' => 'diana.evans@example.com',
                'phone_number' => '9876543215',
                'position' => 'Waitress',
                'department' => 'Service',
                'salary' => 30000,
            ],
            [
                'name' => 'Eve Foster',
                'email' => 'eve.foster@example.com',
                'phone_number' => '9876543216',
                'position' => 'Bartender',
                'department' => 'Bar',
                'salary' => 35000,
            ],
            [
                'name' => 'Frank Green',
                'email' => 'frank.green@example.com',
                'phone_number' => '9876543217',
                'position' => 'Dishwasher',
                'department' => 'Kitchen',
                'salary' => 25000,
            ],
            [
                'name' => 'Grace Harris',
                'email' => 'grace.harris@example.com',
                'phone_number' => '9876543218',
                'position' => 'Hostess',
                'department' => 'Service',
                'salary' => 32000,
            ],
            [
                'name' => 'Henry Irving',
                'email' => 'henry.irving@example.com',
                'phone_number' => '9876543219',
                'position' => 'Cleaner',
                'department' => 'Maintenance',
                'salary' => 28000,
            ],
        ];

        foreach ($employees as $employee) {
            $user = User::create([
                'name' => $employee['name'],
                'email' => $employee['email'],
                'phone_number' => $employee['phone_number'],
                'password' => Hash::make('password123'),
                'role_id' => 0,
                'employee_id' => strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5)) . '-' . substr(str_shuffle('0123456789'), 0, 5),
            ]);

            EmployeeDetail::create([
                'user_id' => $user->id,
                'position' => $employee['position'],
                'department' => $employee['department'],
                'salary' => $employee['salary'],
                'hired_at' => now(),
            ]);
        }
    }
}
