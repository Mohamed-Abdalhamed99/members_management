<?php

namespace Modules\Exam\Transformers\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
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
            'title' => $this->title,
            'type' => [
                'id' => $this->questionTypes->id,
                'name' =>  $this->questionTypes->type,
            ],
            'grade' => $this->grade,
        ];
    }
}
