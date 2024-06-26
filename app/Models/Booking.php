<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'booking_no',
        'package_id',
        'venue_id',
        'city',
        'barangay',
        'specific_address',
        'landmark',
        'event_name',
        'venue_address',
        'no_pax',
        'remarks',
        'date_event',
        'call_time',
        'total_price',
        'color',
        'color2',
        'dt_booked',
        'status_id',
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function packages()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function venues()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    // public function dish_keys()
    // {
    //     return $this->hasMany(BookingDishKey::class, 'booking_id', 'id');
    // }

    // Booking.php model
    public function dish_keys()
    {
        return $this->hasMany(BookingDishKey::class, 'booking_id', 'id')->with('dishes.menu');
    }


    public function dish_keyss()
    {
        return $this->hasOne(BookingDishKey::class, 'booking_id', 'id');
    }

    public function addOns()
    {
        return $this->hasMany(AddOn::class, 'booking_id', 'id')->with('dishes.menu');
    }

    public function addOnss()
    {
        return $this->hasOne(AddOn::class, 'booking_id', 'id');
    }

    public function billing()
    {
        return $this->hasMany(Billing::class, 'booking_id', 'id');
    }

    public function dishes()

    {
        return $this->belongsToMany(Dish::class, 'booking_dish_keys');
    }

    public function dishess()

    {
        return $this->belongsToMany(Dish::class, 'add_ons');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'booking_id', 'id');
    }
}
