<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this -> id,
            'product_title' => $this->title,
            'product_description' => $this->description,
            'product_unit' => new UnitResource($this->hasUnit),
            'product_price' => $this->price,
            'product_total' => $this->total,
            'product_discount' => $this->discounted_price,
            'product_category' => new CategoryResource($this->Category),
            'product_tags' => TagResource::collection($this->tags),
            'product_images' => ImageResource::collection($this->images),
            'product_reviews' => ReviewResource::collection($this->reviews),
            'product_options' => $this->jsonOptions()
        ];
    }
}
