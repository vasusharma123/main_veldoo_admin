<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RideCompanyResource extends JsonResource
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
            'name' => $this->name,
            'state' => $this->state,
            'city' => $this->city,
            'street' => $this->street,
            'zip' => $this->zip,
            'country' => $this->country,
            'image_with_url' => $this->image_with_url
        ];
    }
}