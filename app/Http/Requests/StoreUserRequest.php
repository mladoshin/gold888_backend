<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'branch_id' => ['integer', 'required_if:role,user,branch_director'],
            'name' => ['required'],
            'surname' => ['nullable'],
            'email' => ['required', 'email', 'max:254', 'unique:users'],
            'password' => ['required'],
            'phone' => ['nullable'],
            'image' => ['nullable', 'image:jpg,png,jpeg'],
            'role' => ['required'],
            'cities' => ['array', 'nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
