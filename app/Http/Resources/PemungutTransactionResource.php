<?php

namespace App\Http\Resources;

use App\Enums\UserRole;
use Illuminate\Http\Resources\Json\JsonResource;

class PemungutTransactionResource extends JsonResource
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
            "price" => [
                "normal_price" => $this->price,
                "formated_price" => number_format($this->price, 2)
            ],
            "status" => intval($this->status),
            "date" => [
                'date' => $this->updated_at,
                'formated_date' => date('d F Y', strtotime($this->updated_at)),
            ],
        ];
    }
}
