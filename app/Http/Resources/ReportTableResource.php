<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Report */
class ReportTableResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->created_at->format('d/m/Y'),
            'equity' => $this->equity + $this->smart_equity,
            'own_capital' => $this->own_capital + $this->smart_own_capital,
            'consumptions_sum_sum' => $this->consumptions_sum_sum,
            'net_profit' => $this->net_profit,
            'prodano' => $this->income_goods + $this->smart_income_goods,
            'links' => $this->links
        ];
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
        ];
    }
}
