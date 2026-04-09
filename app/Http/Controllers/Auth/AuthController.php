<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

public function register(RegisterRequest $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Register berhasil',
        'data' => $user
    ], 201);
}
    public function login(LoginRequest $request)
    {
        $token = $request->authenticate();

        return response()->json([
            'message' => 'Login berhasil',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200)->cookie(
    'token',
    $token,
    60,
    '/',
    '127.0.0.1',
    false,
    true,
    false,
    'Lax'
);
    }


public function me()
{
    $user = auth('api')->user();

    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => Carbon::parse($user->created_at)
                ->timezone('Asia/Jakarta')
                ->format('d-m-Y H:i'),
        ]
    ]);
}


 public function logout()
{
    try {
        auth('api')->logout();

        return response()->json([
            'message' => 'Logout berhasil'
        ])->cookie(
            'token',
            '',
            -1,
            '/',
            '127.0.0.1'
        );

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Logout gagal'
        ], 500);
    }
}
}
