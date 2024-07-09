<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
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
            'device_id' => $this->device_id,
            'cpu' => $this->cpu,
            'ram' => $this->ram,
            'storage' => $this->storage,
            'device' => new DeviceResource($this->whenLoaded('device')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
