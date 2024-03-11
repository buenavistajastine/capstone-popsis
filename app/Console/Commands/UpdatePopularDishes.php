<?php

namespace App\Console\Commands;

use App\Models\Dish;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdatePopularDishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-popular-dishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Query to update the count of popular dishes
        $dishes = Dish::select('dishes.*', DB::raw('(SELECT COUNT(*) FROM booking_dish_keys WHERE booking_dish_keys.dish_id = dishes.id) as dish_count'))
            ->whereNotIn('menu_id', [1, 8, 9]) // Exclude dishes under menu IDs 1, 8, and 9
            ->orderByDesc('dish_count')
            ->limit(5)
            ->get();

        // Update any relevant data or perform any additional actions based on $updatedDishes

        $this->info('Popular dishes updated successfully.');
    }
}
