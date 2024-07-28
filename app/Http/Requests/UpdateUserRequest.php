<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
            'surname' => ['nullable', 'max:254'],
            'email' => ['required', 'email', 'max:254', 'unique:users,email,'.$this->user->id],
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
