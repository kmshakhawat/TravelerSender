<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'user_id',
        'payment_id',
        'amount',
        'currency',
        'pay_to',
        'note',
        'status',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function trip() {
        return $this->belongsTo(Trip::class);
    }



}
