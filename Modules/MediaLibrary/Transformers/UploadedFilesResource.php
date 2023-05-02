<?php

namespace Modules\MediaLibrary\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadedFilesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'size' => $this->size,
            'type' => $this->mime_type,
            'url' => asset($this->path)
        ];
    }
}
