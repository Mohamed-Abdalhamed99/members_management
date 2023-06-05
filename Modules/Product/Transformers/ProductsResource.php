<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'files' => collect($this->getMedia('product_files'))->transform(function($value){
                return [
                    'id' => $value->id,
                    'url' => $value->original_url,
                    'mime_type' => $value->mime_type
                ];
            }),
            'images' => collect($this->getMedia('product_images'))->transform(function($value){
                return [
                    'id' => $value->id,
                    'url' => $value->original_url,
                    'mime_type' => $value->mime_type
                ];
            })
        ];
    }
}
