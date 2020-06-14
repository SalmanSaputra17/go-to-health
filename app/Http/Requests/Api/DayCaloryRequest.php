<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DayCaloryRequest extends FormRequest
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
            'height' => 'required|numeric|gt:0',
            'weight' => 'required|numeric|gt:0',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'activity_level' => 'required|string'
        ];
    }
}
