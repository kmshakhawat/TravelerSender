<?php

namespace App\Actions;

use App\Models\Country;

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

    public static function idTypes(): array
    {
        return collect([
            (object) ['id' => 'Passport', 'name' => 'Passport'],
            (object) ['id' => 'National ID', 'name' => 'National ID'],
            (object) ['id' => 'Driving License', 'name' => 'Driving License'],
        ])->toArray();
    }

}
