<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = $request->file('photo') ? $request->file('photo')->store('assets/user_photos', 'public') : null;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $photoPath,
            'password' => Hash::make($request->password),
        ]);



        Auth::login($user);
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return true;
        } else {
            return false;
        }
    }



}