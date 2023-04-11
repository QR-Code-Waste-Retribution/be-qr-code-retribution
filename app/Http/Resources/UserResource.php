<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'nik' => $this->nik,
            'gender' => $this->gender,
            'address' => $this->address,
            'phoneNumber' => $this->phoneNumber,
            'email_verified_at' => $this->email_verified_at,
            'sub_district_id' => $this->sub_district_id,
            'district_id' => $this->district_id,
            'district' => new DistrictResource($this->district),
            'sub_district' => new SubDistrictResource($this->sub_district),
            'role_id' => $this->role_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => new RoleResource($this->role),
        ];
    }
}
