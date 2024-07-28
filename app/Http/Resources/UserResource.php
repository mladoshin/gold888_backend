<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image_path,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'full_name' => $this->full_name,
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'region' => new RegionResource($this->whenLoaded('region')),
        ];
    }
}
