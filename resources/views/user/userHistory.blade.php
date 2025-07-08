@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Left Sidebar Navigation -->
            <div class="col-md-2">
                <div class="d-flex flex-column position-sticky sticky-top top-0">
                    <button class="btn btn-outline-primary mb-2 tab-btn active" data-tab="posts">Posts</button>
                    <button class="btn btn-outline-success mb-2 tab-btn" data-tab="likes">Likes</button>
                    <button class="btn btn-outline-danger mb-2 tab-btn" data-tab="dislikes">Dislikes</button>
                    <button class="btn btn-outline-info mb-2 tab-btn" data-tab="comments">Comments</button>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="col-md-9">
                <!-- Posts Tab -->
                <div class="tab-content" id="tab-posts">
                    @if ($user_posts && $user_posts->count())
                        @foreach ($user_posts as $post)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <img src="{{ $post->user->photo ? asset('storage/' . $post->user->photo) : asset('storage/' . 'assets/user_photos/default.jpg') }}"
                                                alt="User Photo" class="rounded-circle me-2" width="40" height="40"
                                                style="object-fit: cover;">
                                            <strong>{{ $post->user->name }}</strong>
                                        </div>
                                        <!-- Edit & Delete Buttons -->
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('post_edit', $post->id) }}" class="btn btn-sm btn-success"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('post_delete', $post->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                    </div>

                                    <p class="card-text">{{ Str::words($post->description, 20, '...') }}</p>

                                    @if ($post->photo)
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ asset('storage/' . $post->photo) }}" alt="Post Image"
                                                class="img-fluid rounded mb-2 center" width="100%" height="100%">
                                        </div>
                                    @endif

                                    <!-- Reactions + See More -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-success btn-sm me-2">
                                                <i class="bi bi-arrow-up"></i>
                                                {{ $post->reactions->where('react', true)->count() }}
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm me-3">
                                                <i class="bi bi-arrow-down"></i>
                                                {{ $post->reactions->where('react', false)->count() }}
                                            </button>
                                            <span class="text-muted">
                                                <i class="bi bi-chat-left"></i> {{ $post->comments->count() }} Comments
                                            </span>
                                        </div>
                                        <a href="{{ route('postDetail', $post->id) }}" class="btn btn-primary btn-sm">See
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No posts found.</p>
                    @endif
                </div>

                <!-- Likes Tab -->
                <div class="tab-content" id="tab-likes" style="display: none;">
                    @if ($liked_posts && $liked_posts->count())
                        <x-card :posts="$liked_posts" />
                    @else
                        <p class="text-muted">No liked posts found.</p>
                    @endif
                </div>

                <!-- Dislikes Tab -->
                <div class="tab-content" id="tab-dislikes" style="display: none;">
                    @if ($disliked_posts && $disliked_posts->count())
                        <x-card :posts="$disliked_posts" />
                    @else
                        <p class="text-muted">No disliked posts found.</p>
                    @endif
                </div>

                <!-- Comments Tab -->
                <div class="tab-content" id="tab-comments" style="display: none;">
                    @if ($comments && $comments->count())
                        <h5>Your Comments</h5>
                        @foreach ($comments as $comment)
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-start mb-3">
                                    <img src="{{ $comment->user->photo ? asset('storage/' . $comment->user->photo) : asset('storage/' . 'assets/user_photos/default.jpg') }}"
                                        class="rounded-circle me-2" width="35" height="35" style="object-fit: cover;"
                                        alt="User Photo">
                                    <div>
                                        <strong>{{ $comment->post->title ?? 'Post' }}</strong>
                                        <p class="mb-1">Comment: {{ $comment->comment }}</p>
                                        <a href="{{ route('postDetail', $comment->post_id) }}"
                                            class="btn btn-sm btn-primary">View Post</a>
                                    </div>
                                </div>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No comments found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                const tab = button.getAttribute('data-tab');

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(tc => tc.style.display = 'none');

                // Remove active class from all buttons
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

                // Show selected tab and activate button
                document.getElementById('tab-' + tab).style.display = 'block';
                button.classList.add('active');
            });
        });
    </script>
@endsection
