<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // protected $primaryKey = 'uuid';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'username',
        'phoneNumber',
        'password',
        'sub_district_id',
        'district_id',
        'role_id',
        'address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'uuid' => 'string',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->uuid = Str::uuid();
    //     });
    // }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'users_categories')->withPivot('address');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function pemungut_transactions()
    {
        return $this->hasMany(PemungutTransaction::class, 'pemungut_id', 'id');
    }

    public function changeUserStatus($id){
        $invoice = Invoice::find('id', $id);
        $invoice->status = (int) !$invoice->status;
        $invoice->save();
    }

    public function getAllCountOfUsersRole(){
        return $this->selectRaw('role_id, count(*) as total')->whereIn('role_id', [1, 2])->groupBy('role_id')->get();
    }

}
