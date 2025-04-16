<?php

use App\Models\Country;
use App\Models\Currency;

function getPrice($price, $currency = NULL)
{
    if ($currency) {
        $currency = Currency::where('code', $currency)->first()->symbol;
    } else {
        $currency = '₦';
    }
    return $currency . '' . $price;

}
function getDateFormat($date, $format = 'd-M-Y, h:i A'): string
{
    if ($date === null) {
        return '--';
    }
    return date($format, strtotime($date));
}

function countries(): \Illuminate\Support\Collection
{
    $default = [161,207];
    return Country::all()->sortBy(function ($country) use ($default) {
        $index = array_search($country->id, $default);
        return $index !== false ? $index : count($default) + $country->id;
    })->values();
}
