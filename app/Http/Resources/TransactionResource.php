<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "id" => $this->id, 
            "price" => [
                "normal_price" => $this->price,
                "formated_price" => number_format($this->price, 2)
            ],
            "status" => $this->status,
            "date" => $this->date,
            "type" => $this->type,
            "reference_number" => $this->reference_number,
            "transaction_number" => $this->transaction_number,
            "user" => new UserResource($this->user),
            "pemungut_id" => $this->pemungut_id,
            "category" => $this->category_id,
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
