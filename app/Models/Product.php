<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_id',
        'trip_id',
        'name',
        'type',
        'quantity',
        'weight',
        'length',
        'width',
        'height',
        'box',
        'fragile',
        'insurance',
        'urgent',
        'note',
    ];

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
}
