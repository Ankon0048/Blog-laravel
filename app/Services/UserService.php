<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Exception;

class UserService
{
    public function showHistory(Request $request)
    {
        try {
            $user = auth()->user();
            $data = [];

            $data['user_posts'] = $user->posts()->with('user')->latest()->get();

            $likedPostIds = Reaction::where('user_id', $user->id)
                ->where('react', true)
                ->pluck('post_id');

            $data['liked_posts'] = Post::whereIn('id', $likedPostIds)
                ->with('user')
                ->latest()
                ->get();

            $dislikedPostIds = Reaction::where('user_id', $user->id)
                ->where('react', false)
                ->pluck('post_id');

            $data['disliked_posts'] = Post::whereIn('id', $dislikedPostIds)
                ->with('user')
                ->latest()
                ->get();

            $data['comments'] = Comment::with(['user', 'post'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            return $data;
        } catch (Exception $e) {
            throw new Exception("Failed to load user history: " . $e->getMessage());
        }
    }

    public function editUser(Request $request)
    {
        try {
            $user = auth()->user();

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'photo' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }

                $photoPath = $request->file('photo')->store('user_photos', 'public');
                $user->photo = $photoPath;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        } catch (Exception $e) {
            throw new Exception("Failed to update user profile: " . $e->getMessage());
        }
    }
}
