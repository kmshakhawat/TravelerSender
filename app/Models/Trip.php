<?php

namespace App\Models;

use App\Http\Services\CurrencyConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'trip_type',
        'mode_of_transport',
        'from',
        'to',
        'departure_date',
        'arrival_date',
        'stopovers',
        'available_space',
        'type_of_item',
        'packaging_requirement',
        'handling_instruction',
        'photo',
        'price',
        'status',
    ];

    public function getConvertedPriceAttribute()
    {
        $currency = session('currency', 'USD');
        $price = $this->price; // Base price in USD

        if ($currency !== 'USD') {
            $exchangeRate = app('swap')->latest("USD/{$currency}")->getValue();
            return round($price * $exchangeRate, 2);
        }

        return $price;
    }

    public function getCurrencySymbolAttribute()
    {
        return auth()->user()->currency->symbol ?? '$';
    }
}
