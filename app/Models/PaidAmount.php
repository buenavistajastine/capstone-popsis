<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidAmount extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'payable_amt',
        'paid_amt',
        'created_at',
        'updated_at',
    ];

    public function billings()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }
}
