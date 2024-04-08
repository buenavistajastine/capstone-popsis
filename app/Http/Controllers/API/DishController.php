<?php

namespace App\Http\Controllers\API;

use App\Models\Dish;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Billing;
use App\Models\Booking;
use App\Models\BookingDishKey;
use App\Models\FoodOrder;
use App\Models\FoodOrderDishKey;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class DishController extends Controller
{

    // Dish Methods
    public function dishList()
    {
        $dishes = Dish::all();

        return response()->json(['data' => $dishes], 200);
    }

    public function viewDish(Request $request, $id)
    {
        $dish = Dish::find($id);

        if (!$dish) {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        return response()->json(['data' => $dish], 200);
    }


    // Package Methods
    public function packageList()
    {
        $packages = Package::all();

        return response()->json(['data' => $packages], 200);
    }

    public function viewPackage(Request $request, $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        return response()->json(['data' => $package], 200);
    }

    public function foodOrder(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'total_amount' => 'required',
            'transport_id' => 'required',
            'remarks' => 'nullable',
            'dishIds' => 'required|array', // Ensure dishIds is present and an array
            'quantities' => 'required|array', // Ensure quantities is present and an array
            'dishIds.*' => 'required', // Ensure each dish ID is present
            'quantities.*' => 'required', // Ensure each quantity is present Jastine Earl Buenavista
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Order failed. Please check your input.',
                'errors' => $validator->errors()
            ], 422)->header('Content-Type', 'application/json');
        }

        // Create the food order
        $order = FoodOrder::create([
            'customer_id' => $request->customer_id,
            'date_need' => $request->date,
            'call_time' => $request->time,
            'total_price' => $request->total_amount,
            'transport_id' => $request->transport_id,
            'remarks' => $request->remarks,
            'status_id' => 1,
        ]);

        $currentYear = "ORD";
        $paddedRowId = str_pad($order->id, 6, '0', STR_PAD_LEFT);
        $result = $currentYear . $paddedRowId;

        $order->update([
            'order_no' => $result
        ]);

        Billing::create([
            'foodOrder_id' => $order->id,
            'customer_id' => $request->customer_id,
            'total_amt' => $request->total_amount,
            'status_id' => 6,
        ]);

        // Create food order dish keys
        foreach ($request->dishIds as $index => $dishId) {
            FoodOrderDishKey::create([
                'order_id' => $order->id,
                'dish_id' => $dishId,
                'quantity' => $request->quantities[$index],
                'status_id' => 1, // Example status ID
            ]);
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'order' => $order
        ], 200)->header('Content-Type', 'application/json');
    }

    public function booking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "customer_id" => 'required',
            "package_id" => 'required',
            "venue_id" => 'required',
            "event_name" => 'required',
            "no_pax" => 'required',
            "date_event" => 'required',
            "call_time" => 'required',
            "total_price" => 'required',
            "color" => 'required',
            "color2" => 'required',
            "remarks" => 'nullable',
            'dishIds' => 'required|array',
            'dishIds.*' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'venue_address' => 'required',
            'specific_address' => 'nullable',
            'landmark' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Booking failed. Please check your input.',
                'errors' => $validator->errors()
            ], 422)->header('Content-Type', 'application/json');
        }

        $booking = Booking::create([
            'customer_id' => $request->customer_id,
            'package_id' => $request->package_id,
            'venue_id' => $request->venue_id,
            'event_name' => $request->event_name,
            'no_pax' => $request->no_pax,
            'date_event' => $request->date_event,
            'call_time' => $request->call_time,
            'total_price' => $request->total_price,
            'color' => $request->color,
            'color2' => $request->color2,
            'remarks' => $request->remarks,

        ]);

        Address::create([
            'booking_id' => $booking->id,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'venue_address' => $request->venue_address,
            'specific_address' => $request->specific_address,
            'landmark' => $request->landmark,
        ]);

        $currentYear = "BKG";
        $paddedRowId = str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $result = $currentYear . $paddedRowId;

        $booking->update([
            'booking_no' => $result
        ]);

        Billing::create([
            'booking_id' => $booking->id,
            'customer_id' => $request->customer_id,
            'total_amt' => $request->total_price,
            'status_id' => 6,
        ]);

        foreach ($request->dishIds as $index => $dishId) {
            BookingDishKey::create([
                'booking_id' => $booking->id,
                'dish_id' => $dishId,
                'quantity' => 1,
                'status_id' => 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'booking' => $booking
        ], 200)->header(
            'Content-Type',
            'application/json'
        );
    }
}
