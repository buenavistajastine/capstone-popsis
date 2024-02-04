<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Type;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\BookingDishKey;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use PDF;

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

    // Print dishes for kitchen staff
    public function printDishes()
    {
       // Retrieve the dishes array from the session
    $dishes = session('dishes', []);

    // Group dishes by menu
    $groupedDishes = collect($dishes)->groupBy('dish.menu.name');

    // Generate PDF view
    $pdf = PDF::loadView('layouts.prints.print-dishes', compact('groupedDishes'))->setPaper('letter', 'portrait')->output();

    return response()->streamDownload(
        fn () => print($pdf),
        "dishes.pdf"
    );
    }

}
