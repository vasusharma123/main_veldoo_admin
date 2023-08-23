<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RideVehicleCategoryResource extends JsonResource
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
            'car_type' => $this->car_type,
            'image_with_url' => $this->image_with_url
        ];
    }
}
