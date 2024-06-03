<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Report */
class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_shift' => $this->start_shift,
            'refreshment' => $this->refreshment,
            'deposit' => $this->deposit,
            'renewal' => $this->renewal,
            'partial_redemption' => $this->partial_redemption,
            'interest_income' => $this->interest_income,
            'return_goods' => $this->return_goods,
            'deposit_tickets' => $this->deposit_tickets,
            'investor_capital' => $this->investor_capital,
            'equity' => $this->equity,
            'fixed_flow' => $this->fixed_flow,
            'collection' => $this->collection,
            'ransom' => $this->ransom,
            'withdraw_pledges' => $this->withdraw_pledges,
            'selling_goods' => $this->selling_goods,
            'income_goods' => $this->income_goods,
            'used_goods' => $this->used_goods,
            'pledge_tickets' => $this->pledge_tickets,
            'borrowed_capital' => $this->borrowed_capital,
            'own_capital' => $this->own_capital,
            'smart_start_shift' => $this->smart_start_shift,
            'smart_refreshment' => $this->smart_refreshment,
            'smart_deposit' => $this->smart_deposit,
            'smart_renewal' => $this->smart_renewal,
            'smart_partial_redemption' => $this->smart_partial_redemption,
            'smart_interest_income' => $this->smart_interest_income,
            'smart_return_goods' => $this->smart_return_goods,
            'smart_deposit_tickets' => $this->smart_deposit_tickets,
            'smart_investor_capital' => $this->smart_investor_capital,
            'smart_equity' => $this->smart_equity,
            'smart_fixed_flow' => $this->smart_fixed_flow,
            'smart_collection' => $this->smart_collection,
            'smart_ransom' => $this->smart_ransom,
            'smart_withdraw_pledges' => $this->smart_withdraw_pledges,
            'smart_selling_goods' => $this->smart_selling_goods,
            'smart_income_goods' => $this->smart_income_goods,
            'smart_used_goods' => $this->smart_used_goods,
            'smart_pledge_tickets' => $this->smart_pledge_tickets,
            'smart_borrowed_capital' => $this->smart_borrowed_capital,
            'smart_own_capital' => $this->smart_own_capital,
            'consumptions' => $this->consumptions,
        ];
    }
}
