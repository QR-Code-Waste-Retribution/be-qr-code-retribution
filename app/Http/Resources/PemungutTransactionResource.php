<?php

namespace App\Http\Resources;

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
            "id" => $this->id,
            "status" => $this->status,
            "created_at" => [
                'date' => $this->created_at,
                'formated_date' => date('d F Y', strtotime($this->created_at)),
            ],
            "updated_at" => [
                'date' => $this->updated_at,
                'formated_date' => date('d F Y', strtotime($this->updated_at)),
            ],
            'transaction' => TransactionResource::collection($this->masyarakat_transactions),
        ];
    }
}
