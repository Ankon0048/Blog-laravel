<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authservice;

    public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
    }
    public function showRegister()
    {
        return view('auth.userRegister');
    }

    public function register(Request $request)
    {
        $this->authservice->registerUser($request);
        return redirect()->route('postShow');
    }

    public function showLogin()
    {
        return view('auth.userLogin');
    }

    public function login(Request $request)
    {

        if ($this->authservice->loginUser($request)) {
            return redirect()->route('postShow');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
