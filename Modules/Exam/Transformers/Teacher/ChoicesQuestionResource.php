<?php

namespace Modules\Exam\Transformers\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;

class ChoicesQuestionResource extends JsonResource
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
            'choice_a' => $this->choice_a,
            'choice_b' => $this->choice_b,
            'choice_c' => $this->choice_c,
            'choice_d' => $this->choice_d,
            'answer' => $this->answer,
        ];
    }
}
