<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_no',
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

    public function orderDish_keys()
    {
        return $this->hasMany(FoodOrderDishKey::class, 'order_id', 'id')->with('dishes.menu');
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

    public function address()
    {
        return $this->hasOne(Address::class, 'order_id', 'id');
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'food_order_dish_keys');
    }

    // public function dishes()
    // {
    //     return $this->belongsToMany(Dish::class, 'food_order_dish_keys', 'order_id', 'dish_id')
    //         ->withPivot('quantity') // Assuming you have a 'quantity' column in your pivot table
    //         ->withTimestamps(); // If you have created_at and updated_at columns in your pivot table
    // }

    protected static function booted()
    {
        // Creating event to generate order number
        static::creating(function ($foodOrder) {
            $currentYear = "ORD";
            // Ensure the id is always 5 digits long
            $paddedRowId = str_pad($foodOrder->id, 6, '0', STR_PAD_LEFT);
            $result = $currentYear . $paddedRowId;

            // Set the generated order number
            $foodOrder->order_no = $result;
        });
    }

}
