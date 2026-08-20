@extends('layouts.app', ['title' => $listing->title . ' — Shohayok'])
@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="listing-thumb" style="height:380px;font-size:8rem">{{ $listing->type === 'rental' ? '🏠' : '🔧' }}</div>
                <div class="d-flex gap-2 mt-3"><button class="share-btn" data-share="facebook"
                        data-title="{{ $listing->title }}">Facebook</button><button class="share-btn" data-share="whatsapp"
                        data-title="{{ $listing->title }}">WhatsApp</button><button class="share-btn" data-share="telegram"
                        data-title="{{ $listing->title }}">Telegram</button><button class="share-btn" data-share="email"
                        data-title="{{ $listing->title }}">Email</button></div>
                @if ($listing->latitude && $listing->longitude)
                    <div id="listing-map" class="map-canvas mt-4"></div>
                @endif
            </div>
            <div class="col-lg-5"><span class="badge bg-light text-primary">{{ ucfirst($listing->type) }}</span>
                <h1 class="fw-bold mt-2">{{ $listing->title }}</h1>
                <p class="text-secondary">{{ $listing->description }}</p>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="provider-avatar">👨‍🔧</div>
                    <div><b>{{ $listing->provider->name }}</b>
                        <div><span
                                class="badge badge-verified">{{ $listing->provider->is_verified ? '✓ Verified Provider' : 'Pending Verification' }}</span>
                        </div>
                    </div>
                </div>
                <h3 class="text-success">
                    @if($listing->discount_price)
                        <span class="text-decoration-line-through text-secondary fs-5">৳ {{ number_format($listing->price) }}</span>
                        ৳ {{ number_format($listing->discount_price) }} / {{ $listing->price_unit }}
                    @else
                        {{ $listing->price ? '৳ ' . number_format($listing->price) . ' / ' . $listing->price_unit : 'Contact provider' }}
                    @endif
                </h3>
                @auth
                    @if(auth()->id() !== $listing->provider_id && !auth()->user()->isAdmin())
                        <a class="btn btn-outline-primary w-100 mb-3" href="{{ route('customer.messages.thread', $listing->provider) }}">Message Provider</a>
                    @endif
                @endauth
                <p>📍 {{ $listing->address }}, {{ $listing->city }}</p>@auth<div class="card-soft p-3 mt-4">
                        <h5>Book this {{ $listing->type }}</h5>
                        <form method="post" action="{{ route('booking.store', $listing) }}">@csrf<div class="mb-2">
                                <label>Address</label><input class="form-control" name="address"
                                    value="{{ auth()->user()->address }}" required></div>
                            <div class="mb-2"><label>Start</label><input class="form-control" type="datetime-local"
                                    name="start_at"></div>
                            <div class="mb-2"><label>Notes</label>
                                <textarea class="form-control" name="notes"></textarea>
                            </div><button class="btn btn-primary w-100">Book Instantly</button>
                        </form>
                </div>@else<div class="card-soft p-4 text-center mt-4">
                        <div class="fs-1">🔒</div>
                        <h5>Sign In Required</h5>
                        <p class="text-secondary">Login to view phone number and book instantly.</p><a
                            class="btn btn-primary w-100" href="{{ route('login') }}">Login</a>
                </div>@endauth
            </div>
        </div>
    </div>
    @php($mapsKey = App\Models\Setting::get('google_maps_api_key', config('services.google.maps_key')))
    @if ($mapsKey && $listing->latitude && $listing->longitude)
        <script>
            window.initListingMap = function() {
                const p = {
                    lat: {{ (float) $listing->latitude }},
                    lng: {{ (float) $listing->longitude }}
                };
                const el = document.getElementById('listing-map');
                if (!el || !window.google) return;
                const map = new google.maps.Map(el, {
                    center: p,
                    zoom: 15,
                    mapTypeControl: false
                });
                new google.maps.Marker({
                    position: p,
                    map,
                    title: @json($listing->title)
                });
            };
        </script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ urlencode($mapsKey) }}&libraries=places&callback=initListingMap"
            async defer></script>
    @endif
@endsection
