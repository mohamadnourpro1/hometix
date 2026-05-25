<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('categories', 'name')->ignore($this->route('category')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم التصنيف مطلوب.',
            'name.max' => 'اسم التصنيف يجب ألا يتجاوز :max حرفًا.',
            'name.unique' => 'اسم التصنيف مستخدم بالفعل.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'اسم التصنيف',
        ];
    }
}
