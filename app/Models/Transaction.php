<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function getAllById($id){
        return self::all()->where('user_id', $id);
    }

    public static function getHistoryTransactionOfPemungut($pemungut_id){
        return self::where('pemungut_id', $pemungut_id)->get();
    }   

    
}
