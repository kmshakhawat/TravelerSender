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
            'Lorry',
            'Vans',
        ]);
    }
    public static function itemType(): array
    {
        return self::generateDropdown([
            'Documents',
            'Electronics',
            'Fashion',
        ]);
    }
    public static function packagingType(): array
    {
        return self::generateDropdown([
            'Boxed/Bag',
            'Envelope',
            'Fragile',
            'Others',
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
            'Booked',
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
            'Attempt to Deliver',
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
            'Flexible Meet',
            'Send by Courier',
            'Send by Friend',
            'Send by Cab/Uber Driver',
        ]);
    }
    public static function parcelDeliveryType(): array
    {
        return self::generateDropdown([
            'Deliver to Address',
            'Flexible Meet',
        ]);
    }
    public static function paymentStatus(): array
    {
        return self::generateDropdown([
            'Pending',
            'Processing',
            'Completed',
            'Rejected'
        ]);
    }
    private static function generateDropdown(array $fields): array
    {
        return collect($fields)->map(fn($field) => (object) ['id' => $field, 'name' => $field])->toArray();
    }

}
