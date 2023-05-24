<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_uuid' => 'string',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'users_categories');
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function getAllByDistrict($district_id){
        return $this
            ->all()
            ->where('district_id', $district_id)
            ->whereNotNull('parent_id');
    }

    public function allAddtionalByDistrictId($district_id){
        return $this
            ->whereIn('type', ['packet', 'unit', 'day'])
            ->where('district_id', $district_id)
            ->where('price', '!=', 0)->get();
    }

}
