<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokuCheckout extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function insert(){
        return $this->create([
            
        ]);
    }
}
