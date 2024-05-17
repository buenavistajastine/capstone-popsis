<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        $email = auth()->user()->email;
    
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "A dish was {$eventName} by {$email}.")
            ->logOnly(['menu_id', 'type_id', 'name','price_full', 'price_half',])
            ->logOnlyDirty()
            ->useLogName('system');
    }

    protected $fillable = [
        'menu_id',
        'type_id',
        'name',
        'description',
        'price_full',
        'price_half',
        'photo',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }


    public function bookingDishKeys()
    {
        return $this->hasMany(BookingDishKey::class, 'dish_id', 'id');
    }

    public function addOns()
    {
        return $this->hasMany(AddOn::class, 'dish_id', 'id');
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_dish_keys');
    }

}
