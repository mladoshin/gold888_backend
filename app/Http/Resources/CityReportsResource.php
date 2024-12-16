<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityReportsResource extends JsonResource
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
            'city'=>new CityResource($this->city),
            'income' => $this->calculateIncome(),
            'expenses' => $this->calculateExpenses(),
            'total'=>$this->getNetProfitAttribute()
        ];
    }
}
