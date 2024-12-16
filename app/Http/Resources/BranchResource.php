<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Branch */
class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city_id' => $this->city_id,
            'city' => new CityResource($this->city),
            'region' => $this->city->region->name,
            'director_id' => $this->user_id,
            'director' => $this->director->full_name,
            'address' => $this->address,
            'kpi_day_plan' => $this->kpi_day_plan,
            'kpi_month_plan' => $this->kpi_month_plan,
            'kpi_year_plan' => $this->kpi_year_plan,
            'kpi_day_fact' => $this->kpi_day_fact,
            'kpi_month_fact' => $this->kpi_month_fact,
            'kpi_year_fact' => $this->kpi_year_fact,
        ];
    }
}
