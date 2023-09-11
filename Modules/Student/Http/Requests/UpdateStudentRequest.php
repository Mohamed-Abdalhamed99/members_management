<?php

namespace Modules\Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
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
            'email' => ['required' , 'email' , 'unique:students,email,'.$this->student->id],
            'mobile' => ['required' , 'string' , 'unique:students,mobile,'.$this->student->id],
            'address' => ['nullable' , 'string'],
            'avatar' => ['nullable' , 'image'],
            'gender' => ['required' , 'in:male,female'],
            'birth_date' => ['required' , 'date'],
            'status' => ['required' , 'boolean'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
