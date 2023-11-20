<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'venue_id', 'id');
    }
}
