<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'limitation_of_maindish',
        'minimum_pax',
        'venue_id',
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'package_id', 'id');
    }

    public function venue() {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
}
