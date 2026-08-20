@extends('layouts.app', ['title' => 'Create Account — Shohayok'])
@section('content')
    <div class="auth-wrap py-5">
        <div class="form-card p-4 p-lg-5">
            <h2 class="fw-bold">Create your account</h2>
            <p class="text-secondary">Find trusted services and rentals near you.</p>
            <form method="post" action="{{ route('register.store') }}">@csrf<div class="row g-3">
                    <div class="col-md-6"><label>Name</label><input class="form-control" name="name" required></div>
                    <div class="col-md-6"><label>Email</label><input class="form-control" type="email" name="email"
                            required></div>
                    <div class="col-md-4"><label>Country Code</label><select class="form-select" name="country_code">
                            <option>+880</option>
                            <option>+91</option>
                            <option>+1</option>
                            <option>+44</option>
                        </select></div>
                    <div class="col-md-8"><label>Phone Number</label><input class="form-control" name="phone" required>
                    </div>
                    <div class="col-12"><label>Address / House No. <small
                                class="text-secondary">(optional)</small></label><input class="form-control" name="address">
                    </div>
                    <div class="col-md-4"><label>City/Town</label><input class="form-control" name="city" required></div>
                    <div class="col-md-4"><label>Country</label><input class="form-control" name="country"
                            value="Bangladesh" required></div>
                    <div class="col-md-4"><label>ZIP/Postcode</label><input class="form-control" name="zip_code" required>
                    </div>
                    <div class="col-md-6">
                        <label>Password</label>
                        <div class="position-relative">
                            <input class="form-control pe-5" type="password" id="password" name="password" required>

                            <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y border-0"
                                onclick="togglePassword('password', this)">
                                👁
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <div class="position-relative">
                            <input class="form-control pe-5" type="password" id="password_confirmation"
                                name="password_confirmation" required>

                            <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y border-0"
                                onclick="togglePassword('password_confirmation', this)">
                                👁
                            </button>
                        </div>
                    </div>
                </div><button class="btn btn-primary w-100 mt-4">Create Account</button></form>
            <p class="text-center mt-3">Already have an account? <a href="{{ route('login') }}">Login</a></p>
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