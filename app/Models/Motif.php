<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motif extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'color',
        'color2',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_id', 'id');
    }
}
