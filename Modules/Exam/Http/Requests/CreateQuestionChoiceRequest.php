<?php

namespace Modules\Exam\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionChoiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exam_id' => ['required' , 'numeric' , 'exists:exams,id'],
            'question_type_id' => ["in:1"],
            'title' => ['required' , 'string' , 'max:255'],
            'grade' => ['required' , 'numeric' ],
            'choice_a' => ['required' , 'string' , 'max:255'],
            'choice_b' => ['required' , 'string' , 'max:255'],
            'choice_c' => ['required' , 'string' , 'max:255'],
            'choice_d' => ['required' , 'string' , 'max:255'],
            'answer' => ['required' , 'string' , 'max:255']
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

    public function messages()
    {
        return [
            'question_type_id' => "يجب أن يكون السؤال اختيار من متعدد",
        ];
    }
}
