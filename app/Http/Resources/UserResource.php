<?php

namespace App\Http\Resources;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'image' => ($this->getFirstMedia('users') == null) ? asset('media1/users/'.$this->avatar) : $this->getFirstMedia('users')->original_url,
            'role' => collect($this->roles)->transform(function($role){
                return ['id' => $role->id , 'name' => $role->name];
            }),
            'permissions' => collect($this->getAllPermissions())->transform(function ($item){
                return [ 'id' => $item->id, 'name' => $item->name];
            })
        ];
    }
}
