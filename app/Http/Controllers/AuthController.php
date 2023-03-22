<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors([
            'messages' => 'Username dan password yang anda masukkan tidak ada',
        ]);
    }
}
