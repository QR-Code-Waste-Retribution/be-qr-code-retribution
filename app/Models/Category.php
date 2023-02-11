<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_uuid' => 'string',
    ];

    public function user(){
        return $this->belongsToMany(User::class, 'users_categories');
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }


}
