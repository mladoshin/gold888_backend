<?php

namespace App\Http\Resources;

use App\Models\Branch;
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
            'branch_name' => $this->branch->name,
            'branch_id' => $this->branch_id,
            'cities' => CityResource::collection($this->cities),
            'branches' => BranchResource::collection($this->branches()->count() > 0 ? $this->branches : Branch::select('id', 'name')->latest()->get())
        ];
    }
}
