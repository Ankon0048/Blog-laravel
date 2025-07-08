<h5>Comments</h5>

<div class="mt-4">
    @foreach ($comments as $comment)
        <div class="mb-3">
            <div class="d-flex align-items-start mb-1">
                <!-- User Image -->
                <img src="{{ $comment->user->photo ? asset('storage/' . $comment->user->photo) : asset('storage/assets/user_photos/default.jpg') }}"
                    alt="User Photo" class="rounded-circle me-2" width="35" height="35" style="object-fit: cover;">

                <!-- Comment Content -->
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Left Side: Timestamp -->
                        <strong class="me-2">{{ $comment->user->name }}</strong>

                        <!-- Right Side: Username & Edit/Delete -->
                        <div class="d-flex align-items-center gap-2">

                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            <a href="{{ route('comment_edit', $comment->id) }}"
                                class="btn btn-sm btn-outline-success p-1" title="Edit"><i
                                    class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('comment_delete', $comment->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger p-1" title="Delete"><i
                                        class="bi bi-trash-fill"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Comment Text -->
                    <div class="mt-1">
                        <p class="mb-0">{{ $comment->comment }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
