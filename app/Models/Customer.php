<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'contact_no',
        'gender_id',
    ];

    public function genders()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function bookings()
    {
        return $this->hasOne(Booking::class, 'booking_id', 'id');
    }

    public function foodOrders()
    {
        return $this->hasOne(FoodOrder::class, 'customer_id', 'id');
    }
}
