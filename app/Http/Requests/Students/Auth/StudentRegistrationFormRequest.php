<?php

namespace App\Http\Requests\Students\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;


class StudentRegistrationFormRequest extends FormRequest
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
            'email' => ['required' , 'email' , 'unique:students,email'],
           // 'password' => ['required' , 'string' , 'confirmed'],
            'mobile' => ['required' , 'string' , 'unique:students,mobile'],
            'address' => ['nullable' , 'string'],
            'avatar' => ['nullable' , 'image'],
            'gender' => ['required' , 'in:male,female'],
            'birth_date' => ['required' , 'date'],
        ];
    }
}
