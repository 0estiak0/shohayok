@auth

<form method="POST" action="{{ route('contact.store') }}">
    @csrf

    {{-- এখানে তোমার আগের Contact Form fields থাকবে --}}

</form>

@else

<div class="text-center py-4">
    <h4 class="fw-bold">Want to contact us?</h4>

    <p class="text-secondary">
        Please create an account or log in to send us a message.
    </p>

    <a href="{{ route('register') }}" class="btn btn-primary me-2">
        Create Account
    </a>

    <a href="{{ route('login') }}" class="btn btn-outline-primary">
        Login
    </a>
</div>

@endauth










@extends('layouts.app', ['title' => 'Contact Us — Shohayok'])

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold">Contact Us</h1>

        <p class="text-secondary">
            Have a question or need help? Send us a message.
        </p>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card-soft p-4 p-lg-5">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        Please check the form and try again.
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}">

                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Your Name</label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Subject</label>

                            <input
                                type="text"
                                name="subject"
                                value="{{ old('subject') }}"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="col-12">
                            <label class="form-label">Message</label>

                            <textarea
                                name="message"
                                rows="6"
                                class="form-control"
                                required
                            >{{ old('message') }}</textarea>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary px-4">
                                Send Message
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection