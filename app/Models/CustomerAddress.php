<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'city',
        'barangay',
        'venue_address',
        'specific_address',
        'landmark',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
