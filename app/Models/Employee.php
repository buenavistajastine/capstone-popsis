<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender_id',
        'birthdate',
        'age',
        'contact_no',
        'civil_status_id',
        'address',
        'photo',
        'position_id'
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }
    

    public function civil_statuses()
    {
        return $this->hasMany(CivilStatus::class, 'civil_status_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }
}
