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

    }

    public static function idTypes(): array
    {
        return self::generateDropdown([
            'Passport',
            'National ID',
            'Driving License',
        ]);
    }
    public static function tripTypes(): array
    {
        return self::generateDropdown([
            'One Way',
            'Round',
        ]);
    }
    public static function transportType(): array
    {
        return self::generateDropdown([
            'Flight',
            'Train',
            'Bus',
            'Car',
        ]);
    }
    public static function itemType(): array
    {
        return self::generateDropdown([
            'Documents',
            'Electronics',
            'Clothing',
        ]);
    }
    public static function packagingType(): array
    {
        return self::generateDropdown([
            'Boxed',
            'Envelope',
            'Fragile',
        ]);
    }
    public static function instructionType(): array
    {
        return self::generateDropdown([
            'Fragile',
            'Refrigerated',
        ]);
    }

    public static function tripStatus(): array
    {
        return self::generateDropdown([
            'Active',
            'Confirmed',
            'In Progress',
            'Completed',
            'Cancelled',
        ]);
    }
    public static function userStatus(): array
    {
        return self::generateDropdown([
            'Active',
            'Inactive',
        ]);
    }
    public static function bookingStatus(): array
    {
        return self::generateDropdown([
            'Pending',
            'Approved',
            'Rejected',
            'Completed',
        ]);
    }
    public static function trackingStatus(): array
    {
        return self::generateDropdown([
            'Processing',
            'Ready for Pickup',
            'Picked Up',
            'In Transit',
            'Arrived at Destination',
            'Attempt to Delivery',
            'Delivered',
        ]);
    }

    public static function weightUnit(): array
    {
        return self::generateDropdown([
            'KG',
            'LBS',
        ]);
    }
    public static function locationType(): array
    {
        return self::generateDropdown([
            'Private',
            'Public',
        ]);
    }
    public static function parcelCollectionType(): array
    {
        return self::generateDropdown([
            'Collect from Address',
            'Send by Currier',
            'Send by Friend',
            'Send by Cab/Uber Driver',
        ]);
    }
    private static function generateDropdown(array $fields): array
    {
        return collect($fields)->map(fn($field) => (object) ['id' => $field, 'name' => $field])->toArray();
    }

}
