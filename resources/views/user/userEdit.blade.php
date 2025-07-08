@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Edit Profile</h3>

        <form action="{{ route('edit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Photo (Optional)</label>
                <input type="file" name="photo" class="form-control">
                @error('photo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- <h5>Change Password (Optional)</h5>

            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input type="password" name="old_password" class="form-control">
                @error('old_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control">
                @error('new_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="form-control">
            </div> --}}

            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="{{ route('postShow') }}" class="btn btn-link">Home</a>
        </form>
    </div>
@endsection
