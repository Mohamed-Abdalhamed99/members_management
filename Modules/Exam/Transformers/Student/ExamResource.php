<?php

namespace Modules\Exam\Transformers\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'questions' => QuestionResource::collection($this->questions)
        ];
    }


    
}
