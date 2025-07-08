@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Login</h3>
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Login <i class="bi bi-box-arrow-in-left"></i></button>
            </div>
            <a href="#" class="btn btn-link">Forgot Password?</a>
        </form>
    </div>
@endsection
