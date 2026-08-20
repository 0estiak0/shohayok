@extends('layouts.app', ['title' => 'Provider Dashboard — Shohayok'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('provider.partials.sidebar')
            <main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold">Dashboard</h2>
                        <p class="text-secondary">Welcome back, {{ $u->name }} 👋</p>
                    </div>
                    <div class="d-flex gap-2"><a class="btn btn-outline-primary"
                            href="{{ route('provider.notifications') }}">🔔 {{ $u->unreadNotifications()->count() }}</a><a
                            class="btn btn-primary" href="{{ route('provider.profile') }}">My Profile</a></div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="card-soft p-3 stat"><small>Total Completed Jobs</small>
                            <h2>{{ $completed }}</h2><a href="{{ route('provider.works') }}">View works →</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card-soft p-3 stat"><small>Pending Requests</small>
                            <h2>{{ $pending }}</h2><a href="{{ route('provider.bookings') }}">View requests →</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card-soft p-3 stat"><small>Average Rating</small>
                            <h2>{{ number_format($rating, 1) }}</h2><a href="{{ route('provider.reviews') }}">View reviews
                                →</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card-soft p-3 stat"><small>This Month Income</small>
                            <h2>৳ {{ number_format($income) }}</h2><span class="text-success">Live</span>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-7">
                        <div class="card-soft p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Recent Works</h5><a class="btn btn-sm btn-primary"
                                    href="{{ route('provider.work.create') }}">+ Add New Work</a>
                            </div>
                            @forelse($works->take(3) as $work)
                                <div class="d-flex justify-content-between border-bottom py-3">
                                    <div><b>{{ $work->title }}</b>
                                        <div class="small text-secondary">{{ $work->customer_name }} ·
                                            {{ $work->location }}</div>
                                    </div><span class="text-warning">★ {{ $work->rating }}</span>
                            </div>@empty<p class="text-secondary mt-3 mb-0">No works yet.</p>
                            @endforelse
                            <div class="mt-3">
                                <a href="{{ route('provider.works') }}">View all recent works →</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card-soft p-4">
                            <div class="d-flex justify-content-between">
                                <h5>My Services</h5><a href="{{ route('provider.services') }}">Manage</a>
                            </div>
                            @forelse($listings->take(6) as $listing)
                                <div class="d-flex justify-content-between py-3 border-bottom">
                                    <div><b>{{ $listing->title }}</b>
                                        <div class="small text-secondary">{{ $listing->category->name }}</div>
                                    </div><span
                                        class="badge bg-success-subtle text-success">{{ ucfirst($listing->status) }}</span>
                            </div>@empty<p class="text-secondary mt-3 mb-0">No services yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
