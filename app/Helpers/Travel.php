<?php

use App\Models\Country;
use App\Models\Currency;
use App\Models\Message;

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
    })
        ->map(function ($country) use ($default) {
            $countryObject = new \stdClass();
            $countryObject->id = $country->id;
            $countryObject->name = $country->name;
            return $countryObject;
        })
        ->values();
}

function unReadMessage()
{
    $count = Message::where('receiver_id', auth()->id())->whereNull('read_at')->count();
    if ($count) {
        echo '<sup class="bg-primary text-white px-1 rounded-full">' . $count . '</sup>';
    }
}
