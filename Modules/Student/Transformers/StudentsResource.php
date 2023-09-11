<?php

namespace Modules\Student\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentsResource extends JsonResource
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
            'full_name' => $this->full_name,
            'code' => $this->code,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'avatar' => ($this->getFirstMedia('students') == null) ? asset('media1/students/'.$this->avatar) : $this->getFirstMedia('students')->original_url,
            'join_date' => $this->join_date,
            'status' => ($this->status) ? 'فعال' : 'غير فعال',
        ];
    }
}
