<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => ['required' , 'string' , 'max:255' , 'required:plans,name_en,'.$this->plan->id],
            'name_ar' => ['required' , 'string' , 'max:255' , 'required:plans,name_ar,'.$this->plan->id],
            'description' => ['nullable' , 'string'],
            'price' => ['required' , 'numeric'],
            'permissions' => ['required']
        ];
    }
}
