<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepositPemungutResource extends JsonResource
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
            'price' => [
                "normal_price" => (int)$this->total,
                "formated_price" => number_format($this->total, 2)
            ],
            'date' =>  date('F Y', strtotime($this->date)),
            'status' => $this->status
        ];
    }
}
