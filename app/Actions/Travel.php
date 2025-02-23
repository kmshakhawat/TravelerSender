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

}
