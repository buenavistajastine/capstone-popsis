<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'order_id',
        'city',
        'barangay',
        'venue_address',
        'specific_address',
        'landmark',
    ];

    public function bookings() {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function orders() {
        return $this->belongsTo(FoodOrder::class, 'order_id', 'id');
    }
}
