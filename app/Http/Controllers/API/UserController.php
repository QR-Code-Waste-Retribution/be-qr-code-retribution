<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function editProfile(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phoneNumber' => 'required',
                'address' => 'required',
            ], [
                'required' => 'Input :attribute tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
            }

            $user = User::find($id);

            $user->phoneNumber = $request->phoneNumber;
            $user->address = $request->address;

            $user->save();

            return $this->successResponse(new UserResource($user), 'Berhasil mengubah profil anda', 200);
        } catch (\Throwable $err) {
            return $this->errorResponse('', $err->getMessage(), 401);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed', // attr: password_confirmation
        ], [
            'required' => 'Input :attribute tidak boleh kosong',
            'confirmed' => 'Input :attribute harus sama',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse([], "User tidak ditemukan", 401);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->errorResponse([], "Password anda salah", 401);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return $this->successResponse($user, 'Berhasil mengubah password anda', 200);
    }

    public function editMasyarakatProfile(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'nik' => 'required',
            'phoneNumber' => 'required',
            'category_id' => 'required',
            'sub_district_id' => 'required',
            'address' => 'required',
        ], [
            'required' => 'Input :attribute tidak boleh kosong',
            'confirmed' => 'Input :attribute harus sama',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse([], "User tidak ditemukan", 401);
        }
    }

    public function getAllUserBySubDistrict($pemungut_id)
    {
        try {
            $users = UserResource::collection($this->user->allUserBySubDistrict($pemungut_id));
            return $this->successResponse($users, "Successfully to get all users");
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }
}
