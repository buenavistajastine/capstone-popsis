<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'foodOrder_id',
        'customer_id',
        'additional_amt',
        'advance_amt',
        'discount_amt',
        'total_amt',
        'payable_amt',
        'paid_amt',
        'payment_id',
        'status_id'
    ];

    public function bookings()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function foodOrders()
    {
        return $this->belongsTo(FoodOrder::class, 'foodOrder_id', 'id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function payments()
    {
        return $this->belongsTo(ModeOfPayment::class, 'payment_id', 'id');
    }

    public function addons()
    {
        return $this->hasMany(AddOn::class, 'booking_id', 'booking_id');
    }
}
