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
            'annually_price' => [
                'total_price' => $this->annually_price,
                'price_per_month' => round($this->annually_price/12 , 2)
            ],
            'monthly_price' => $this->monthly_price,
            'features' => collect($this->features)->transform(function ($item){
                return [ 'id' => $item->id, 'feature' => $item->feature];
            })
        ];
    }
}
