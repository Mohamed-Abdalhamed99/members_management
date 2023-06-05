<?php

namespace Modules\Course\Http\Requests;

use App\Models\LectureContent;
use App\Models\VideoLibrary;
use Illuminate\Foundation\Http\FormRequest;

class AddVideoFromVideoLibraryRequest extends FormRequest
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
            'title' => 'required|string|max:255',
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
