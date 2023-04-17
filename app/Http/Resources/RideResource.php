<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RideResource extends JsonResource
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
            'note' => $this->note,
            'pick_lat' => $this->pick_lat,
            'pick_lng' => $this->pick_lng,
            'pickup_address' => $this->pickup_address,
            'dest_address' => $this->dest_address,
            'dest_lat' => $this->dest_lat,
            'dest_lng' => $this->dest_lng,
            'distance' => $this->distance,
            'passanger' => $this->passanger,
            'ride_cost' => $this->ride_cost,
            'ride_time' => $this->ride_time,
            'ride_type' => $this->ride_type,
            'waiting' => $this->waiting,
            'status' => $this->status,
            'payment_type' => $this->payment_type,
            'alert_time' => $this->alert_time,
            'created_by' => $this->created_by,
            'parent_ride_id' => $this->parent_ride_id,
            'created_at' => $this->created_at,
            'user' => new RideUserResource($this->user),
            'driver' => new RideUserResource($this->driver),
            'company_data' => new RideCompanyResource($this->company_data),
            'car_data' => new RideVehicleResource($this->car_data),
            'vehicle_category' => new RideVehicleCategoryResource($this->vehicle_category)
        ];
    }
}
