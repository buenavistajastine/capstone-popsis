<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'ordered_by',
        'address',
        'contact_no',
        'date_need',
        'call_time',
        'total_price',
        'transport_id',
        'status_id',
        'remarks',
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function transports()
    {
        return $this->belongsTo(ModeOfTransportation::class, 'transport_id', 'id');
    }

    public function billing()
    {
        return $this->hasOne(Billing::class, 'foodOrder_id', 'id');
    }
}
