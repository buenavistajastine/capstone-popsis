<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        $email = auth()->user()->email;
    
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "A status was {$eventName} by {$email}.")
            ->logOnly(['name'])
            ->logOnlyDirty()
            ->useLogName('system');
    }

    protected $fillable = ['name'];

    public function bookings()
    {
        return $this->hasOne(Booking::class, 'status_id', 'id');
    }

    public function foodOrders()
    {
        return $this->hasOne(FoodOrder::class, 'status_id', 'id');
    }

    public function dishKey()
    {
        return $this->hasOne(BookingDishKey::class, 'status_id', 'id');
    }
}
