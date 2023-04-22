<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RideUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'current_lat' => $this->current_lat,
            'current_lng' => $this->current_lng,
            'invoice_status' => $this->invoice_status,
            'image_with_url' => $this->image_with_url
        ];
    }
}
