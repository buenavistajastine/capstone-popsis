<?php

namespace App\Http\Controllers\API;

use App\Models\Dish;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\FoodOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            $customerDetail = $user->customers->address;
            $user->address = $customerDetail;
            $user->customers = $customerDetail;
            $token = $user->createToken('mobile')->plainTextToken;

            // Include user information along with the token
            return response([
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response(['message' => 'Email or password wrong'], 401);
    }

    public function userDetails(): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Include the address information in the response
            $customerDetail = $user->customers->address;
            $user->address = $customerDetail;
            $user->customers = $customerDetail;
            return Response(['data' => $user], 200);
        }
        return Response(['data' => 'Unauthorized'], 401);
    }

    // public function loginUser(Request $request)
    // {
    //     $validator = Validator::make($request->only('email', 'password'), [
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     if (!$token = auth()->guard('api')->attempt($validator->validated())) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Login failed',
    //             'errors' => ['email' => 'These credentials do not match our records.']
    //         ], 401);
    //     }

    //     $userId = auth()->guard('api')->id();
    //     // $patient = $this->getPatientInfo($userId);
    //     $patient = $this->getPatientInfo($userId) ?? new Patient;
    //     $patient->load([
    //         'bookingsss.physicalExamination.doctor',
    //         'bookingsss.vaccine.covid_vaccine',
    //         'bookingsss.doctorFindings.finding',
    //         'bookingsss.habit',  // Corrected relationship path
    //         'bookingsss.mental_health', 
    //         'bookingsss.diagnosticExamination',
    //         'bookingsss.service_key' => function ($query) {
    //             $query->with(['service', 'result_keys.results.units']);
    //         },
    //         'genders',
    //         'status',
    //         'civil_statuses',
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Login successful',
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->guard('api')->factory()->getTTL() * 86400,
    //         'user' => auth()->guard('api')->user(),
    //         'patient' => $patient,
    //     ])->header('Content-Type', 'application/json');

    // }

    public function booking(Request $request): JsonResponse
    {
        try {
            $customer = $request->user()->customers;

            if (!$customer) {
                return response()->json(['error' => 'User is not associated with a customer'], 400);
            }

            $bookings = Booking::where('customer_id', $customer->id)->get();

            return response()->json($bookings);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch booking data.'], 500);
        }
    }

    public function order(Request $request): JsonResponse
    {
        try {
            $customer = $request->user()->customers;

            if (!$customer) {
                return response()->json(['error' => 'User is not associated with a customer'], 400);
            }

            $orders = FoodOrder::where('customer_id', $customer->id)->get();

            return response()->json($orders);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch order data.'], 500);
        }
    }


    public function popular()
    {
        try {
            $populars = Dish::select('dishes.*', DB::raw('(SELECT COUNT(*) FROM booking_dish_keys WHERE booking_dish_keys.dish_id = dishes.id) + 
                                                         (SELECT COUNT(*) FROM food_order_dish_keys WHERE food_order_dish_keys.dish_id = dishes.id) as dish_count'))
                ->whereNotIn('menu_id', [1, 8, 9])
                ->orderByDesc('dish_count')
                ->limit(5)
                ->get();
    
            return $populars;
        } catch (\Exception $e) {
            // Log the error or handle it in any other way you prefer
            Log::error('Error fetching popular dishes: ' . $e->getMessage());
            return null; // Or return an empty array, or handle the error in any other way
        }
    }
    


    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->only('first_name', 'middle_name', 'last_name', 'email', 'password', 'city', 'barangay', 'specific_address', 'landmark', 'contact_no'), [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => 'string',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required', 'string', 'min:8' /*'confirmed'*/],
            'city' => ['nullable', 'string'],
            'barangay' => ['nullable', 'string'],
            'specific_address' => ['nullable', 'string'],
            'landmark' => ['nullable', 'string'],
            'contact_no' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please check your input.',
                'errors' => $validator->errors()
            ], 422)->header('Content-Type', 'application/json');
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customer = Customer::create([
            'user_id' => $user->id,
            'contact_no' => $request->contact_no,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
        ]);

        $address = CustomerAddress::create([
            'customer_id' => $customer->id,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'specific_address' => $request->specific_address,
            'landmark' => $request->landmark,
        ]);

        $user->assignRole('customer');

        Auth::login($user);

        // Generate a token for the user
        $token = $user->createToken('API Token Registration')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'successfully registered',
            'user' => $user,
            'address' => $address,
            'token' => $token
        ], 201)->header('Content-Type', 'application/json');
    }
    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return Response(['data' => 'User Logout successfully.'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
