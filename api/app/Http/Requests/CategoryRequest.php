<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            "category_ids" => "required|array",
            "category_ids.*" => "required|exists:membership_categories,id"
        ];
    }

    public function messages()
    {
        logger(request()->category_ids);
        return [
            "category_ids.required" => "The category IDs are required.",
            "category_ids.array" => "The category IDs must be an array.",
            "category_ids.*.required" => "Each category ID is required.",
            "category_ids.*.exists" => "One or more selected category IDs do not exist in the membership categories."
        ];
    }
    
}
