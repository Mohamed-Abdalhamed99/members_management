<?php

namespace Modules\Exam\Transformers\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class QtypeTrueOrFalseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
