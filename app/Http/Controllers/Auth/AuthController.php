<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Otp;
use App\Models\User;
use App\Notifications\VerificationCodeNotification;
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

        try {
            $credentials = User::create($array);
            $otp = Otp::create(
                [
                    'email' => $request->email,
                    'key' => rand(1000, 9999),
                    'time' => time()
                ]
            );

            $credentials->notify(new VerificationCodeNotification($otp->key));
            return response()->json('Send verification code send to your mail.', 200);
        } catch (\Throwable $throwable) {
            dd($throwable);
            return response()->json($throwable);
        }
    }

    public function verify(Request $request)
    {
        $array = $request->validate(
            [
                'key' => 'required|string|max:4',
                'email' => 'required|string|email|max:255|exists:users',
            ]
        );

        $check = Otp::where($array)->exists();
        if ($check) {
            User::where(['email' => $request->email])->update(['email_verified_at' => Carbon::today()->format('Y-m-d h:m:s')]);
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
