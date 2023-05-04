<?php

namespace Modules\VidoeLibrary\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoLibraryResource extends JsonResource
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
            'time_duration' => $this->time_duration,
            'size' => ($this->size != null) ? round($this->size / 1024 / 1024 , 2) . 'MB' : null,
            'third_party_name' => $this->third_party_name,
            'path' => $this->url,
            'created_at' => $this->created_at->format('d M Y')
        ];
    }
}
