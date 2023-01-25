<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function me()
    {
        return response()->json(new ProfileResource(auth('api')->user()));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|string|email|max:255|exists:users',
                'password' => 'required|string|min:6',
            ]
        );

        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Credentials not match'], 401);
        }

        return response()->json(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ],
            200
        );
    }

    public function register(Request $request)
    {
        $array = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]
        );

        $array['password'] = Hash::make($request->password);

        try {

            $credentials = User::create($array);
            $token = auth('api')->login($credentials);

            return response()->json(
                [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60,
                ],
                200
            );
        } catch (\Throwable $throwable) {
            return response()->json($throwable);
        }
    }

    public function refresh()
    {
        return response()->json(auth('api')->refresh(), 200);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => __('Successfully logged out')], 200);
    }
}
