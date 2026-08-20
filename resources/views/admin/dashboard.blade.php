@extends('layouts.app', ['title' => 'Admin Dashboard — Shohayok'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('admin.partials.sidebar')<main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold">Dashboard</h2>
                        <p class="text-secondary">Welcome back, Admin 👋</p>
                    </div>
                    <div class="input-group" style="max-width:360px"><input class="form-control"
                            placeholder="Search anything..."><button class="btn btn-light border">⌕</button></div>
                </div>
                <div class="row g-3 mb-4">
                    @foreach ([['Total Users', $stats['users'], '👤'], ['Total Providers', $stats['providers'], '👥'], ['Pending Requests', $stats['pending'], '◷'], ['Total Services', $stats['services'], '🛠️'], ['Total Rentals', $stats['rentals'], '🚗']] as $stat)
                        <div class="col-md-6 col-xl">
                            <div class="card-soft p-3 stat"><small>{{ $stat[0] }}</small>
                                <h2>{{ number_format($stat[1]) }}</h2><span class="text-success">↗ Live</span><span
                                    class="float-end fs-3">{{ $stat[2] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row g-4">
                    <div class="col-xl-5">
                        <div class="card-soft p-4">
                            <h5>Pending Service Provider Requests</h5>
                            @forelse($pending as $provider)
                                <div class="d-flex align-items-center gap-2 border-bottom py-3">
                                    <div class="provider-avatar" style="width:48px;height:48px;font-size:1.4rem">👨‍🔧</div>
                                    <div class="flex-grow-1"><b>{{ $provider->name }}</b>
                                        <div class="small text-secondary">{{ $provider->city }} · {{ $provider->phone }}
                                        </div>
                                    </div>
                                    <form method="post" action="{{ route('admin.providers.approve', $provider) }}">@csrf
                                        @method('PATCH')<button class="btn btn-sm btn-outline-success">Approve</button>
                                    </form>
                                    <form method="post" action="{{ route('admin.providers.reject', $provider) }}">@csrf
                                        @method('PATCH')<button class="btn btn-sm btn-outline-danger">Reject</button>
                                    </form>
                            </div>@empty<p class="text-secondary mt-3 mb-0">No pending providers.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card-soft p-4">
                            <h5>Recent Service Listings</h5>
                            @foreach ($services as $listing)
                                <div class="py-2 border-bottom"><b>{{ $listing->title }}</b>
                                    <div class="small text-secondary">{{ $listing->provider->name }} ·
                                        {{ $listing->category->name }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card-soft p-4">
                            <h5>Recent Rental Listings</h5>
                            @foreach ($rentals as $listing)
                                <div class="py-2 border-bottom"><b>{{ $listing->title }}</b>
                                    <div class="small text-secondary">{{ $listing->city }} · ৳
                                        {{ number_format($listing->price) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card-soft p-4">
                            <h5>Category Overview</h5>
                            <div class="py-2">Services <span class="float-end">{{ $stats['services'] }}</span></div>
                            <div class="py-2">Rentals <span class="float-end">{{ $stats['rentals'] }}</span></div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card-soft p-4">
                            <h5>Analytics Overview</h5><canvas id="adminChart" height="180"></canvas>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card-soft p-4">
                            <h5>Recent Complaints</h5>
                            @forelse($complaints as $complaint)
                                <div class="border-bottom py-2"><b>#C-{{ $complaint->id }}</b>
                                    <div class="small">{{ $complaint->subject }}</div>
                            </div>@empty<p class="text-secondary">No complaints.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    new Chart(document.getElementById('adminChart'), {
                        type: 'line',
                        data: {
                            labels: ['1', '5', '10', '15', '20', '25', '30'],
                            datasets: [{
                                label: 'Bookings',
                                data: [30, 45, 38, 62, 56, 80, 94],
                                tension: .35
                            }, {
                                label: 'Views',
                                data: [80, 95, 110, 120, 140, 155, 190],
                                tension: .35
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                </script>
            </main>
        </div>
    </div>
@endsection
