<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDishKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'dish_id',
        'status_id',
        'dt_accepted',
        'dt_completed',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function dishes()
    {
        return $this->belongsTo(Dish::class, 'dish_id', 'id');
    }


}
