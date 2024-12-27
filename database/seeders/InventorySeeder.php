<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Inventory::create([
            'category_id' => 1, // Assuming 'Liquor' category has ID 1
            'name' => 'Red Wine',
            'quantity' => 100,
            'description' => 'A bottle of premium red wine.',
        ]);

        Inventory::create([
            'category_id' => 1, // Assuming 'Liquor' category has ID 1
            'name' => 'Whiskey',
            'quantity' => 50,
            'description' => 'A bottle of aged whiskey.',
        ]);

        Inventory::create([
            'category_id' => 2, // Assuming 'Equipment' category has ID 2
            'name' => 'Chafing Dish',
            'quantity' => 20,
            'description' => 'A metal pan with a heat source underneath, used for keeping food warm.',
        ]);

        Inventory::create([
            'category_id' => 2, // Assuming 'Equipment' category has ID 2
            'name' => 'Serving Utensils',
            'quantity' => 50,
            'description' => 'Utensils used for serving food, such as spoons, forks, and tongs.',
        ]);

        Inventory::create([
            'category_id' => 2, // Assuming 'Equipment' category has ID 2
            'name' => 'Chair',
            'quantity' => 100,
            'description' => 'Comfortable chairs for event seating.',
        ]);

        Inventory::create([
            'category_id' => 2, // Assuming 'Equipment' category has ID 2
            'name' => 'Table',
            'quantity' => 50,
            'description' => 'Sturdy tables for event use.',
        ]);
    }
}
