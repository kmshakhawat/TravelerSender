<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type' => $this->type,
            'weight' => $this->weight,
            'weight_type' => $this->weight_type,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'quantity' => $this->quantity,
            'box' => $this->box,
            'fragile' => $this->fragile,
            'insurance' => $this->insurance,
            'urgent' => $this->urgent,
            'note' => $this->note,
            'status' => $this->status,
            'photos' => $this->photos
                ? $this->photos->map(function ($photo) {
                    return [
                        'id' => $photo->id,
                        'url' => $photo->url,
                        'thumbnail' => $photo->thumbnail,
                    ];
                })
                : [],
        ];
    }
}
