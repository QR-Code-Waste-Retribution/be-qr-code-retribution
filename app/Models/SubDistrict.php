<?php

namespace App\Models;

use App\Http\Resources\SubDistrictResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getSubDistrictByDistrictUser()
    {
        return self::all()->where('district_id', auth()->user()->district_id);
    }

    public function getSubDistrictByDistrictUserAPI($district_id)
    {
        return [
            'sub_districts' => SubDistrictResource::collection($this->all()->where('district_id', $district_id)),
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
