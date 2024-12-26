<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'branch_id' => 'required|integer|exists:' . (new Branch())->getTable() . ',id',
            'start_shift' => 'nullable|string',
            'end_shift' => 'nullable|string',
            'smart_end_shift' => 'nullable|string',
            'refreshment' => 'nullable|string',
            'refreshment_text' => 'nullable|string',
            'deposit' => 'nullable|string',
            'renewal' => 'nullable|string',
            'partial_redemption' => 'nullable|string',
            'interest_income' => 'nullable|numeric',
            'return_goods' => 'nullable|string',
            'deposit_tickets' => 'nullable|string',
            'investor_capital' => 'nullable|string',
            'equity' => 'nullable|string',
            'fixed_flow' => 'nullable|string',
            'collection' => 'nullable|string',
            'collection_text' => 'nullable|string',
            'ransom' => 'nullable|string',
            'withdraw_pledges' => 'nullable|string',
            'selling_goods' => 'nullable|string',
            'income_goods' => 'nullable|numeric',
            'used_goods' => 'nullable|string',
            'pledge_tickets' => 'nullable|string',
            'borrowed_capital' => 'nullable|string',
            'own_capital' => 'nullable|string',
            'smart_start_shift' => 'nullable|string',
            'smart_refreshment' => 'nullable|string',
            'smart_refreshment_text' => 'nullable|string',
            'smart_deposit' => 'nullable|string',
            'smart_renewal' => 'nullable|string',
            'smart_partial_redemption' => 'nullable|string',
            'smart_interest_income' => 'nullable|numeric',
            'smart_return_goods' => 'nullable|string',
            'smart_deposit_tickets' => 'nullable|string',
            'smart_investor_capital' => 'nullable|string',
            'smart_equity' => 'nullable|string',
            'smart_fixed_flow' => 'nullable|string',
            'smart_collection' => 'nullable|string',
            'smart_collection_text' => 'nullable|string',
            'smart_ransom' => 'nullable|string',
            'smart_withdraw_pledges' => 'nullable|string',
            'smart_selling_goods' => 'nullable|string',
            'smart_income_goods' => 'nullable|numeric',
            'smart_used_goods' => 'nullable|string',
            'smart_pledge_tickets' => 'nullable|string',
            'smart_borrowed_capital' => 'nullable|string',
            'smart_own_capital' => 'nullable|string',
            'smart_buying_up' => 'nullable|string',
            'date' => 'nullable|string',
//            'smart_consumptions' => 'nullable|array',
//            'express_consumptions' => 'nullable|array',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
