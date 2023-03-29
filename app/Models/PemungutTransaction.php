<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemungutTransaction extends Model
{
    use HasFactory;

    public function pemungut(){
        return $this->belongsTo(User::class);
    }
}
