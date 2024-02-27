<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "username" => "required|min:2|max:20",
            "password" => "required|min:2|max:20",
        ]);

        $user = User::where('username', trim($request->username))->first();

        if(!$user || !password_verify($request->password, $user->password)) {
            return response()->json(['message' => __('Неправильный логин или пароль')], 400);
        }

        $accessToken = $user->createToken('access', ['user', 'access']);
        $refreshToken = $user->createToken('refresh', ['user', 'refresh']);

        return response()->json([
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
            'user' => $user
        ]);
    }

    public function logout(Request $request) {
        if($request->user()->currentAccessToken()->delete()) {
            return response()->json(['message' => 'success',]);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function refreshToken(Request $request) {
        $user = $request->user();

        $request->user()->currentAccessToken()->delete();
        $accessToken = $user->createToken('access', ['user', 'access']);
        $refreshToken = $user->createToken('refresh', ['user', 'refresh']);

        return response()->json([
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ]);
    }
}
