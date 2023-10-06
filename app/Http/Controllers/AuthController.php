<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function showLogin()
    {
        return view('subscribers.login');
    }

    public function login(Request $request)
    {

        $user = $this->authService->credentialsCheck($request);

        if($user){
            $checkActive = $this->authService->checkStatus($user);
            if(!$checkActive){
                return response()->json(['message' => 'Account Not Active'], 401);
            }
            if(!isset($user->first_login)){
                $this->authService->firstLogin($user);
            }
            return $this->authService->login($user);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);

    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

}
