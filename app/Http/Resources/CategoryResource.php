<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "status" => $this->status ? 'active' : 'non-active',
            "type" => $this->type,
            "parent_id" => 43,
            "district" => new DistrictResource($this->district),
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
