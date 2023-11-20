<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([     
            // GenderSeeder::class,  
            // CivilStatusSeeder::class,
            // PositionSeeder::class,
            // RoleandPermissionSeeder::class,
            // UserSeeder::class,
            // StatusSeeder::class,
            // DiscountSeeder::class,
            // MenuSeeder::class,
            // ModeOfTransportationSeeder::class,
            ModeOfPaymentSeeder::class,
        ]);
    }
}
