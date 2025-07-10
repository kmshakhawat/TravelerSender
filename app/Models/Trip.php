<?php

namespace App\Models;

use App\Http\Services\CurrencyConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Trip extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'trip_type',
        'mode_of_transport',
        'vehicle_details',
        'from_address_1',
        'from_address_2',
        'from_country_id',
        'from_state_id',
        'from_city_id',
        'from_postcode',
        'from_phone',
        'to_address_1',
        'to_address_2',
        'to_country_id',
        'to_state_id',
        'to_city_id',
        'to_postcode',
        'to_phone',
        'departure_date',
        'arrival_date',
        'stopovers',
        'available_space',
        'weight_unit',
        'type_of_item',
        'packaging_requirement',
        'handling_instruction',
        'photo',
        'currency',
        'price',
        'note',
        'admin_note',
        'status',
    ];


    public function toSearchableArray()
    {
        $this->load(['city', 'state', 'country']); // Make sure they're loaded

        return [
            'id' => $this->id,
            'from_city' => $this->city->name ?? '',
            'from_state' => $this->state->name ?? '',
            'from_country' => $this->country->name ?? '',
        ];
    }

    public function fromCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'from_country_id');
    }
    public function toCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'to_country_id');
    }
    public function fromState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'from_state_id');
    }
    public function toState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'to_state_id');
    }

    public function fromCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }
    public function toCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    public function stopovers()
    {
        return $this->hasMany(Stopover::class, 'trip_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getConvertedPriceAttribute()
    {
        $currency = auth()->user()->currency->code ?? 'USD';
        return CurrencyConverter::convert($this->price, $currency);
    }

    public function getCurrencySymbolAttribute()
    {
        return auth()->user()->currency->symbol ?? '$';
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
