<?php

use App\Models\Currency;

function getPrice($currency, $price)
{
    $currency = Currency::where('code', $currency)->first()->symbol;
    return $currency . '' . $price;

}
function getDateFormat($date, $format = 'd-M-Y, h:i A'): string
{
    if ($date === null) {
        return '--';
    }
    return date($format, strtotime($date));
}
