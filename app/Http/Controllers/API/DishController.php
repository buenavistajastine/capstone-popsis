<?php

namespace App\Http\Controllers\API;

use App\Models\Dish;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdditionalRequest;
use App\Models\Address;
use App\Models\Billing;
use App\Models\Booking;
use App\Models\BookingDishKey;
use App\Models\FoodOrder;
use App\Models\FoodOrderDishKey;
use App\Models\Menu;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class DishController extends Controller
{

    public function dish()
    {
        $dishes = Dish::with('menu')->get(); // Change 'all()' to 'get()'
    
        return response()->json(['data' => $dishes], 200);
    }

    public function menu()
    {
        $menus = Menu::all();

        return response()->json(['data' => $menus], 200);
    }

    public function venue()
    {
        $venues = Venue::all();

        return response()->json(['data' => $venues], 200);
    }
    
    // Dish Methods
    public function dishList()
    {
        $dishes = Dish::all();

        // Initialize an empty array to store modified dish data
        $modifiedDishes = [];

        // Iterate over each dish to include additional information
        foreach ($dishes as $dish) {
            // Access attributes of each dish
            $dishType = $dish->type;
            $dishMenu = $dish->menu;

            // Construct an array with desired attributes
            $modifiedDish = [
                'id' => $dish->id,
                'name' => $dish->name,
                'type' => $dishType,
                'menu' => $dishMenu,
                // Include other attributes as needed
            ];

            // Push the modified dish data to the array
            $modifiedDishes[] = $modifiedDish;
        }

        // Return the modified dish data as JSON response
        return response()->json(['data' => $modifiedDishes], 200);
    }


    public function viewDish(Request $request, $id)
    {
        $dish = Dish::find($id);

        if (!$dish) {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        return response()->json(['data' => $dish], 200);
    }

    public function viewOrder(Request $request, $id)
    {
        $order = FoodOrder::with('customers.address', 'statuses', 'transports', 'address', 'orderDish_keys')->find($id);
    
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    
        return response()->json(['data' => $order], 200);
    }

    public function viewBooking(Request $request, $id)
    {
        $order = Booking::with('customers', 'status', 'address', 'dish_keys', 'packages', 'addOns', 'billing.statuses')->find($id);
    
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    
        return response()->json(['data' => $order], 200);
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
            'dishIds' => 'required|array',
            'quantities' => 'required|array',
            'dishIds.*' => 'required',
            'quantities.*' => 'required',
        ]);

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
            'payable_amt' => $request->total_amount,
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
            "selectedPackage" => 'required',
            "selectedVenueId" => 'required',
            "eventName" => 'required',
            "noPax" => 'required',
            "date" => 'required',
            "time" => 'required',
            "totalPrice" => 'required',
            "color1" => 'nullable',
            "color2" => 'nullable',
            "remark" => 'nullable',
            "addRequest" => 'nullable',
            'selected' => 'required|array',
            'selected.*' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'venueAddress' => 'required',
            'specificAddress' => 'nullable',
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
            'package_id' => $request->selectedPackage,
            'venue_id' => $request->selectedOption,
            'event_name' => $request->eventName,
            'no_pax' => $request->noPax,
            'date_event' => $request->date,
            'call_time' => $request->time,
            'total_price' => $request->totalPrice,
            'color' => $request->color1,
            'color2' => $request->color2,
            'remarks' => $request->remark,
            'dt_booked' => Carbon::now(),
            'status_id' => 1
        ]);

        AdditionalRequest::create([
            'booking_id' => $booking->id,
            'request' => $request->addRequest
        ]);

        Address::create([
            'booking_id' => $booking->id,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'venue_address' => $request->venueAddress,
            'specific_address' => $request->specificAddress,
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
            'total_amt' => $request->totalPrice,
            'payable_amt' => $request->totalPrice,
            'status_id' => 6,
        ]);

        foreach ($request->selected as $index => $selected) {
            BookingDishKey::create([
                'booking_id' => $booking->id,
                'dish_id' => $selected,
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
