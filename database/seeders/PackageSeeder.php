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
            ['name' => 'Small Party Package 1',
             'price' => 420,
             'description' => 'test1',
             'limitation_of_maindish' => 8,
             'minimum_pax' => 30,
             'venue_id' => 1],
            ['name' => 'Small Party Package 2',
             'price' => 455,
             'description' => 'test1',
             'limitation_of_maindish' => 9,
             'minimum_pax' => 30,
             'venue_id' => 1],

            //  Regular Package
            ['name' => 'Regular Package 1',
             'price' => 345,
             'description' => 'test1',
             'limitation_of_maindish' => 8,
             'minimum_pax' => 100,
             'venue_id' => 1],
            ['name' => 'Regular Package 2',
             'price' => 370,
             'description' => 'test1',
             'limitation_of_maindish' => 9,
             'minimum_pax' => 50,
             'venue_id' => 1],

            //  Wedding Package
            ['name' => 'Wedding Package 1',
             'price' => 370,
             'description' => 'test1',
             'limitation_of_maindish' => 8,
             'minimum_pax' => 50,
             'venue_id' => 1],
            ['name' => 'Wedding Package 1',
             'price' => 395,
             'description' => 'test1',
             'limitation_of_maindish' => 9,
             'minimum_pax' => 50,
             'venue_id' => 1],

// OUTSIDE METRO DUMAGUETE VENUES

            // Small Packages
             ['name' => 'Small Party Package 1',
             'price' => 445,
             'description' => 'test1',
             'limitation_of_maindish' => 8,
             'minimum_pax' => 30,
             'venue_id' => 2],
             ['name' => 'Small Party Package 2',
             'price' => 470,
             'description' => 'test1',
             'limitation_of_maindish' => 9,
             'minimum_pax' => 30,
             'venue_id' => 2],

            //  Regular Packages
             ['name' => 'Regular Package 1',
             'price' => 370,
             'description' => 'test1',
             'limitation_of_maindish' => 8,
             'minimum_pax' => 100,
             'venue_id' => 2],
             ['name' => 'Regular Package 2',
             'price' => 395,
             'description' => 'test1',
             'limitation_of_maindish' => 9,
             'minimum_pax' => 50,
             'venue_id' => 2],

            //  Wedding Packages
             ['name' => 'Wedding Package 1',
             'price' => 395,
             'description' => 'test1',
             'limitation_of_maindish' => 8,
             'minimum_pax' => 50,
             'venue_id' => 2],
             ['name' => 'Wedding Package 1',
             'price' => 420,
             'description' => 'test1',
             'limitation_of_maindish' => 9,
             'minimum_pax' => 50,
             'venue_id' => 2],
        ]);
    }
}
