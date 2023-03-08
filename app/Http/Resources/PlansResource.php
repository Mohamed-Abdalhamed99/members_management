<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlansResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'licenses' => collect($this->permissions)->transform(function ($item){
                return [ 'id' => $item->id, 'display_name' => $item->{'display_name_'.app()->getLocale()}];
            })
        ];
    }
}
