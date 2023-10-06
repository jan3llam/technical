<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    public function login($user)
    {

        $storedDeviceId = $user->device_id;
        $userAgent = request()->header('User-Agent');
        $loginDeviceId = md5($userAgent);

        if ($storedDeviceId === $loginDeviceId) {
            $token = $user->tokens()->where('name', 'Token')->first()->token;
            return response()->json(['message' => 'Login successful', 'token' => $token], 200);
        } else {
            Auth::logout();
            return response()->json(['message' => 'Login from a different device is not allowed'], 401);
        }

    }

    public function firstLogin($user)
    {
        $user->first_login = now();
        $userAgent = request()->header('User-Agent');
        $device_id = md5($userAgent);
        $user->device_id = $device_id;
        $user->save();
    }

    public function credentialsCheck($request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return Auth::user();
        } else {
            return false;
        }
    }

    public function verifyAccessToken(){
        $user = Auth::user();

        $token = $user->tokens()->where('name', 'Token')->first()->token;
        $requestToken = str_replace('Bearer ', '', request()->header('Authorization'));

        if ($token !== $requestToken) {
            return false;
        }

        return true;
    }

    public function checkStatus($user)
    {
        if ($user->status == Subscriber::STATUS_INACTIVE) {
            return false;
        }
        return true;
    }
}
