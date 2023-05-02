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
                "normal_price" => $this->price,
                "formated_price" => number_format($this->price, 2)
            ],
            "user_id" =>  $this->user_id,
            "status" =>  $this->status,
            "category" => new CategoryResource($this->category),
            "address" => $this->address,
            "sub_district_name" => $this->sub_district_name,
            "date" => $this->date,
            "variants" => array_map('intval', array_unique(array_filter(explode(',', $this->variants)))),
            "created_at" => [
                'date' => $this->created_at,
                'formated_date' => date('d F Y', strtotime($this->created_at)),
            ],
            "updated_at" => [
                'date' => $this->updated_at,
                'formated_date' => date('d F Y', strtotime($this->updated_at)),
            ]
        ];
    }
}
