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
            'name' => ['required' , 'string' , 'max:255' , 'unique:plans,name,'.$this->plan->id],
            'annually_price' => ['required' , 'numeric'],
            'monthly_price' => ['required' , 'numeric'],
            'features' => ['nullable'  , 'array'],
            'features.*' => ['string'  , 'max:255']
        ];
    }
}
