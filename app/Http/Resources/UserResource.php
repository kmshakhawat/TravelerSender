<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'name' => $this->name,
                'email' => $this->email,
                'email_verified_at' => $this->email_verified_at,
                'phone' => $this->phone,

                // From profile relation
                'dob' => $this->profile?->dob,
                'currency_id' => $this->profile?->currency_id,
                'currency_name' => $this->profile?->currency->code,
                'address_1' => $this->profile?->address_1,
                'address_2' => $this->profile?->address_2,
                'country_id' => $this->profile?->country_id,
                'country_name' => $this->profile?->country->name,
                'state_id' => $this->profile?->state_id,
                'state_name' => $this->profile?->state->name,
                'city_id' => $this->profile?->city_id,
                'city_name' => $this->profile?->city->name,
                'postcode' => $this->profile?->postcode,
                'bank_details' => $this->profile?->bank_details,
                'id_type' => $this->profile?->id_type,
                'id_number' => $this->profile?->id_number,
                'id_issue' => $this->profile?->id_issue,
                'id_expiry' => $this->profile?->id_expiry,
                'id_front' => $this->profile?->id_front,
                'id_back' => $this->profile?->id_back,
                'note' => $this->profile?->note,

                'status' => $this->status,
                'otp' => $this->otp,
                'otp_verified' => $this->otp_verified,
                'otp_expiry' => $this->otp_expiry,
                'verified' => $this->verified,
                'profile_photo_url' => $this->profile_photo_url,
            ];
    }
}
