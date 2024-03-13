<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Venue::insert([
            [
                'name' => 'Within Metro Dumaguete(Valencia, Sibulan, Bacong)'
            ],
            [
                'name' => 'Outside Metro Dumaguete'
            ]
        ]);
    }
}
