<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
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
            'complete_rule' => [
                'value' => $this->completed_rule,
                'complete_rule_name' => $this->complete_rule_name,
            ],
            'contents' => LectureContentResource::collection($this->lecture_contents)
        ];
    }
}
