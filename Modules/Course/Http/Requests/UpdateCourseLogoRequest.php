<?php

namespace Modules\Course\Http\Requests;

use App\Models\MediaLibrary;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseLogoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_logo' => 'nullable|image|required_if:course_logo_addition_method,==,'.MediaLibrary::UPLOADED,
            'course_logo_addition_method' => 'required|string|in:' . MediaLibrary::UPLOADED . ',' . MediaLibrary::EMBED,
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
