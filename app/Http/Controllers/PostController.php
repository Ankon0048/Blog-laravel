<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Exception;

class PostController extends Controller
{
    protected $postservice;

    public function __construct(PostService $postService)
    {
        $this->postservice = $postService;
    }
    public function postShow()
    {
        try {
            $posts = $this->postservice->showPost();
            return view('post.postShow', $posts);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'failed to show post');
        }

    }

    public function postDetail(Post $post)
    {
        try {
            $data = $this->postservice->showDetailedPost($post);
            return view('post.postDetail', $data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'failed to show post details');
        }
    }

    public function addComment(Request $request, $postId)
    {
        try {
            $this->postservice->addComment($request, $postId);
            return redirect()->route('postDetail', $postId)->with('success', 'Comment added successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'failed to add comment');
        }

    }

    public function create()
    {
        return view('post.postCreate');
    }

    public function store(Request $request)
    {
        try {
            $this->postservice->createPost($request);
            return redirect()->route('postCreate')->with('success', 'Post created successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to create post');
        }

    }

    public function showEdit(Post $post)
    {
        return view('post.postCreate', compact('post'));
    }

    public function postEdit(Request $request, Post $post)
    {
        try {
            $this->postservice->editPost($request, $post);
            return redirect()->route('userHistory')->with('success', 'Post updated successfully!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to edit post');
        }

    }

    public function postDelete(Post $post)
    {
        try {
            $this->postservice->deletePost($post);
            return redirect()->route('userHistory')->with('success', 'Post deleted successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to delete post');
        }

    }

    public function showCommentEdit(Comment $comment)
    {
        try {
            $post = $comment->post()->first();
            $data = $this->postservice->showDetailedPost($post);
            $data['comment'] = $comment;
            return view('post.postDetail', $data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to show comment');
        }

    }

    public function commentEdit(Request $request, Comment $comment)
    {
        try {
            $this->postservice->editComment($request, $comment);
            return redirect()->route('postDetail', $comment->post_id)
                ->with('success', 'Comment updated successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to edit comment');
        }

    }

    public function commentDelete(Comment $comment)
    {
        try {
            $this->postservice->deleteComment($comment);
            return back()->with('success', 'Comment deleted successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Failed to delete comment');
        }

    }
}
