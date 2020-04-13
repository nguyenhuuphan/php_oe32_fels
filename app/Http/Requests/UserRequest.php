<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        switch($this->method()) {
            case 'POST':
                $password_rule = 'required|string|min:8';
            case 'PATCH':
                $password_rule = 'nullable|required_with:password_confirmation|string|min:8|confirmed';
        }

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'string',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id, 'id')
            ],
            'password' => $password_rule,
        ];
    }
}
