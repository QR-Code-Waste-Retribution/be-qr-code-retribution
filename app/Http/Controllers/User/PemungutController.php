<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PemungutRequest;
use App\Models\SubDistrict;
use App\Models\User;
use Exception;
use Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;

class PemungutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $sub_district = $request->sub_district ?? null;

        $pemungut = User::where('role_id', 2)
            ->where('district_id', auth()->user()->district_id)
            ->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phoneNumber', 'like', '%' . $search . '%');
            });
        // 

        if ($sub_district && $sub_district != 'all') {
            $pemungut = $pemungut->where('sub_district_id', $sub_district);
        }

        $pemungut = $pemungut->paginate(10);

        $sub_districts = SubDistrict::where('district_id', auth()->user()->district_id)->get();
        return view('pages.user.pemungut.index', compact('sub_districts', 'pemungut'));
    }

    public function changeStatusUser(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $user->account_status = !$user->account_status;
            $user->save();

            return $this->successResponse($user, 'Success to change user status');
        } catch (Exception $err) {
            return $this->errorResponse([], 'Something went wrong');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_districts = SubDistrict::all()->where('district_id', auth()->user()->district_id);
        return view('pages.user.pemungut.add', compact('sub_districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PemungutRequest $request)
    {
        $rules = [
            'name' => 'required|regex:/^[A-Za-z\s]+$/',
        ];

        $validated = $request->validated();

        try {
            User::create([
                'name' => $validated['name'],
                'uuid' => fake()->unique()->uuid(),
                'username' => $validated['username'],
                'sub_district_id' => $validated['kecamatan'],
                'district_id' => auth()->user()->district_id,
                'password' => bcrypt("password"),
                'role_id' => 2,
                'gender' => $validated['jenis_kelamin'],
                'phoneNumber' => $validated['nomor_telepon'],
                'address' => $validated['alamat'],
                'verification_status' => 1,
            ]);

            return redirect()->back()->with([
                'type' => 'success',
                'status' => 'Yeyyyy, Anda berhasil menambahkan Petugas Baru',
            ]);
        } catch (Throwable $err) {
            return redirect()->back()->with([
                'type' => 'danger',
                'status' => $err->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pemungut = User::find($id);
        $sub_districts = SubDistrict::all()->where('district_id', auth()->user()->district_id);

        return view('pages.user.pemungut.edit', compact('pemungut', 'sub_districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PemungutRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $pemungut = User::find($id);
            $pemungut->name = $validated['name'];
            $pemungut->username = $validated['username'];
            $pemungut->sub_district_id = $validated['kecamatan'];
            $pemungut->gender = $validated['jenis_kelamin'];
            $pemungut->phoneNumber = $validated['nomor_telepon'];
            $pemungut->address = $validated['alamat'];
            $pemungut->save();

            return redirect()->back()->with([
                'type' => 'success',
                'status' => 'Yeyyyy, Anda berhasil mengubah Petugas ' . $pemungut->name,
            ]);
        } catch (Throwable $err) {
            return redirect()->back()->with([
                'type' => 'danger',
                'status' => $err->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
