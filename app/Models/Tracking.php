<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = [
        'tracking_id', 'booking_id', 'status', 'description', 'estimated_delivery', 'status_update_at'
    ];

    public function latest()
    {
        return $this->hasOne(Tracking::class, 'status', 'status')->latestOfMany();
    }


}
