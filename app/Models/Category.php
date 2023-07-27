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
        return $this->belongsTo(Invoice::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function getAllByDistrict($district_id)
    {
        return $this
            ->where('district_id', $district_id)
            ->whereNull('parent_id')
            ->get();
    }

    public function allAddtionalByDistrictId($district_id)
    {
        return $this
            ->whereIn('type', ['packet', 'unit', 'day'])
            ->where('district_id', $district_id)
            ->where('price', '!=', 0)->get();
    }

    public function allMonthlyByDistrictId($district_id)
    {
        return $this
            ->whereIn('type', ['month'])
            ->where('district_id', $district_id)->get();
    }

    public function getTypeTranslationAttribute()
    {
        $translations = [
            'MONTH' => 'BULAN',
            'DAY' => 'HARI',
            'PACKET' => 'PAKET',
        ];

        return $translations[$this->type] ?? '';
    }
}
