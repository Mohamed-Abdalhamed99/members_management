<?php

namespace Modules\Student\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowStudentsResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'code' => $this->code,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'avatar' => ($this->getFirstMedia('students') == null) ? asset('media1/students/'.$this->avatar) : $this->getFirstMedia('students')->original_url,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'join_date' => $this->join_date,
            'email_verified' => ($this->email_verified_at == null) ? false : true,
            'mobile_verified' =>  ($this->mobile_verified_at == null) ? false : true,
            'address' => $this->address,
        ];
    }
}
