<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([
            ['name' => 'Pending'],
            ['name' => 'Approved'], // maybe registered
            ['name' => 'Cancelled'],
            ['name' => 'Processing'],
            ['name' => 'Paid'],
            ['name' => 'Unpaid'],
            ['name' => 'Active'], //started
            ['name' => 'Inactive'], //ended
            ['name' => 'Billed'],
            ['name' => 'Accepted'],
            ['name' => 'Transaction Completed'],
            ['name' => 'Registered'],
            ['name' => 'Partially Paid'],
        ]);
    }
}
