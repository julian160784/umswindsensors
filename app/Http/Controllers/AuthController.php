<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $auth = Auth::attempt($request->only(['email', 'password']));

        if (!$auth) {
            return response(['message' => 'Username atau password salah'], 403);
        }

        $token = Str::random(80);

        auth()->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return [
            'user' => auth()->user(),
            'token' => $token
        ];
    }
}
