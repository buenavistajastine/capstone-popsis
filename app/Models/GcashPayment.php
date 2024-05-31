<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcashPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'photo'
    ];

    public function billings()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }
}
