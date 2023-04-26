<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FInvoiceResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'category' => new CategoryResource($this->category),
            'price' => [
                "normal_price" => $this->price,
                "formated_price" => number_format($this->price, 2)
            ],
            'status' => $this->status,
        ];
    }
}
