<?php

namespace App\Http\Requests\Api\Auth;

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
            'username'      => 'required|string|min:5|max:100',
            'gender'        => 'required',
            'date_of_birth' => 'required|date',
            'email'         => 'required|string|email|unique:users|max:100',
            'password'      => 'required|string|min:6|max:190|confirmed'
        ];
    }
}
