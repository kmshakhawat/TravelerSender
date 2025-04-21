<?php

namespace App\Enam;

enum BookingStatus:string
{
    case PENDING = 'Pending';
    case BOOKED = 'Booked';
    case CANCELLED = 'Cancelled';
    case COMPLETED = 'Completed';

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-800',
            self::BOOKED => 'bg-green-100 text-green-800',
            self::CANCELLED => 'bg-red-100 text-red-800',
            self::COMPLETED => 'bg-blue-100 text-blue-800',
        };
    }
}
