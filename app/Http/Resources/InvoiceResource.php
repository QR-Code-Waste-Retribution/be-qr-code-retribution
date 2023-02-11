<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            "id" =>  $this->id,
            "category_id" =>  $this->category_id,
            "price" => [
                "price" => $this->price,
                "formated_price" => number_format($this->price, 2),
            ],
            "user_id" =>  1,
            "type" =>  0,
            "created_at" =>  date('Y-m-d H:i:s', strtotime($this->created_at)),
            "category" => $this->category
        ];
    }
}
