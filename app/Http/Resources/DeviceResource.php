<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'model' => $this->model,
            'serial_number' => $this->serial_number,
            'configuration' => new ConfigurationResource($this->whenLoaded('configuration')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
