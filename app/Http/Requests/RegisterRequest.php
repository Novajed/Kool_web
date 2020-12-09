<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users|unique:teachers',
            'password'    => 'required|string|min:8|confirmed',
            'access_code' => 'nullable|exists:organizations,id',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'The email has already been taken.',
            'access_code.exists' => 'The access code is invalid.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
