@extends('layouts.app', ['title' => 'Shohayok — Trusted Services & Rentals'])
@section('content')
    <div class="container-fluid px-lg-5 pt-4">
        <div id="hero" class="carousel slide hero" data-bs-ride="carousel">
            <div class="carousel-inner">
                @forelse($banners as $i=>$b)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                        <div class="row g-0 align-items-stretch">
                            <div class="col-lg-6 hero-copy">
                                <div class="text-primary fw-semibold mb-2">বিশ্বাসযোগ্য সেবা</div>
                                <h1>{{ $b->title }} <span>{{ $b->subtitle }}</span></h1>
                                <p class="text-secondary">প্রশিক্ষিত প্রোভাইডার, যাচাইকৃত লিস্টিং এবং আপনার কাছাকাছি সমাধান।
                                </p><a class="btn btn-primary px-4"
                                    href="{{ $b->button_url ?: route('explore') }}">{{ $b->button_text ?: 'সেবা খুঁজুন' }}</a>
                            </div>
                            <div class="col-lg-6 hero-art"></div>
                        </div>
                </div>@empty<div class="carousel-item active">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6 hero-copy">
                                <h1>বিশ্বাসযোগ্য সেবা <span>আপনার হাতের মুঠোয়</span></h1>
                                <p class="text-secondary">সার্ভিস ও রেন্টাল—সবকিছু কাছাকাছি খুঁজুন।</p><a
                                    class="btn btn-primary" href="{{ route('explore') }}">সেবা খুঁজুন</a>
                            </div>
                            <div class="col-lg-6 hero-art"></div>
                        </div>
                    </div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#hero" data-bs-slide="prev"><span
                    class="carousel-control-prev-icon"></span></button><button class="carousel-control-next" type="button"
                data-bs-target="#hero" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
        </div>
        <div class="search-zone py-5">
    <div class="search-bubbles" aria-hidden="true">
    <i></i><i></i><i></i><i></i><i></i>
    <i></i><i></i><i></i><i></i><i></i>
    <i></i><i></i><i></i><i></i><i></i>
    <i></i><i></i><i></i><i></i><i></i>
    <i></i><i></i><i></i><i></i><i></i>
</div>

    <h2 class="text-center fw-bold">
        What do you
        <span class="text-primary">need</span>
        <span class="text-success">today?</span>
    </h2>

    <form class="search-box d-flex" action="{{ route('explore') }}" method="GET">
        <span class="search-icon">🔍</span>

        <input
            id="homeSearch"
            name="q"
            class="form-control"
            placeholder="I need..."
            autocomplete="off"
        >

        <button type="submit" class="btn btn-primary rounded-circle">
            ➜
        </button>
    </form>

    <div class="d-flex justify-content-center gap-2 flex-wrap mt-3">
        <button type="button" class="bubble quick-search">Plumber</button>
        <button type="button" class="bubble quick-search">Electrician</button>
        <button type="button" class="bubble quick-search">Carpenter</button>
        <button type="button" class="bubble quick-search">Maid</button>
        <button type="button" class="bubble quick-search">AC repair</button>
        <button type="button" class="bubble quick-search">Car rent</button>
        <button type="button" class="bubble quick-search">Bike rent</button>
    </div>
</div>
      <section class="card-soft nearby-section p-3 p-lg-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="section-title fw-bold mb-1">Nearby</h3>

            <p class="text-secondary mb-0">
                Find trusted service providers and rental options near you
            </p>
        </div>

        <button
            type="button"
            id="detectHomeLocation"
            class="btn btn-outline-primary px-4"
            data-geolocate>
            📍 Detect my location
        </button>
    </div>

    <div class="row g-4">

        {{-- MAP --}}
        <div class="col-xl-6">

            <div
                id="homeNearbyMap"
                class="nearby-map d-flex align-items-center justify-content-center">

                <div id="mapPlaceholder" class="text-center px-3">

                    <div class="location-pin-icon">
                        📍
                    </div>

                    <h4 class="fw-bold mt-2">
                        Find services near you
                    </h4>

                    <p class="text-secondary mb-0">
                        Click Detect My Location to view the map
                    </p>

                </div>

            </div>

        </div>

        {{-- LISTINGS --}}
        <div class="col-xl-6">

            <div class="row g-3">

                @foreach ($services->take(3) as $l)

                    <div class="col-md-4">

                        <div class="nearby-listing-card h-100 position-relative">

                            <div class="listing-thumb">
                                🔧
                            </div>

                            <div class="p-3">

                                <b class="d-block">
                                    {{ $l->title }}
                                </b>

                                <small class="text-secondary">
                                    {{ $l->category->name }}
                                </small>

                                <div class="text-warning mt-1">
                                    ★ 4.8
                                </div>

                                <a
                                    href="{{ route('listing.show', $l) }}"
                                    class="btn btn-sm btn-outline-success w-100 mt-3 stretched-link">
                                    View
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="row g-3 mt-1">

                @foreach ($rentals->take(3) as $l)

                    <div class="col-md-4">

                        <div class="nearby-listing-card h-100 position-relative">

                            <div class="listing-thumb">
                                🏠
                            </div>

                            <div class="p-3">

                                <b class="d-block">
                                    {{ $l->title }}
                                </b>

                                <small class="text-secondary">
                                    {{ $l->category->name }}
                                </small>

                                <div class="text-success fw-bold mt-2">
                                    @if($l->discount_price)<span class="text-decoration-line-through text-secondary">৳ {{ number_format($l->price) }}</span> ৳ {{ number_format($l->discount_price) }}@else ৳ {{ number_format($l->price) }} @endif
                                    / {{ $l->price_unit }}
                                </div>

                                <a href="{{ route('listing.show', $l) }}"
                                    class="btn btn-sm btn-outline-success w-100 mt-3 stretched-link">
                                    View
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>
        <section class="py-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="section-title">Top Services</h4><a href="{{ route('explore', ['type' => 'service']) }}">View
                    All</a>
            </div>
            <div class="row g-3">
                @foreach ($categories as $c)
                    <div class="col-6 col-md-3 col-lg-1">
                        <a class="card-soft p-3 text-center h-100 d-block text-dark" href="{{ route('explore', ['category' => $c->id]) }}">
                            <div class="icon-tile mx-auto">{{ $c->icon ?: '🛠️' }}</div><small
                                class="fw-semibold d-block mt-2">{{ $c->name }}</small>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="pb-4">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="section-title">Top Rated Service Providers</h4><a href="{{ route('providers.index') }}">View All</a>
            </div>
            <div class="row g-3">
                @foreach ($providers as $p)
                    <div class="col-6 col-lg-2">
                        <div class="card-soft p-3 text-center h-100">
                            <a href="{{ route('providers.show',$p) }}"><div class="provider-avatar mx-auto">@if($p->avatar)<img src="{{ asset('storage/'.$p->avatar) }}" alt="{{ $p->name }}">@else 👨‍🔧 @endif</div><b
                                class="d-block mt-2">{{ $p->name }}</b></a><small class="text-secondary">Service
                                Provider</small>
                            <div class="text-warning mt-1">★★★★★</div><small
                                class="text-secondary">{{ $p->reviews_count }} reviews</small>@if($p->phone)<a
                                class="btn btn-sm btn-success w-100 mt-2" href="tel:{{ $p->country_code.$p->phone }}">Call</a>@else<a class="btn btn-sm btn-outline-primary w-100 mt-2" href="{{ route('providers.show',$p) }}">View Profile</a>@endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="pb-5">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="section-title">Recent Works</h4><a href="{{ route('works.index') }}">View All</a>
            </div>
            <div class="row g-3">
                @foreach ($works as $w)
                    <div class="col-lg-4">
                        <div class="card-soft p-3">
                            <div class="d-flex justify-content-between"><a href="{{ route('providers.show',$w->provider) }}"><b>{{ $w->provider->name }}</b></a><span
                                    class="text-warning">★ {{ $w->rating }}</span></div><small
                                class="text-secondary">{{ $w->location }}</small>
                            <div class="row g-2 mt-2">
                                <div class="col-8">
                                    <div class="listing-thumb">🛠️</div>
                                </div>
                                <div class="col-4">
                                    <div class="listing-thumb h-100">📷</div>
                                </div>
                            </div>
                            <p class="mb-2 mt-2">{{ $w->title }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                @auth
                                    @if(auth()->id() !== $w->provider_id && !auth()->user()->isAdmin())
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('customer.messages.thread',$w->provider) }}">Contact</a>
                                    @else
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('providers.show',$w->provider) }}">View</a>
                                    @endif
                                @else
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}">Contact</a>
                                @endauth
                                @auth<form method="post" action="{{ route('works.like',$w) }}">@csrf<button class="btn btn-sm btn-light border">♡ {{ $w->likes }}</button></form>@else<a class="btn btn-sm btn-light border" href="{{ route('login') }}">♡ {{ $w->likes }}</a>@endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>


    <script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('homeSearch');
    const quickButtons = document.querySelectorAll('.quick-search');

    quickButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            searchInput.value = this.textContent.trim();
            searchInput.focus();
        });
    });
});
</script>

@php
    $mapsKey = App\Models\Setting::get(
        'google_maps_api_key',
        config('services.google.maps_key')
    );
@endphp

@if($mapsKey)
<script>
    let homeMap = null;

    function loadGoogleMapsScript() {
        if (window.google && window.google.maps) {
            return Promise.resolve();
        }

        return new Promise(function(resolve, reject) {
            const existing = document.getElementById('googleMapsHomeScript');

            if (existing) {
                existing.addEventListener('load', resolve);
                return;
            }

            const script = document.createElement('script');

            script.id = 'googleMapsHomeScript';
            script.src =
                'https://maps.googleapis.com/maps/api/js?key={{ urlencode($mapsKey) }}&libraries=places';

            script.async = true;
            script.defer = true;

            script.onload = resolve;
            script.onerror = reject;

            document.head.appendChild(script);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {

        const button = document.getElementById('detectHomeLocation');

        if (!button) {
            return;
        }

        button.addEventListener('click', function () {

            if (!navigator.geolocation) {
                alert('Location is not supported by your browser.');
                return;
            }

            button.disabled = true;
            button.innerHTML = '📍 Detecting...';

            navigator.geolocation.getCurrentPosition(

                async function(position) {

                    const userPosition = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    try {
                        await loadGoogleMapsScript();

                        const mapElement =
                            document.getElementById('homeNearbyMap');

                        mapElement.innerHTML = '';

                        homeMap = new google.maps.Map(mapElement, {
                            center: userPosition,
                            zoom: 14,
                            mapTypeControl: false,
                            streetViewControl: false
                        });

                        new google.maps.Marker({
                            position: userPosition,
                            map: homeMap,
                            title: 'Your location'
                        });

                        button.innerHTML = '✅ Location detected';

                    } catch (error) {
                        alert('Google Maps could not be loaded.');

                        button.disabled = false;
                        button.innerHTML = '📍 Detect my location';
                    }
                },

                function () {
                    alert('Please allow location access.');

                    button.disabled = false;
                    button.innerHTML = '📍 Detect my location';
                }

            );

        });

    });
</script>
@else
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('homeNearbyMap');

        if (el) {
            el.innerHTML =
                '<div class="p-5 text-center text-secondary">Google Maps API key is not configured.</div>';
        }
    });
</script>
@endif
@endsection
