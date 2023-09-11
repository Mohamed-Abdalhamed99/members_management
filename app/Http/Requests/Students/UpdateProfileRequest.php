<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $student_id = auth()->user()->id;
        return [
            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name' => ['required' , 'string' , 'max:255'],
            'email' => ['required' , 'email' , 'unique:students,email,'.$student_id],
           // 'password' => ['required' , 'string' , 'confirmed'],
            'mobile' => ['required' , 'string' , 'unique:students,mobile,'.$student_id],
            'address' => ['nullable' , 'string'],
            'gender' => ['required' , 'in:male,female'],
            'birth_date' => ['required' , 'date']
        ];
    }
}
