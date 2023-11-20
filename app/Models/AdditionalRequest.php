<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'request'
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_id', 'id');
    }
}
