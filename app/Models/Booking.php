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
        'event_name',
        'venue_address',
        'no_pax',
        'date_event',
        'call_time',
        'total_price',
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

    public function dish_keys()
    {
        return $this->hasMany(BookingDishKey::class, 'booking_id', 'id');
    }

    public function dish_keyss()
    {
        return $this->hasOne(BookingDishKey::class, 'booking_id', 'id');
    }

    public function addOns()
    {
        return $this->hasMany(AddOn::class, 'booking_id', 'id');
    }

    public function addOnss()
    {
        return $this->hasOne(AddOn::class, 'booking_id', 'id');
    }

    public function billing()
    {
        return $this->hasOne(Billing::class, 'booking_id', 'id');
    }

    public function dishes()

    {
        return $this->belongsToMany(Dish::class, 'booking_dish_keys');
    }
    
    public function dishess()

    {
        return $this->belongsToMany(Dish::class, 'add_ons');
    }
}
