<?php

namespace Modules\Exam\Transformers\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;

class TrueFalseQuestionResource extends JsonResource
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
            'answer' => $this->answer
        ];
    }
}
