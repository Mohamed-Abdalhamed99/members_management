<?php

namespace Modules\Exam\Transformers\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class FillBlankQuestionResource extends JsonResource
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
            'blank_name' => $this->blank_name,
        ];
    }
}
