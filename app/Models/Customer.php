<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Traits\LogsActivity;

class Customer extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        $email = auth()->user()->email;
    
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "A customer was {$eventName} by {$email}.")
            ->logOnly(['first_name', 'last_name', 'username', 'email', 'contact_no'])
            ->logOnlyDirty()
            ->useLogName('customer');
    }

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'contact_no',
        'gender_id',
        'photo',
        'status_id'
    ];

    // public function users(){
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genders()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id', 'id');
    }

    public function foodOrders()
    {
        return $this->hasMany(FoodOrder::class, 'customer_id', 'id');
    }

    public function status() 
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    
    public function address()
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id');
    }
}
