<?php

namespace App\Models;

use App\Http\Resources\UserResource;
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

    public function changeUserStatus($id)
    {
        $invoice = Invoice::find('id', $id);
        $invoice->account_status = (int) !$invoice->account_status;
        $invoice->save();
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'users_categories')
            ->withPivot(['address', 'sub_district_id', 'pemungut_id']);
    }

    public function pemungut_category()
    {
        return $this->hasMany(UserCategories::class, 'pemungut_id', 'id');
    }

    public function getAllCountOfUsersRole()
    {
        return $this->selectRaw('role_id, count(*) as total')->where('district_id', auth()->user()->district_id)
            ->whereIn('role_id', [1, 2])->groupBy('role_id')->get();
    }

    public function show($id){
        return $this
            ->with(['sub_district:id,name', 'district:id,name', 'category'])
            ->where('id', $id)
            ->first();
    }

    public function allUserBySubDistrict($pemungut_id)
    {
        return $this
            ->with(['category' => function ($query) use ($pemungut_id) {
                $query->wherePivot('pemungut_id', $pemungut_id);
            }])
            ->whereIn('id', function ($query) use ($pemungut_id) {
                $query->select('user_id')
                    ->distinct()
                    ->from('users_categories')
                    ->where('pemungut_id', $pemungut_id);
            })
            ->withCount(['category'])
            ->get();
    }

    public function registerUser($validator)
    {
        $input = $validator->validated();

        $stored_user = $this->create(array_merge(
            $input,
            [
                'password' => bcrypt('password'),
                'uuid' => Str::uuid($input['name']),
                'role_id' => 1,
                'account_status' => 1,
            ]
        ));

        $stored_user->category()->attach(
            [$input['category_id']],
            [
                'sub_district_id' => $input['sub_district_id'],
                'address' => $input['address'],
                'pemungut_id' => $input['pemungut_id']
            ]
        );

        $user = User::find($stored_user->id);

        $category = Category::select("id")
            ->where($input['category_id'])
            ->get();

        Invoice::create([
            'uuid_user' => $user->uuid,
            'user_id' => $user->id,
            'category_id' => $input['category_id'],
            'price' => $category->price,
        ]);

        return new UserResource($user);
    }

    public function allMasyarakatByPemungut($pemungut_id = null)
    {
        $results = $this->select('id', 'name', 'phoneNumber', 'sub_district_id', 'role_id')
            ->with(
                [
                    'sub_district:id,name',
                    'pemungut_category' => function ($query) {
                        $query->select('user_id', 'pemungut_id')
                            ->groupBy('user_id', 'pemungut_id')
                            ->with([
                                'user:id,name,phoneNumber',
                            ])
                            ->whereHas('user', function ($query) {
                                $query->where('account_status', 0);
                            });
                    },
                ]
            )
            ->where('district_id', auth()->user()->district_id)
            ->withCount(['pemungut_category' => function ($query) {
                $query
                    ->groupBy('user_id', 'pemungut_id')
                    ->where('role_id', 2)
                    ->with('user')->whereHas('user', function ($query) {
                        $query->where('account_status', 0);
                    });
            }])
            ->having('pemungut_category_count', '>', 0)
            ->where('role_id', 2);

        
        if($pemungut_id){
            return $results->where('id', $pemungut_id)->first();
        }
            
        
        return $results->get();
    }
}
