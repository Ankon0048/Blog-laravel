<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\Comment;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Log;

class UserController extends Controller
{
    protected $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }

    public function userHistory(Request $request)
    {
        try {
            $data = $this->userservice->showHistory($request);
            return view('user.userHistory', [
                'user_posts' => $data['user_posts'],
                'liked_posts' => $data['liked_posts'],
                'disliked_posts' => $data['disliked_posts'],
                'comments' => $data['comments'],
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to show user history');
        }

    }


    public function showEdit()
    {
        try {
            $user = auth()->user();
            return view('user.userEdit', compact('user'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to show profile');
        }

    }

    public function edit(Request $request)
    {
        try {
            $this->userservice->editUser($request);
            return redirect()->route('postShow')->with('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to edit profile');
        }

    }
}
