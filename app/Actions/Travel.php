<?php

namespace App\Actions;

use App\Models\Country;
use App\Models\Currency;

class Travel
{
    public static function countries()
    {
        return Country::where('status', 'Active')->orderBy('name')->get();

    }
    public static function phoneCodes()
    {
        return Country::where('status', 'Active')->get(['id','code', 'name', 'calling_code']);
    }
    public static function currencies()
    {
        return Currency::get(['id','code as name', 'symbol']);

        // i want to make it id, name, code, symbol

    }

    public static function idTypes(): array
    {
        return collect([
            (object) ['id' => 'Passport', 'name' => 'Passport'],
            (object) ['id' => 'National ID', 'name' => 'National ID'],
            (object) ['id' => 'Driving License', 'name' => 'Driving License'],
        ])->toArray();
    }
    public static function tripTypes(): array
    {
        return collect([
            (object) ['id' => 'One Way', 'name' => 'One Way'],
            (object) ['id' => 'Round', 'name' => 'Round'],
        ])->toArray();
    }
    public static function transportType(): array
    {
        return collect([
            (object) ['id' => 'Flight', 'name' => 'Flight'],
            (object) ['id' => 'Train', 'name' => 'Train'],
            (object) ['id' => 'Bus', 'name' => 'Bus'],
            (object) ['id' => 'Car', 'name' => 'Car'],
        ])->toArray();
    }
    public static function itemType(): array
    {
        return collect([
            (object) ['id' => 'Documents', 'name' => 'Documents'],
            (object) ['id' => 'Electronics', 'name' => 'Electronics'],
            (object) ['id' => 'Clothing', 'name' => 'Clothing'],
        ])->toArray();
    }
    public static function packagingType(): array
    {
        return collect([
            (object) ['id' => 'Boxed', 'name' => 'Boxed'],
            (object) ['id' => 'Envelope', 'name' => 'Envelope'],
            (object) ['id' => 'Fragile', 'name' => 'Fragile'],
        ])->toArray();
    }
    public static function instructionType(): array
    {
        return collect([
            (object) ['id' => 'Fragile', 'name' => 'Fragile'],
            (object) ['id' => 'Refrigerated', 'name' => 'Refrigerated'],
        ])->toArray();
    }

}
