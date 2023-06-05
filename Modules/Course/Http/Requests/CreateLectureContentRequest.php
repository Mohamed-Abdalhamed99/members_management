<?php

namespace Modules\Course\Http\Requests;

use App\Models\LectureContent;
use Illuminate\Foundation\Http\FormRequest;

class CreateLectureContentRequest extends FormRequest
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
            'video_id' => 'nullable|required_if:type,1|exists:lectures,id', // type = 1 means video
            'type' => 'required|in:' . LectureContent::VIDEO . ',' . LectureContent::ARTICLE . ',' . LectureContent::VOICE . ',' . LectureContent::DOCUMENT,
            'title' => 'required|string|max:255',
            'file' => 'nullable|required_unless:type,1|mimes:jpeg,jpg,png,gif,svg,tif,tiff,pdf,doc,docx,xls,xlsx,text,mp4,avi,ppt,pptx,mp3'

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
