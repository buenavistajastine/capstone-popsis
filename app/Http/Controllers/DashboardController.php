<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dish;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\FoodOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $time = Carbon::now()->format('H');
        $customers = Customer::all();
        $bookings = Booking::all();
        $orders = FoodOrder::all();

        $totalEarningsBook = 0;
        $totalEarningsOrder = 0;
        $totalEarnings = 0;

        foreach ($bookings as $book) {
            if ($book->total_price !== 0) {
                $totalEarningsBook += $book->total_price;
            } else {
                $totalEarningsBook = 0;
            }
        }

        foreach ($orders as $order) {
            if ($order->total_price !== 0) {
                $totalEarningsOrder += $order->total_price;
            } else {
                $totalEarningsOrder = 0;
            }
        }

        $totalEarnings = $totalEarningsBook + $totalEarningsOrder;
        $dishes = Dish::select('dishes.*', DB::raw('(SELECT COUNT(*) FROM booking_dish_keys WHERE booking_dish_keys.dish_id = dishes.id) as dish_count'))
            ->whereNotIn('menu_id', [1, 8, 9]) // Exclude dishes under menu IDs 1, 8, and 9
            ->orderByDesc('dish_count')
            ->limit(5)
            ->get();


        return view('dashboard', [
            'time' => $time,
            'customers' => $customers,
            'bookings' => $bookings,
            'orders' => $orders,
            'totalEarnings' => $totalEarnings,
            'dishes' => $dishes,
        ]);
    }
}
