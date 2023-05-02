<?php

namespace Modules\Course\Http\Requests;

use App\Models\MediaLibrary;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:courses,name',
            'sub_title' => 'required|string|max:255',
            'is_catalog' => 'required|boolean',
            'instructor_name' => 'required|string|max:255',
            'level_id' => 'required|exists:courses_levels,id',
            'course_category_id' => 'required|exists:courses_categories,id',
            'about_course' => 'required|string',
            'about_instructor' => 'required|string',
            'highlights_1' => 'required|string|max:255',
            'highlights_2' => 'nullable|string|max:255',
            'highlights_3' => 'nullable|string|max:255',
            'highlights_4' => 'nullable|string|max:255',
            'highlights_5' => 'nullable|string|max:255',
            'promotional_video' => 'nullable|string',
            'price' => 'required|numeric',
            'is_publish' => 'required|boolean',
            'course_logo' => 'nullable|image|required_if:course_logo_addition_method,==,'.MediaLibrary::UPLOADED,
            'course_logo_addition_method' => 'required|string|in:' . MediaLibrary::UPLOADED . ',' . MediaLibrary::EMBED,
            'instructor_avatar' => 'nullable|image',
            'media_library_id' => "nullable|exists:media_library,id|required_if:course_logo_addition_method,==,".MediaLibrary::EMBED,
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
