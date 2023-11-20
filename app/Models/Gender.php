<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    
     public function employee()
     {
        return $this->belongsToMany(Employee::class, 'gender_id', 'id');
     }

     public function customers()
     {
        return $this->belongsToMany(Customer::class, 'gender_id', 'id');
     }
}
