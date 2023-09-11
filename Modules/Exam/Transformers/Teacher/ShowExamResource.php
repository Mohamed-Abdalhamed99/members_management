<?php

namespace Modules\Exam\Transformers\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Exam\Transformers\Teacher\QuestionsResource;

class ShowExamResource extends JsonResource
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
            'instructor' => $this->instructor,
            'passing_score' => $this->passing_score,
            'price' => $this->price,
            'created_at' =>$this->created_at->format('Y/m/d h:i a'),
            'questions' => QuestionsResource::collection($this->questions)
        ];
    }
}
