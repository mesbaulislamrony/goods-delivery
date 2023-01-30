<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Notifications\SendVerificationCode;
use Carbon\Carbon;
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
        $array['code'] = rand(1000, 9999);

        try {
            $credentials = User::create($array);
            $credentials->notify(new SendVerificationCode($array['code']));
            return response()->json('Send verification code send to your mail.', 200);
        } catch (\Throwable $throwable) {
            return response()->json($throwable);
        }
    }

    public function verify(Request $request)
    {
        $credentials = $request->validate(
            [
                'code' => 'required|string|max:4',
                'email' => 'required|string|email|max:255|exists:users',
            ]
        );

        $check = User::where($credentials)->exists();
        if ($check) {
            User::where($credentials)->update(['email_verified_at' => Carbon::today()->format('Y-m-d h:m:s')]);
            return response()->json(['error' => 'You have successfully verified your email address.'], 200);
        }
        return response()->json(['error' => 'Verification code is invalid.'], 401);
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
