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
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'active' => 'required|integer|min:0|max:1',
        ];

        $locales = get_locales();
        $langRules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
        ];

        foreach ($langRules as $field => $rule) {
            foreach($locales as $locale) {
                $rules[$field . ':' . $locale] = $rule;
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [

        ];
    }
}
