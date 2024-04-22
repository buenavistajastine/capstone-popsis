<?php

use App\Http\Livewire\Dish\DishList;
use App\Http\Livewire\User\UserList;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Booking\BookingForm;
use App\Http\Livewire\Booking\BookingList;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Customer\CustomerList;
use App\Http\Livewire\Employee\EmployeeList;
use App\Http\Livewire\Position\PositionList;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrintController;
use App\Http\Livewire\Activity\ActivityLog;
use App\Http\Livewire\Authentication\RoleList;
use App\Http\Livewire\Authentication\PermissionList;
use App\Http\Livewire\Billing\BillingList;
use App\Http\Livewire\Billing\BookingBillingRecord;
use App\Http\Livewire\Billing\OrderBilling;
use App\Http\Livewire\Billing\OrderBillingRecord;
use App\Http\Livewire\Booking\BookingRecord;
use App\Http\Livewire\Booking\BookingReport;
use App\Http\Livewire\Booking\Kitchen;
use App\Http\Livewire\CustomerAccount\CustomerAccountList;
use App\Http\Livewire\FoodOrder\FoodOrderList;
use App\Http\Livewire\FoodOrder\OrderRecord;
use App\Http\Livewire\FoodOrder\OrderReport;
use App\Http\Livewire\OrderRecordModal;
use App\Http\Livewire\Package\PackageList;
use App\Http\Livewire\Status\StatusList;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [ProfileController::class, 'Logout'])->name('user.logout');
    Route::get('/logout', [ProfileController::class, 'Logout'])->name('user.logout');

    Route::get('permission', PermissionList::class)->name('permission');
    Route::get('role', RoleList::class)->name('role');
    Route::get('employee', EmployeeList::class)->name('employee');
    Route::get('user', UserList::class)->name('user');
    Route::get('position', PositionList::class)->name('position');
    Route::get('dish', DishList::class)->name('dish');
    Route::get('booking', BookingList::class)->name('booking');
     
    // Route::get('booking-form', BookingForm::class)->name('booking-form');
    Route::get('order', FoodOrderList::class)->name('order');
    Route::get('list', CustomerList::class)->name('customer');
    Route::get('package', PackageList::class)->name('package');
    Route::get('status', StatusList::class)->name('status');
    Route::get('customer-account', CustomerAccountList::class)->name('customer_account');

    Route::get('booking_billing', BillingList::class);
    Route::get('booking_billing_record', BookingBillingRecord::class);
    Route::get('order_billing', OrderBilling::class);
    Route::get('order_billing_record', OrderBillingRecord::class);

    // printables
    Route::get('print/module/{id}', [PrintController::class, 'PrintModule'])->name('module_print');
    Route::get('/print-dishes', [PrintController::class, 'printDishes'])->name('print.dishes');
    Route::get('/print-order-dishes', [PrintController::class, 'printOrderDishes'])->name('print.order-dishes');
    Route::get('claim-slip/{id}', [PrintController::class, 'claimSlip'])->name('print.claim-slip');

    Route::get('kitchen', Kitchen::class);

    Route::get('activity_logs', ActivityLog::class);

    // 
    Route::get('booking_reports', BookingReport::class);
    Route::get('order_reports', OrderReport::class);
    Route::get('booking_records', BookingRecord::class);
    Route::get('order_records', OrderRecord::class);

});

Route::get('/admin/login', [ProfileController::class, 'Login'])->name('user.login');

require __DIR__.'/auth.php';
