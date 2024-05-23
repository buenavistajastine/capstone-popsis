<?php

use App\Http\Controllers\API\DishController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [UserController::class, 'registerUser']);
Route::post('/login', [UserController::class, 'loginUser']);

// Route::post('login', function (Request $request) {
//     return (new UserController())->loginUser($request);
// })->name('login');


Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('/logout',[UserController::class,'logout']);

    // Dish
    Route::get('dishes', [DishController::class, 'dishList']);
    Route::get('dish', [DishController::class, 'dish']);
    Route::get('menu', [DishController::class, 'menu']);
    Route::get('venue', [DishController::class, 'venue']);
    Route::get('viewDish/{id}', [DishController::class, 'viewDish']);
    Route::get('bookings', [UserController::class, 'booking']);
    Route::get('viewBooking/{id}', [DishController::class, 'viewBooking']);
    Route::get('orders', [UserController::class, 'order']);
    Route::get('viewOrder/{id}', [DishController::class, 'viewOrder']);
    Route::get('populars', [UserController::class, 'popular']);

    // Package
    Route::get('packages', [DishController::class, 'packageList']);
    Route::get('viewPackage/{id}', [DishController::class, 'viewPackage']);

    Route::post('/cancelOrder/{id}', [DishController::class, 'cancelOrder']);
    Route::post('/cancelBooking/{id}', [DishController::class, 'cancelBooking']);

    // Placing orders
    Route::post('place_order', [DishController::class, 'foodOrder']);
    Route::post('book_event', [DishController::class, 'booking']);

    Route::get('image/{filename}', [UserController::class, 'show']);
    Route::get('imageDish/{filename}', [UserController::class, 'showDish']);
    Route::get('qrCode', [UserController::class, 'showQR']);
});

