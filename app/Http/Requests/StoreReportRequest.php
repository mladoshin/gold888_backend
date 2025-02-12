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
            'start_shift' => 'nullable',
            'end_shift' => 'nullable',
            'smart_end_shift' => 'nullable',
            'refreshment' => 'nullable',
            'refreshment_text' => 'nullable',
            'deposit' => 'nullable',
            'renewal' => 'nullable',
            'partial_redemption' => 'nullable',
            'interest_income' => 'nullable|numeric',
            'return_goods' => 'nullable',
            'deposit_tickets' => 'nullable',
            'investor_capital' => 'nullable',
            'equity' => 'nullable',
            'fixed_flow' => 'nullable',
            'collection' => 'nullable',
            'collection_text' => 'nullable',
            'ransom' => 'nullable',
            'withdraw_pledges' => 'nullable',
            'selling_goods' => 'nullable',
            'income_goods' => 'nullable|numeric',
            'used_goods' => 'nullable',
            'pledge_tickets' => 'nullable',
            'borrowed_capital' => 'nullable',
            'own_capital' => 'nullable',
            'smart_start_shift' => 'nullable',
            'smart_refreshment' => 'nullable',
            'smart_refreshment_text' => 'nullable',
            'smart_deposit' => 'nullable',
            'smart_renewal' => 'nullable',
            'smart_partial_redemption' => 'nullable',
            'smart_interest_income' => 'nullable|numeric',
            'smart_return_goods' => 'nullable',
            'smart_deposit_tickets' => 'nullable',
            'smart_investor_capital' => 'nullable',
            'smart_equity' => 'nullable',
            'smart_fixed_flow' => 'nullable',
            'smart_collection' => 'nullable',
            'smart_collection_text' => 'nullable',
            'smart_ransom' => 'nullable',
            'smart_withdraw_pledges' => 'nullable',
            'smart_selling_goods' => 'nullable',
            'smart_income_goods' => 'nullable|numeric',
            'smart_used_goods' => 'nullable',
            'smart_pledge_tickets' => 'nullable',
            'smart_borrowed_capital' => 'nullable',
            'smart_own_capital' => 'nullable',
            'smart_buying_up' => 'nullable',
            'date' => 'nullable',
//            'smart_consumptions' => 'nullable|array',
//            'express_consumptions' => 'nullable|array',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
