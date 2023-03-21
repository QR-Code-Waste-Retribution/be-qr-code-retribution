<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function sub_district_rand()
    {
        return $this->hasMany(SubDistrict::class)->inRandomOrder();
    }
}
