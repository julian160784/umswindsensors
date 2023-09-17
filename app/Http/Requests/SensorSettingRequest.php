<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SensorSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parameter' => 'required',
            'description' => 'required',
            'min_value' => 'required',
            'max_value' => 'required',
            // 'unit' => 'required',
            'value_formatter' => 'required'
        ];
    }
}
