<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
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
    
            return $this->successResponse($user, 'Berhasil mengubah profil anda', 200);
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
}
