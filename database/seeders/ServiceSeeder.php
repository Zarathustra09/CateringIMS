<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Service::create([
            'name' => 'Basic Catering',
            'description' => 'Basic catering service with standard menu options.',
            'price' => 5000.00,
        ]);

        Service::create([
            'name' => 'Premium Catering',
            'description' => 'Premium catering service with gourmet menu options.',
            'price' => 10000.00,
        ]);

        Service::create([
            'name' => 'Event Catering',
            'description' => 'Catering service for large events and gatherings.',
            'price' => 50000.00,
        ]);
    }
}
