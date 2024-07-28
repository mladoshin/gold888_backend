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
            'region' => $this->region->name,
            'director' => $this->director->full_name,
            'name' => $this->name,
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
