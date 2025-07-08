<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class PostService
{
    public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        try {
            $photoPath = $request->file('photo')
                ? $request->file('photo')->store('assets/post_photos', 'public')
                : null;

            Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'photo' => $photoPath,
                'user_id' => auth()->id(),
            ]);
        } catch (Exception $e) {
            throw new Exception("Post creation failed: " . $e->getMessage());
        }
    }

    public function editPost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        try {
            if ($request->hasFile('photo')) {
                if ($post->photo) {
                    Storage::disk('public')->delete($post->photo);
                }
                $validated['photo'] = $request->file('photo')->store('posts', 'public');
            }

            $post->update($validated);
        } catch (Exception $e) {
            throw new Exception("Post update failed: " . $e->getMessage());
        }
    }

    public function showPost()
    {
        return [
            'posts' => Post::with(['user', 'reactions', 'comments'])->latest()->paginate(5),
        ];
    }

    public function showDetailedPost(Post $post)
    {
        try {
            $post->load(['user', 'reactions']);
            $comments = $post->comments()->with('user')->latest()->paginate(5);

            $likeCount = $post->reactions->where('react', true)->count();
            $dislikeCount = $post->reactions->where('react', false)->count();
            $commentCount = $post->comments()->count();

            return compact('post', 'likeCount', 'dislikeCount', 'commentCount', 'comments');
        } catch (Exception $e) {
            throw new Exception("Failed to load post details: " . $e->getMessage());
        }
    }

    public function deletePost(Post $post)
    {
        try {
            $post->delete();
        } catch (Exception $e) {
            throw new Exception("Post deletion failed: " . $e->getMessage());
        }
    }

    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        try {
            Comment::create([
                'comment' => $request->comment,
                'user_id' => auth()->id(),
                'post_id' => $postId,
            ]);
        } catch (Exception $e) {
            throw new Exception("Comment creation failed: " . $e->getMessage());
        }
    }

    public function editComment(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        try {
            $comment->update($validated);
        } catch (Exception $e) {
            throw new Exception("Comment update failed: " . $e->getMessage());
        }
    }

    public function deleteComment(Comment $comment)
    {
        try {
            $comment->delete();
        } catch (Exception $e) {
            throw new Exception("Comment deletion failed: " . $e->getMessage());
        }
    }
}
