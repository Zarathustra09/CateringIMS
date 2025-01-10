<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryEvent;

class CategoryEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */ 
    public function run(): void
    {
        CategoryEvent::create([
            'name' => 'Wedding',
           
        ]);

        CategoryEvent::create([
            'name' => 'Event',
            
        ]);

        CategoryEvent::create([
            'name' => 'Debut',
        ]);
        
        CategoryEvent::create([
            'name' => 'Birthday Parties',
        ]);
        
        CategoryEvent::create([
            'name' => 'Corporate Events',
        ]);
        
        CategoryEvent::create([
            'name' => 'Holiday Parties',
        ]);
        
        CategoryEvent::create([
            'name' => 'Social Events',
        ]);
    }
}
