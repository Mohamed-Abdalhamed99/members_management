<?php

namespace Modules\Course\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sub_title' => $this->sub_title,
            'about_course' => $this->about_course,
            'is_catalog' => $this->is_catalog,
            'course_level' => [
                'id' => $this->course_level->id,
                'name' => $this->course_level->name,
            ],
            'course_category' => [
                'id' => $this->course_category->id,
                'name' => $this->course_category->name,
            ],
            'created_at' => $this->created_at->format('M d Y'),
            'instructor' => [
                'instructor_name' => $this->instructor_name,
                'instructor_avatar' => $this->getFirstMediaUrl('instructor_avatar'),
                'about_instructor' => $this->about_instructor,
            ],
            'is_publish' => [
                'value' => $this->is_publish,
                'display_name' => ($this->is_publish) ? 'نشر' : 'مسودة',
            ],
            'price' => ($this->price == 0) ? 'مجاني' : $this->price,
            'highlights_1' => $this->highlights_1,
            'highlights_2' => $this->highlights_2,
            'highlights_3' => $this->highlights_3,
            'highlights_4' => $this->highlights_4,
            'highlights_5' => $this->highlights_5,
            'course_logo' => $this->getFirstMediaUrl('courses_logo'),
            'promotional_video' => $this->promotional_video,

        ];
    }
}
