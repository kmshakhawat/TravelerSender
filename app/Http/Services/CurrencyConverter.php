<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    public static function convert($amount, $toCurrency)
    {
        $apiUrl = 'https://open.er-api.com/v6/latest/USD ';
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $rates = $response->json()['conversion_rates'];
            $rate = $rates[$toCurrency] ?? 1; // Fallback to 1 if currency not found

            return round($amount * $rate, 2);
        }

        return $amount; // If API fails, return original amount
    }
}
