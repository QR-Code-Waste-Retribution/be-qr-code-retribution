<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function GuzzleHttp\Promise\all;

class SubDistrict extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getSubDistrictByDistrictUser(){
        return self::all()->where('district_id', auth()->user()->district_id);
    }
}
