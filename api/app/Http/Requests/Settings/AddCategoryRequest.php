<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
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
            'name' => 'required|string',
            'code' => 'required|string|unique:membership_categories,code',
        ];

    }
    public function messages()
    {

        return [
            "code.required" => "Category Code Is Required.",
            "code.string" => "Category code must be an string.",
            "code.unique" => "Category code exists.",
            "name.required" => "Category Name Is Required.",
            "name.string" => "Category Name must be an string.",
        ];
    }

}
