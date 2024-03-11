<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'contact_no',
        'gender_id',
    ];

    // public function users(){
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
