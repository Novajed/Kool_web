<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccessCodeRequest extends FormRequest
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
            'access_code' => 'exists:organizations,id',
        ];
    }

    public function messages()
    {
        return [
            'access_code.exists' => 'The given data is invalid.',
        ];
    }
}
