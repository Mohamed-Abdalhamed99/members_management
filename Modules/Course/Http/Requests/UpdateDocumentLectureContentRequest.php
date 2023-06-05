<?php

namespace Modules\Course\Http\Requests;

use App\Models\LectureContent;
use App\Models\VideoLibrary;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentLectureContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lecture_id' => 'required|exists:lectures,id',
            'title' => 'required|string|max:255',
            'document' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,text,ppt,pptx',
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
