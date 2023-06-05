<?php

namespace Modules\Course\Http\Requests;

use App\Models\LectureContent;
use App\Models\VideoLibrary;
use Illuminate\Foundation\Http\FormRequest;

class EmbedVideoRequest extends FormRequest
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
            'path' => 'required|string',
            'hours' => 'required|numeric|between:0,9999',
            'minutes' => 'required|numeric|between:0,60',
            'seconds' => 'required|numeric|between:0,60',
            'third_party_name' => 'required|in:'. VideoLibrary::YOUTUBE . ',' . VideoLibrary::VIMEO,
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
