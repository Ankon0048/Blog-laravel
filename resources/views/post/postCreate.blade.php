@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>{{ isset($post) ? 'Edit Post' : 'Create a Post' }}</h3>

        <form action="{{ isset($post) ? route('post_update', $post->id) : route('postStore') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($post))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}"
                    required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $post->description ?? '') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Image (Optional)</label>
                <input type="file" name="photo" class="form-control">
                @if (isset($post) && $post->photo)
                    <img src="{{ asset('storage/' . $post->photo) }}" class="img-thumbnail mt-2" width="150">
                @endif
                @error('photo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    {{ isset($post) ? 'Update Post' : 'Create Post' }}
                </button>
            </div>
        </form>
    </div>
@endsection
