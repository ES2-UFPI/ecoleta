<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemsByBagRescue extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'recue' => $this->resource->recue,
            'bag' => new Bag($this->resource->bag()->first()),
            // 'company' => $this->resource->company()->first(),
            // 'item' => $this->resource->item()->get(),
        ];
    }
}
