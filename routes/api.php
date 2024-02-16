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


Route::post('login', [UserController::class, 'loginUser']);

// Route::post('login', function (Request $request) {
//     return (new UserController())->loginUser($request);
// })->name('login');


Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('logout',[UserController::class,'logout']);

    // Dish
    Route::get('dishes', [DishController::class, 'dishList']);
    Route::get('viewDish/{id}', [DishController::class, 'viewDish']);

    // Package
    Route::get('packages', [DishController::class, 'packageList']);
    Route::get('viewPackage/{id}', [DishController::class, 'viewPackage']);
});
