<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategories extends Model
{
    use HasFactory;

    protected $table = 'users_categories';

    protected $guarded = '';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subdistrict()
    {
        return $this->hasOne(SubDistrict::class, 'id', 'sub_district_id');
    }

    public function pemungut()
    {
        return $this->hasOne(User::class, 'id', 'pemungut_id');
    }

    public function masyarakat()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
