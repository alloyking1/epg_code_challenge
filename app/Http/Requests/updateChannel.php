<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateChannel extends FormRequest
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
            'name' => 'bail|nullable|string|max:225',
            'icon' => 'bail|nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ];
    }
}
