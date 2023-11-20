<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function bookings()
    {
        return $this->hasOne(Booking::class, 'status_id', 'id');
    }

    public function foodOrders()
    {
        return $this->hasOne(FoodOrder::class, 'status_id', 'id');
    }

    public function dishKey()
    {
        return $this->hasOne(BookingServiceKey::class, 'status_id', 'id');
    }
}
