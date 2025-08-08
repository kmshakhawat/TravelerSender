<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pickup = [];
        $delivery = [];
        if ($this->collection_type === 'Collect from Address') {
            $pickup = [
                'collection_type' => $this->collection_type,
                'address_1' => $this->pickup_address_1,
                'address_2' => $this->pickup_address_2,
                'country_id' => $this->pickup_country_id,
                'country_name' => optional($this->pickupCountry)->name ?? '',
                'state_id' => $this->pickup_state_id,
                'state_name' => optional($this->pickupState)->name ?? '',
                'city_id' => $this->pickup_city_id,
                'city_name' => optional($this->pickupCity)->name ?? '',
                'postcode' => $this->pickup_postcode,
                'pickup_location_type' => $this->pickup_location_type,
                'date' => $this->pickup_date,
            ];
        } elseif ($this->collection_type === 'Flexible Meet') {
            $pickup = [
                'collection_type' => $this->collection_type,
                'flexible_place' => $this->flexible_place,
            ];
        } elseif ($this->collection_type === 'Send by Courier') {
            $pickup = [
                'collection_type' => $this->collection_type,
            ];
        } elseif ($this->collection_type === 'Send by Friend') {
            $pickup = [
                'collection_type' => $this->collection_type,
                'friend' => [
                    'name' => $this->friend_name,
                    'email' => $this->friend_email,
                    'phone' => $this->friend_phone,
                ],
            ];
        } elseif ($this->collection_type === 'Send by Cab/Uber Driver') {
            $pickup = [
                'collection_type' => $this->collection_type,
            ];
        }
        if ($this->delivery_type === 'Deliver to Address') {
            $delivery = [
                'delivery_type' => $this->delivery_type,
                'address_1' => $this->delivery_address_1,
                'address_2' => $this->delivery_address_2,
                'country_id' => $this->delivery_country_id,
                'country_name' => optional($this->deliveryCountry)->name ?? '',
                'state_id' => $this->delivery_state_id,
                'state_name' => optional($this->deliveryState)->name ?? '',
                'city_id' => $this->delivery_city_id,
                'city_name' => optional($this->deliveryCity)->name ?? '',
                'postcode' => $this->delivery_postcode,
                'delivery_location_type' => $this->delivery_location_type,
                'date' => $this->delivery_date,
            ];
        } elseif ($this->delivery_type === 'Flexible Meet') {
            $delivery = [
                'delivery_type' => $this->delivery_type,
                'flexible_delivery_place' => $this->flexible_delivery_place
            ];
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
//            'trip_user_id' => $this->trip_user_id,
//            'trip_id' => $this->trip_id,
            'tracking_number' => $this->tracking_number,
            'status' => $this->status,
            'note' => $this->note,
            'otp' => $this->otp,
            'package_condition' => json_decode($this->package_condition, true),
            'sender' => [
                'name' => $this->sender_name,
                'email' => $this->sender_email,
                'phone' => $this->sender_phone,
            ],
            'receiver' => [
                'name' => $this->receiver_name,
                'email' => $this->receiver_email,
                'phone' => $this->receiver_phone,
            ],
//            'collection_type' => $this->collection_type,
            'pickup' => $pickup,
            'delivery' => $delivery,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'trip' => new TripResource($this->whenLoaded('trip')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
