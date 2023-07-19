<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Utils\SendMessageToEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public $user;

  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register', 'forgetPassword', 'checkOTP', 'changePassword']]);
    $this->user = new User();
  }

  public function login(Request $request)
  {
    try {
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
    } catch (Exception $err) {
      return $this->errorResponse('', $err->getMessage(), 500);
    }
  }

  public function register(Request $request)
  {

    try {
      $validator = Validator::make($request->all(), [
        "name" => "required",
        "nik" => "unique:users|max:16|min:16",
        "username" => "required|unique:users",
        "email" => "required|email|unique:users",
        "gender" => "required",
        "phoneNumber" => "required|unique:users|min:11|max:15",
        "district_id" => "required",
        "sub_district_id" => "required",
        "category_id" => "required",
        "address" => "required|min:3",
        "pemungut_id" => "required",
      ], [
        'required' => ':attribute tidak boleh kosong',
        'phoneNumber.required' => 'nomor telepon tidak boleh kosong',
        'name.required' => 'nama tidak boleh kosong',
        'required' => ':attribute tidak boleh kosong',
        'unique' => ':attribute sudah digunakan',
        'min' => ':attribute harus memiliki minimal :min karakter',
        'max' => ':attribute harus memiliki maximal :max karakter',
        'phoneNumber.min' => ':attribute harus memiliki minimal :min karakter',
        'phoneNumber.max' => ':attribute harus memiliki maximal :max karakter',
        'phoneNumber.unique' => 'nomor telepon sudah digunakan',
      ]);

      if ($validator->fails()) {
        $errors = collect($validator->errors())->map(function ($value) {
          return $value[0];
        })->toArray();
        return $this->errorResponse($errors, 'Input tidak boleh ada yang kosong', 422);
      }

      $user = $this->user->registerUser($validator);

      return $this->successResponse($user, 'Berhasil mendaftarkan masyarakat', 200);
    } catch (\Throwable $err) {
      return $this->errorResponse('Something Went Error', $err->getMessage(), 401);
    }
  }

  protected function createNewToken($_token)
  {
    $user = auth()->user();

    if (!$user->account_status) {
      return $this->errorResponse([], "Akun anda belum diaktifkan!!", 403);
    }

    if (!$user->verification_status) {
      return $this->errorResponse([], "Akun anda belum teverifikasi!!", 403);
    }

    return $this->successResponse([
      'access_token' => $_token->createToken('qr_code_retribution')->accessToken,
      'credential_token' => $_token->createToken('qr_code_retribution')->token,
      'token_type' => 'bearer',
      'user' => new UserResource($user),
    ], "Berhasil masuk ke aplikasi !!");
  }


  public function forgetPassword(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        "email" => "required",
      ], [
        'required' => ':attribute tidak boleh kosong',
      ]);

      if ($validator->fails()) {
        return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
      }

      $this->user->forgetPassword($validator);

      return $this->successResponse([], 'Berhasil mengirim kode otp');
    } catch (\Throwable $th) {
      return $this->errorResponse([], $th->getMessage(), $th->getCode() ?? 500);
    }
  }


  public function changePassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required', // attr: password_confirmation
      'password' => 'required|confirmed|min:8', // attr: password_confirmation
    ], [
      'required' => 'Input :attribute tidak boleh kosong',
      'confirmed' => 'Input :attribute harus sama',
    ]);

    if ($validator->fails()) {
      return $this->errorResponse($validator->errors(), 'Input harus valid', 422);
    }

    $user = User::where('email', $request->email);

    if (!$user) {
      return $this->errorResponse([], "User tidak ditemukan", 401);
    }

    $user->update([
      'password' => Hash::make($request->password),
    ]);

    return $this->successResponse($user, 'Berhasil mengubah password anda', 200);
  }

  public function checkOTP(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        "email" => "required",
        "otp_code" => "required",
      ], [
        'required' => ':attribute tidak boleh kosong',
      ]);

      if ($validator->fails()) {
        return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 400);
      }

      $this->user->checkOTP($validator);

      return $this->successResponse([], 'OTP yang anda masukkan sudah sesuai');
    } catch (\Throwable $th) {
      return $this->errorResponse([], $th->getMessage(), $th->getCode() ?? 500);
    }
  }
}
