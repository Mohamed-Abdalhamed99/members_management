<?php

namespace Modules\MediaLibrary\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUploadedFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:media_library,name,'.$this->mediaLibrary->id,
            'file' => 'nullable|mimes:jpeg,jpg,png,gif,svg,tif,tiff,pdf,doc,docx,xls,xlsx,text,mp4,avi,ppt,pptx,mp3,m4a,wav'
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
