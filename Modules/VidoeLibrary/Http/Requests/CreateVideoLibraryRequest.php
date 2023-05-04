<?php

namespace Modules\VidoeLibrary\Http\Requests;

use App\Models\VideoLibrary;
use Illuminate\Foundation\Http\FormRequest;

class CreateVideoLibraryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:video_library,name',
            'video' => 'nullable|mimes:mp4|required_if:addition_method,' . VideoLibrary::UPLOADED,
            'hours' => 'nullable|required_if:addition_method,' . VideoLibrary::EMBED,
            'minutes' => 'nullable|required_if:addition_method,' . VideoLibrary::EMBED,
            'seconds' => 'nullable|required_if:addition_method,' . VideoLibrary::EMBED,
            'third_party_name' => 'nullable|required_if:addition_method,' . VideoLibrary::EMBED .'|in:'. VideoLibrary::YOUTUBE . ',' . VideoLibrary::VIMEO,
            'addition_method' => 'required|in:' . VideoLibrary::EMBED . ',' . VideoLibrary::UPLOADED,
            'path' => 'nullable|required_if:addition_method,' . VideoLibrary::EMBED,
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
