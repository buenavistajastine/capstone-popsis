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

        return view('dashboard', [
            'time' => $time,
            'customers' => $customers,
            'bookings' => $bookings,
            'orders' => $orders,
        ]);
    }
}
