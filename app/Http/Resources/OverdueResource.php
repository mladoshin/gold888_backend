<?php

namespace App\Http\Resources;

use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OverdueResource extends JsonResource
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
            'user' =>$this->user,
            'status' => $this->status,
            'amount' => $this->amount,
            'result' => $this->result,
            'return_date' => $this->return_date,
            'returned' => $this->returned,
            'branch' => new BranchResource($this->branch)
        ];
    }
}
