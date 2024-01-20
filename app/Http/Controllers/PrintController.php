<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDishKey;
use App\Models\Customer;
use App\Models\Type;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function PrintModule($id) {
        $booking = Booking::find($id);
        $types = Type::all();
        $bookingdishkey = BookingDishKey::where('booking_id', $id)->get();
        $dishes = $booking->dishes;
        $addons = $booking->dishess;
        $customer = Customer::where('id', $booking->customer_id)->first();

        return view ('layouts.prints.module', compact('booking', 'dishes', 'customer', 'addons', 'types'));
    }
}
