<div class="container">
    @foreach ($posts as $post)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <!-- User Info -->
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ $post->user->photo ? asset('storage/' . $post->user->photo) : asset('storage/' . 'assets/user_photos/default.jpg') }}"
                            alt="User Photo" class="rounded-circle me-2" width="30" height="30"
                            style="object-fit: cover;">
                        <strong>{{ $post->user->name }}</strong>
                    </div>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>

                <!-- Title -->
                <h1 class="card-title">{{ $post->title }}</h1>

                <!-- Conditional Description -->
                @if (!$post->photo)
                    <p class="card-text">
                        {{ \Illuminate\Support\Str::words($post->description, 50, '...') }}
                    </p>
                @endif

                <!-- Post Image -->
                @if ($post->photo)
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('storage/' . $post->photo) }}" alt="Post Image"
                            class="img-fluid rounded mb-2 center" width="100%" height="100%">
                    </div>
                @endif

                <!-- Reactions + See More (Flex layout) -->
                <div class="d-flex justify-content-between align-items-center mt-3">

                    <!-- Reaction Section -->
                    <div class="d-flex align-items-center">
                        <!-- Like Button -->
                        <button class="btn btn-outline-success btn-sm me-2">
                            <i class="bi bi-arrow-up"></i>
                            {{ $post->reactions->where('react', true)->count() }}
                        </button>

                        <!-- Dislike Button -->
                        <button class="btn btn-outline-danger btn-sm me-3">
                            <i class="bi bi-arrow-down"></i>
                            {{ $post->reactions->where('react', false)->count() }}
                        </button>

                        <!-- Comment Count -->
                        <span class="text-muted">
                            <i class="bi bi-chat-left"></i> {{ $post->comments->count() }} Comments
                        </span>
                    </div>

                    <!-- See More -->
                    <a href="{{ route('postDetail', $post->id) }}" class="btn btn-primary btn-sm">See More</a>
                </div>

            </div>
        </div>
    @endforeach
</div>
