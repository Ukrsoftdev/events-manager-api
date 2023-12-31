<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AuthLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:organizations,email'],
            'password' => ['required'],
        ];
    }
}
