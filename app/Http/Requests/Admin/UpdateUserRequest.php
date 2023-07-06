<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
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
            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name' => ['required' , 'string' , 'max:255'],
            'email' => ['required' , 'email' , 'unique:users,email,'.$this->user->id],
            'mobile' => ['nullable' , 'string' , 'unique:users,mobile,'.$this->user->id],
            'address' => ['nullable' , 'string'],
            'image' => ['nullable' , 'image'],
            'role_id' => ['required' , 'exists:roles,id' , 'numeric'],
        ];
    }
}
