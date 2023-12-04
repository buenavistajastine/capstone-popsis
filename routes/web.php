<?php

use App\Http\Livewire\Dish\DishList;
use App\Http\Livewire\User\UserList;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Booking\BookingList;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Customer\CustomerList;
use App\Http\Livewire\Employee\EmployeeList;
use App\Http\Livewire\Position\PositionList;
use App\Http\Livewire\Authentication\RoleList;
use App\Http\Livewire\CustomerAccount\CustomerAccountList;
use App\Http\Livewire\Authentication\PermissionList;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [ProfileController::class, 'Logout'])->name('user.logout');

    Route::get('permission', PermissionList::class)->name('permission');
    Route::get('role', RoleList::class)->name('role');
    Route::get('employee', EmployeeList::class)->name('employee');
    Route::get('user', UserList::class)->name('user');
    Route::get('position', PositionList::class)->name('position');
    Route::get('dish', DishList::class)->name('dish');
    Route::get('booking', BookingList::class)->name('booking');
    Route::get('list', CustomerList::class)->name('customer');
    Route::get('customer-account', CustomerAccountList::class)->name('customer_account');
});

require __DIR__.'/auth.php';
