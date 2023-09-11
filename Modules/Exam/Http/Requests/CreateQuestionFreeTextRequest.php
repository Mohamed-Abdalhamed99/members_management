<?php

namespace Modules\Exam\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionFreeTextRequest extends FormRequest
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
            'question_type_id' => ['in:4'],
            'title' => ['required' , 'string' , 'max:255'],
            'grade' => ['required' , 'numeric' ],
            'words' => ['required' , 'numeric']
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
            'question_type_id' => "يجب أن يكون السؤال مقالي",
        ];
    }
}
