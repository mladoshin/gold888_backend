<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'branch_id' => ['integer'],
            'start_shift' => ['nullable'],
            'refreshment' => ['nullable'],
            'date' => ['nullable'],
            'deposit' => ['nullable'],
            'renewal' => ['nullable'],
            'partial_redemption' => ['nullable'],
            'interest_income' => ['nullable'],
            'return_goods' => ['nullable'],
            'deposit_tickets' => ['nullable'],
            'investor_capital' => ['nullable'],
            'equity' => ['nullable'],
            'fixed_flow' => ['nullable'],
            'collection' => ['nullable'],
            'ransom' => ['nullable'],
            'withdraw_pledges' => ['nullable'],
            'selling_goods' => ['nullable'],
            'income_goods' => ['nullable'],
            'used_goods' => ['nullable'],
            'pledge_tickets' => ['nullable'],
            'borrowed_capital' => ['nullable'],
            'own_capital' => ['nullable'],
            'report_type' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
