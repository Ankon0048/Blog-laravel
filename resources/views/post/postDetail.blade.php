@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <!-- Post Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ $post->title }}</h4>
            <small>{{ $post->created_at->format('d M Y') }} {{ $post->created_at->format('H:i') }}</small>
        </div>

        <!-- Post by User -->
        <p class="text-muted">By: {{ $post->user->name }}</p>

        <!-- Post Image -->
        @if ($post->photo)
            <div class="d-flex justify-content-center">
                <img src="{{ asset('storage/' . $post->photo) }}" alt="Post Image" class="img-fluid rounded mb-2 center"
                    width="100%" height="100%">
            </div>
        @endif

        <!-- Post Description -->
        <p>{{ $post->description }}</p>

        <!-- Reaction Section -->
        <div class="d-flex align-items-center mb-4">
            <!-- Like Button -->
            <button class="btn btn-outline-success btn-sm me-2">
                <i class="bi bi-arrow-up"></i>{{ $likeCount }}
            </button>

            <!-- Dislike Button -->
            <button class="btn btn-outline-danger btn-sm me-3">
                <i class="bi bi-arrow-down"></i>{{ $dislikeCount }}
            </button>

            <!-- Comment Count -->
            <span class="text-muted"><i class="bi bi-chat-left"></i> {{ $commentCount }} Comments</span>
        </div>

        <!-- Comment Form -->
        @auth
            <div class="d-flex align-items-start mb-4">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('storage/' . 'assets/user_photos/default.jpg') }}"
                    class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;" alt="User Photo">

                <form action="{{ isset($comment) ? route('comment_update', $comment->id) : route('addComment', $post->id) }}"
                    method="POST" class="flex-grow-1">
                    @csrf
                    @if (isset($comment))
                        @method('PUT')
                    @endif
                    <div class="mb-2">
                        <input type="text" name="comment" class="form-control" placeholder="Write a comment..."
                            value="{{ old('comment', $comment->comment ?? '') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Comment</button>
                </form>
            </div>
        @endauth

        <x-comment-list :comments="$comments" />
        {{ $comments->links() }}

    </div>
@endsection
