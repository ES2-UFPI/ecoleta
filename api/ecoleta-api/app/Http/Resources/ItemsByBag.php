<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemsByBag extends JsonResource
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
            'user' => $this->resource->client()->first(),
            'collect_point' => $this->resource->collectPoint->first(),
            'item' => ItemByCollectionItem::collection($this->resource->item()->get()),
        ];
    }
}
