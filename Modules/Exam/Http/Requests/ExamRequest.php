<?php

namespace Modules\Exam\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = request()->method();
        switch ($method) {
            case "POST":
              return [
                'name' => ['required','string' , 'max:255' , 'unique:exams,name'],
                'description' => ['required','string'],
                'instructor' => ['nullable','string' , 'max:255'],
                'instructions' => ['required','string'],
                'passing_score' => ['numeric' , 'required'],
                'price' => ['numeric' , 'required'],
              ];
              break;
            case "PUT":
                return [
                    'name' => ['required','string' , 'max:255' , 'unique:exams,name,' . $this->exam->id],
                    'description' => ['required','string'],
                    'instructor' => ['nullable','string' , 'max:255'],
                    'instructions' => ['required','string'],
                    'passing_score' => ['numeric' , 'required'],
                    'price' => ['numeric' , 'required'],
                  ];
              break;
          }
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
