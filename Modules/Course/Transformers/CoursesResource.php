<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
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
            'created_at' => $this->created_at->format('M d Y'),
            'instructor' => $this->instructor_name,
            'is_publish' => ($this->is_publish) ? 'نشر' : 'مسودة',
            'price' => ($this->price == 0) ? 'مجاني' : $this->price,
            'course_logo' => $this->getFirstMediaUrl('courses_logo'),
            'instructor_avatar' => $this->getFirstMediaUrl('instructor_avatar')
        ];
    }
}
