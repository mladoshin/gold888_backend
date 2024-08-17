<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\City */
class CityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'region_id' => $this->region_id,
            'region' => $this->region->name,
            'name' => $this->name,
            'director_id' => $this->director_id,
            'director' => $this->director->full_name,
        ];
    }
}
