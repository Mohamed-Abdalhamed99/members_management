<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;


class RegistrationFormRequest extends FormRequest
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
            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name' => ['required' , 'string' , 'max:255'],
            'email' => ['required' , 'email' , 'unique:users,email'],
            'password' => ['required' , 'string' , 'confirmed'],
            'mobile' => ['nullable' , 'string' , 'unique:users,mobile'],
            'address' => ['nullable' , 'string'],
            'image' => ['nullable' , 'image']
        ];
    }
}
