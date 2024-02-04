<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'dish_id',
        'quantity',
    ];

    public function bookings()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }


    // Booking Report
    public function dishss()
    {
        return $this->belongsTo(Dish::class, 'dish_id', 'id');
    }

    // Booking
    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'add_ons', 'booking_id', 'dish_id', 'id');
    }

}
