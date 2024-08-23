<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrderDishKey extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'dish_id',
        'quantity',
        'status_id',
        'update',
    ];

    public function foodOrder()
    {
        return $this->belongsTo(FoodOrder::class, 'order_id', 'id');
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
