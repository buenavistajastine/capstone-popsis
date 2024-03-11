<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        $email = auth()->user()->email;
    
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "A package was {$eventName} by {$email}.")
            ->logOnly(['name', 'price'])
            ->logOnlyDirty()
            ->useLogName('system');
    }

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
