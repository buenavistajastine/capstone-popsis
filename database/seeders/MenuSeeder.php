<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::insert([
            ['name' => 'Rice'],
            ['name' => 'Chicken'],
            ['name' => 'Beef'],
            ['name' => 'Pork'],
            ['name' => 'Fish and Seafoods'],
            ['name' => 'Noodle/Pasta and Salads'],
            ['name' => 'Vegetable'],
            ['name' => 'Beverage'],
            ['name' => 'Dessert'],
        ]);
    }
}
