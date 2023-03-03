<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }

  public function login(Request $request)
  {


    $validator = Validator::make($request->all(), [
      'username' => 'required',
      'password' => 'required|min:6',
    ], [
      'required' => 'Input :attribute tidak boleh kosong',
      'min' => 'Input :attribute harus minimal 6 karakter.',
    ]);

    if ($validator->fails()) {
      return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
    }

    if (!auth()->attempt($validator->validated())) {
      return $this->errorResponse('', 'Username atau password anda salah', 401);
    }

    $token = Auth::user();

    return $this->createNewToken($token);
  }

  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      "name" => "required",
      "username" => "required",
      "gender" => "required",
      "phoneNumber" => "required",
      "district_id" => "required",
      "sub_district_id" => "required",
      "urban_village_id" => "requried"
    ], [
      'required' => 'Input :attribute tidak boleh kosong',
    ]);

    if ($validator->fails()) {
      return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
    }

    $user = User::create(array_merge(
      $validator->validated(),
      ['password' => bcrypt($request->password)]
    ));

    return response()->json([
      'message' => 'User successfully registered',
      'user' => $user
    ], 201);
  }

  protected function createNewToken($_token)
  {
    $auth = auth()->user();
    $user = json_decode(json_encode($auth), true);
    $user['role'] = $auth->role->name;
    $user['district'] = $auth->district->name;
    $user['sub_district'] = $auth->sub_district->name;
    $user['urban_village'] = $auth->urban_village->name;

    return $this->successResponse([
      'access_token' => $_token->createToken('qr_code_retribution')->accessToken,
      'credential_token' => $_token->createToken('qr_code_retribution')->token,
      'token_type' => 'bearer',
      'user' => $user,
    ], "Successfully login to app");
  }
}
