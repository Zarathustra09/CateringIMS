<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::create([
            'name' => 'Liquor',
            'description' => 'All liquor-related items for catering services.',
        ]);

        Category::create([
            'name' => 'Equipment',
            'description' => 'All equipment-related items for catering services.',
        ]);
    }
}
