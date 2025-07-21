<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'mode_of_transport' => $this->mode_of_transport,
            'vehicle_details' => $this->vehicle_details,
            'departure_date' => $this->departure_date,
            'arrival_date' => $this->arrival_date,
            'available_space' => $this->available_space,
            'weight_unit' => $this->weight_unit,
            'type_of_item' => $this->type_of_item,
            'packaging_requirement' => $this->packaging_requirement,
            'handling_instruction' => $this->handling_instruction,
            'photo' => $this->photo,
            'currency' => $this->currency,
            'price' => $this->price,
            'note' => $this->note,
            'status' => $this->status,
            'from' => [
                'country_id' => $this->from_country_id,
                'country_name' => optional($this->fromCountry)->name ?? '',
                'state_id' => $this->from_state_id,
                'state_name' => optional($this->fromState)->name ?? '',
                'city_id' => $this->from_city_id,
                'city_name' => optional($this->fromCity)->name ?? '',
                'full_address_1' => $this->from_address_1,
                'full_address_2' => $this->from_address_2,
                'phone' => $this->from_phone,
                'post_code' => $this->from_postcode,
            ],
            'to' => [
                'country_id' => $this->to_country_id,
                'country_name' => optional($this->toCountry)->name ?? '',
                'state_id' => $this->to_state_id,
                'state_name' => optional($this->toState)->name ?? '',
                'city_id' => $this->to_city_id,
                'city_name' => optional($this->toCity)->name ?? '',
                'full_address_1' => $this->to_address_1,
                'full_address_2' => $this->to_address_2,
                'phone' => $this->to_phone,
                'post_code' => $this->to_postcode,
            ],
            'stopovers' => $this->stopovers->map(function ($stopover) {
                return [
                    'id' => $stopover->id,
                    'location' => $stopover->location,
                ];
            }),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'profile_photo_url' => $this->user->profile_photo_url,
            ]
        ];
    }
}
