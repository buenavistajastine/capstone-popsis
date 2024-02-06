<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\FoodOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
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

        return view('dashboard', [
            'time' => $time,
            'customers' => $customers,
            'bookings' => $bookings,
            'orders' => $orders,
            'totalEarnings' => $totalEarnings,
        ]);
    }
}
