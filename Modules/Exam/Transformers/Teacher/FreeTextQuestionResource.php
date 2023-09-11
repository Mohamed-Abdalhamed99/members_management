<?php

namespace Modules\Exam\Transformers\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;

class FreeTextQuestionResource extends JsonResource
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
            'words' => $this->words
        ];
    }
}
