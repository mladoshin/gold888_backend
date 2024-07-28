<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'region_id' => ['required'],
            'user_id' => ['integer', 'nullable'],
            'name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'kpi_day_plan' => ['nullable'],
            'kpi_month_plan' => ['nullable'],
            'kpi_year_plan' => ['nullable'],
            'kpi_day_fact' => ['nullable'],
            'kpi_month_fact' => ['nullable'],
            'kpi_year_fact' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
