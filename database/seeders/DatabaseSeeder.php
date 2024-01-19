<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Package;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([     
            GenderSeeder::class,  
            // CivilStatusSeeder::class,
            TypeSeeder::class,
            RoleandPermissionSeeder::class,
            UserSeeder::class,
            StatusSeeder::class,
            DiscountSeeder::class,
            MenuSeeder::class,
            DishSeeder::class,
            ModeOfTransportationSeeder::class,
            ModeOfPaymentSeeder::class,
            PackageSeeder::class,
        ]);
    }
}
