<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            $token = $user->createToken('mobile')->plainTextToken;

            // Include user information along with the token
            return response([
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response(['message' => 'Email or password wrong'], 401);
    }

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

    public function registerUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        try {
            // Create the user
            DB::beginTransaction();
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            $token = $user->createToken('mobile')->plainTextToken;
            DB::commit();
            return response(['token' => $token], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User registration failed: ' . $e->getMessage());
            return response(['message' => 'An error occurred during registration.'], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(['data' => $user], 200);
        }

        return Response(['data' => 'Unauthorized'], 401);
    }

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
