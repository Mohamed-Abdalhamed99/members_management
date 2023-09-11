<?php

namespace Modules\Exam\Transformers\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowQuestionResource extends JsonResource
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
            'details' => $this->getDetailResource()
        ];
    }

    protected function getDetailResource()
    {
        if($this->question_type_id == 1){
            return  ChoicesQuestionResource::collection($this->getQuestionDetails());
        }elseif($this->question_type_id == 2){
            return FillBlankQuestionResource::collection($this->getQuestionDetails());
        }elseif($this->question_type_id == 3){
            return  TrueFalseQuestionResource::collection($this->getQuestionDetails());
        }elseif($this->question_type_id == 4){
            return  FreeTextQuestionResource::collection($this->getQuestionDetails());
        }elseif($this->question_type_id == 5){
            return MatchingQuestionResource::collection($this->getQuestionDetails());
        }
    }
}
