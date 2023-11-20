<?php

namespace Database\Seeders;

use App\Models\ModeOfTransportation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModeOfTransportationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModeOfTransportation::insert([
            ['name' => 'Pick-up'],
            ['name' => 'Deliver']
        ]);
    }
}
