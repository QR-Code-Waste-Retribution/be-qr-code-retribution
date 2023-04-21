<?php

namespace App\Http\Resources\DokuFormat;

use Illuminate\Http\Resources\Json\JsonResource;

class LineItemOrderDokuResource extends JsonResource
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
            "name" => $this->category->name,
            "quantity" => 1,
            "price" => $this->price,
        ];
    }
}
