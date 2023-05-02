<?php

namespace Modules\MediaLibrary\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmbedFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:media_library,name',
            'path' => 'required|string',
            'mime_type' => 'required|string'
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
