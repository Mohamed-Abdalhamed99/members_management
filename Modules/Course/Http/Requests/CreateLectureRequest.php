<?php

namespace Modules\Course\Http\Requests;

use App\Models\Lecture;
use Illuminate\Foundation\Http\FormRequest;

class CreateLectureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'chapter_id' => 'required|exists:chapters,id',
            'completed_rule' => "required|in:".Lecture::MARK_AS_LEARNED_CHECKBOX.','.Lecture::COMPLETE_VIDEO_PERCENTAGE.','.Lecture::PASSING_QUIZE
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
