@extends('layouts.app', ['title' => 'Login — Shohayok'])
@section('content')
    <div class="auth-wrap py-5">
        <div class="form-card p-4 p-lg-5">
            <h2 class="fw-bold">Welcome back 👋</h2>
            <p class="text-secondary">Login to view phone number and book instantly.</p>
            <form method="post" action="{{ route('login.store') }}">@csrf<div class="mb-3"><label>Email</label><input
                        class="form-control" name="email" type="email" value="{{ old('email') }}" required></div>
                <div class="mb-3">
                    <label>Password</label>
                    <div class="position-relative">
                        <input class="form-control pe-5" type="password" id="password" name="password" required>

                        <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y border-0"
                            onclick="togglePassword('password', this)">
                            👁
                        </button>
                    </div>
                </div>

                
                <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember"
                        id="remember"><label for="remember">Remember me</label></div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center mt-3">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
        </div>
    </div>
@endsection
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = '🙈';
        } else {
            input.type = 'password';
            button.textContent = '👁';
        }
    }
</script>