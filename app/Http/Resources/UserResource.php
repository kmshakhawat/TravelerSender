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
                'dob' => $this->dob,
                'currency_id' => $this->currency_id,
                'address_1' => $this->address_1,
                'address_2' => $this->address_2,
                'country_id' => $this->country_id,
                'state_id' => $this->state_id,
                'city_id' => $this->city_id,
                'postcode' => $this->postcode,
                'bank_details' => $this->bank_details,
                'id_type' => $this->id_type,
                'id_number' => $this->id_number,
                'id_issue' => $this->id_issue,
                'id_expiry' => $this->id_expiry,
                'id_front' => $this->id_front,
                'id_back' => $this->id_back,
                'note' => $this->note,
                'status' => $this->status,
                'otp' => $this->otp,
                'otp_verified' => $this->otp_verified,
                'otp_expiry' => $this->otp_expiry,
                'verified' => $this->verified,
                'profile_photo_url' => $this->profile_photo_url,
            ];
    }
}
