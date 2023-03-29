<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function editProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required',
            'address' => 'required',
        ], [
            'required' => 'Input :attribute tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
        }

        $user_id = $request->user_id;
        $user = User::where('id', $user_id);

        $user->phoneNumber = $request->phoneNumber;
        $user->address = $request->address;

        $user->save();

        return $this->successResponse($user, 'Berhasil mengubah profil anda', 200);
    }

    public function changePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
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
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return $this->successResponse($user, 'Berhasil mengubah password anda', 200);
    }
}
