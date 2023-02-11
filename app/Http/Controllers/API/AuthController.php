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
        'password' => 'required|string|min:6',
      ]);
  
      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }
  
      if (!auth()->attempt($validator->validated())) {
        return response()->json(['error' => 'Unauthorized'], 401);
      }
  
      $token = Auth::user();

      return $this->createNewToken($token);
    }
  
    public function register(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|between:2,100',
        'username' => 'required|string',
        'type' => 'required',
        'password' => 'required|string|min:6',
      ]);
  
      if ($validator->fails()) {
        return response()->json($validator->errors()->toJson(), 400);
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
      
      return $this->customResponse([
        'access_token' => $_token->createToken('qr_code_retribution')->accessToken,
        'credential_token' => $_token->createToken('qr_code_retribution')->token,
        'token_type' => 'bearer',
        'user' => $user,
      ], "Successfully login to app");
    }
}
