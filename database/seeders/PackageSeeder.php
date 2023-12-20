<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::insert([
            ['name' => 'Small Package 1',
             'price' => 420,
             'description' => 'test1',
             'limitation_of_maindish' => 3,
             'minimum_pax' => 30,
             'venue_id' => null],

        ]);
    }
}
