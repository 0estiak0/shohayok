@extends('layouts.app', ['title' => $user->name . ' — Account Details'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('admin.partials.sidebar')<main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold">{{ $user->name }}</h2>
                        <p class="text-secondary mb-0">{{ ucfirst($user->role) }} account details</p>
                    </div><a class="btn btn-outline-primary" href="{{ route('admin.users') }}">← All Accounts</a>
                </div>
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card-soft p-4">
                            <div class="d-flex gap-3 align-items-center mb-4">
                                <div class="provider-avatar">@if($user->avatar)<img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">@else{{ $user->isProvider() ? '👨‍🔧' : '👤' }}@endif</div>
                                <div>
                                    <h4>{{ $user->name }}</h4><span
                                        class="badge {{ $user->isProvider() ? 'bg-success' : 'bg-primary' }}">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>
                            @foreach ([['Email', $user->email], ['Phone', $user->country_code . ' ' . $user->phone], ['Address', $user->address], ['City', $user->city], ['Country', $user->country], ['ZIP code', $user->zip_code], ['Joined', $user->created_at->format('d M Y, h:i A')]] as [$label, $value])
                                <div class="border-bottom py-2"><b>{{ $label }}</b>
                                    <div class="text-secondary">{{ $value ?: 'Not provided' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="card-soft p-3"><small>Listings</small>
                                    <h3>{{ $user->listings_count }}</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-soft p-3">
                                    <small>{{ $user->isProvider() ? 'Received Bookings' : 'Bookings' }}</small>
                                    <h3>{{ $user->isProvider() ? $user->provider_bookings_count : $user->bookings_count }}</h3>
                                </div>
                            </div>
                            @if ($user->isProvider())
                                <div class="col-6">
                                    <div class="card-soft p-3"><small>Reviews</small>
                                        <h3>{{ $user->reviews_count }}</h3>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card-soft p-3"><small>Verification</small>
                                        <h5>{{ $user->is_verified ? 'Verified' : 'Pending' }}</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-soft p-4">
                            <h5>Listings</h5>
                            @forelse($user->listings as $listing)
                                <div class="d-flex justify-content-between border-bottom py-3">
                                    <div><a href="{{ route('listing.show', $listing) }}"><b>{{ $listing->title }}</b></a>
                                        <div class="small text-secondary">{{ ucfirst($listing->type) }} ·
                                            {{ $listing->category->name }}</div>
                                    </div><span>৳{{ number_format($listing->discount_price ?: $listing->price) }}</span>
                            </div>@empty<p class="text-secondary">No listings.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
