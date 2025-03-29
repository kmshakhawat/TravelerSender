<?php

namespace App\Models;

use App\Http\Services\CurrencyConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stopover extends Model
{
    protected $fillable = [
        'trip_id',
        'location',
        'status',
        'arrival_time',
    ];
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
