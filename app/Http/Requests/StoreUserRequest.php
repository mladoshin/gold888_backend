<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'surname' => ['nullable'],
            'email' => ['required', 'email', 'max:254', 'unique:users'],
            'password' => ['required'],
            'phone' => ['nullable'],
            'image' => ['nullable', 'image:jpg,png,jpeg'],
            'role' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
