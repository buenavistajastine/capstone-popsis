<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use PDF;
use Carbon\Carbon;
use App\Models\Dish;
use App\Models\Type;
use App\Models\Motif;
use App\Models\Billing;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\BookingDishKey;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class PrintController extends Controller
{
    public function PrintModule($id)
    {
        $booking = Booking::find($id);
        $billing = Billing::where('booking_id', $booking->id)->first();
        $types = Type::all();
        $bookingdishkey = BookingDishKey::where('booking_id', $id)->get();
        $dishes = $booking->dishes;
        $addons = $booking->dishess;
        $customer = Customer::where('id', $booking->customer_id)->first();

        return view('layouts.prints.module', compact('booking', 'dishes', 'customer', 'addons', 'types', 'billing'));
    }

    // Print dishes for kitchen staff
    // public function printDishes()
    // {
    //     $dishes = session('dishes', []);
    //     dd($dishes);

    //     $groupedDishes = collect($dishes)->groupBy('dish.menu.name');

    //     $pdf = PDF::loadView('layouts.prints.print-dishes', compact('groupedDishes'))->setPaper('letter', 'portrait')->output();
    //     return response()->streamDownload(
    //         fn () => print($pdf),
    //         "dishes.pdf"
    //     );
    // }

    public function printDishes()
    {
        $dishes = session('dishes', []);
        $selectedBookings = session('selectedBookings', []);

        $fileName = 'Booking_' . $selectedBookings->pluck('date_event')->unique()->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->implode('_') . '.pdf';

        $groupedDishes = collect($dishes)->groupBy('dish.menu.name');

        $pdfContent = view('layouts.prints.print-dishes', compact('groupedDishes'))->render();

        return PDF::loadHTML($pdfContent)->setPaper('letter', 'portrait')->download($fileName);
    }

    public function printOrderDishes()
    {
        $orderDishes = session('orderDishes', []);
        $selectedOrders = session('selectedOrders', []);

        $fileName = 'Order_' . $selectedOrders->pluck('date_need')->unique()->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->implode('_') . '.pdf';

        $groupedDishes = collect($orderDishes)->groupBy('dish.menu.name');

        $pdfContent = view('layouts.prints.print-dishes', compact('groupedDishes'))->render();

        return PDF::loadHTML($pdfContent)->setPaper('letter', 'portrait')->download($fileName);
    }

    public function claimSlip($id) {
        $date = Carbon::now()->format('F d, Y');
        $billing = Billing::find($id);
        $booking_dish_key = BookingDishKey::where('booking_id', $billing->booking_id)->get();
        $add_ons = AddOn::where('booking_id', $billing->booking_id)->get();
        $booking = Booking::where('id', $billing->booking_id)->first();

        // dd($add_ons);
        return view('layouts.prints.claim-slip', compact('billing', 'booking_dish_key', 'booking', 'date', 'add_ons'));
    }

}
