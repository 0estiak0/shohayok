@extends('layouts.app', ['title' => 'Explore Nearby — Shohayok'])
@section('content')
    <div class="container-fluid px-lg-5 py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="fw-bold">Explore Nearby Services & Rentals</h2>
                <p class="text-secondary">Filter services, rentals and categories around you.</p>

            </div>
            <form method="GET" action="{{ route('explore') }}" class="explore-main-search">


                <div class="main-search-box">
                    <span class="main-search-icon">🔍</span>

                    <input type="search" name="q" value="{{ request('q') }}"
                        placeholder="Search plumber, electrician, house rent, car rent..." autocomplete="off">

                    <button type="submit">
                        Search
                    </button>
                </div>
            </form>
            <div class="form-check form-switch location-switch">
                <input class="form-check-input location-toggle" type="checkbox" role="switch">

                <label class="form-check-label fw-semibold">
                    📍 Use My Location
                </label>
            </div>
        </div>
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="filter-card sticky-top" style="top: 90px;">

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">🔎 Find What You Need</h5>
                            <small class="text-secondary">Search nearby services & rentals</small>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('explore') }}">

                        <input type="hidden" name="lat">
                        <input type="hidden" name="lng">



                        {{-- Listing Type --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Type</label>

                            <div class="listing-type-switch">

                                <input type="radio" class="btn-check" name="type" id="serviceType" value="service"
                                    onchange="this.form.submit()" {{ request('type') === 'service' ? 'checked' : '' }}>

                                <label class="type-option" for="serviceType">
                                    🔧 Services
                                </label>

                                <input type="radio" class="btn-check" name="type" id="rentalType" value="rental"
                                    onchange="this.form.submit()" {{ request('type') === 'rental' ? 'checked' : '' }}>

                                <label class="type-option" for="rentalType">
                                    🏠 Rentals
                                </label>

                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Category</label>
                            <select class="form-select custom-select" name="category">
                                <option value="">All Categories</option>

                                @foreach ($categories as $c)
                                    @if (request('type') === 'service' && $c->type !== 'service')
                                        @continue
                                    @endif

                                    @if (request('type') === 'rental' && $c->type !== 'rental')
                                        @continue
                                    @endif

                                    <option value="{{ $c->id }}"
                                        {{ request('category') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Location --}}
                        <div class="location-status mb-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span>📍</span>

                                <div>
                                    <small class="text-secondary d-block">Your location</small>
                                    <span data-location-label>Location Off</span>
                                </div>
                            </div>

                            <div class="form-check form-switch m-0">
                                <input class="form-check-input location-toggle" type="checkbox" role="switch">
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 filter-button">
                            Search Nearby →
                        </button>

                        <a href="{{ route('explore') }}" class="btn btn-light w-100 mt-2 border">
                            Clear Filters
                        </a>

                    </form>

                </div>
            </aside>
            <main class="col-lg-9">
                <div id="nearby-map" class="map-box mb-4" style="min-height:420px">
                    <div class="position-absolute top-0 start-0 p-3 z-2"><span
                            class="badge bg-white text-dark shadow">Google Maps + Nearby</span></div>
                </div>
                <div class="row g-3">
                    @forelse($listings as $l)
                        <div class="col-md-6 col-xl-4">
                            <div class="card-soft p-3 h-100 position-relative">
                                @if ($l->is_featured)
                                    <span
                                        class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">Featured</span>
                                @elseif($l->is_sponsored)
                                    <span class="badge bg-primary position-absolute top-0 end-0 m-3">Sponsored</span>
                                @endif
                                <div class="listing-thumb">
                                    {{ $l->type === 'rental' ? '🏠' : '🔧' }}</div><small
                                    class="text-secondary">{{ ucfirst($l->type) }} · {{ $l->category->name }}</small>
                                <h5 class="mt-1">{{ $l->title }}</h5>
                                <p class="small text-secondary">{{ Str::limit($l->description, 90) }}</p>
                                <div class="d-flex justify-content-between align-items-center"><b
                                        class="text-success">@if($l->discount_price)<span class="text-decoration-line-through text-secondary">৳ {{ number_format($l->price) }}</span> ৳ {{ number_format($l->discount_price) }} / {{ $l->price_unit }}@else{{ $l->price ? '৳ ' . number_format($l->price) . ' / ' . $l->price_unit : 'Contact' }}@endif</b><a
                                        class="btn btn-sm btn-primary" href="{{ route('listing.show', $l) }}">View</a>
                                </div>
                            </div>
                    </div>@empty<div class="col-12">
                            <div class="alert alert-info">No listings found. Try another filter.</div>
                        </div>
                    @endforelse
                </div>{{ $listings->links() }}
            </main>
        </div>
    </div>
    @php($mapsKey = App\Models\Setting::get('google_maps_api_key', config('services.google.maps_key')))
    @if ($mapsKey)
        <script>
            window.initShohayokMap = function() {
                const el = document.getElementById('nearby-map');
                if (!el || !window.google) return;
                const center = {
                    lat: {{ (float) App\Models\Setting::get('maps_default_lat', '23.8103') }},
                    lng: {{ (float) App\Models\Setting::get('maps_default_lng', '90.4125') }}
                };
                const map = new google.maps.Map(el, {
                    center,
                    zoom: 12,
                    mapTypeControl: false,
                    streetViewControl: false
                });
                window.shohayokMap = map;
                const listings = {!! json_encode(
                    $listings->getCollection()->map(function ($l) {
                            return [
                                'title' => $l->title,
                                'lat' => (float) $l->latitude,
                                'lng' => (float) $l->longitude,
                                'url' => route('listing.show', $l),
                            ];
                        })->values(),
                ) !!};
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(p => {
                        const pos = {
                            lat: p.coords.latitude,
                            lng: p.coords.longitude
                        };
                        map.setCenter(pos);
                        map.setZoom(14);
                        new google.maps.Marker({
                            position: pos,
                            map,
                            title: 'Your location'
                        });
                        document.querySelectorAll('input[name=lat]').forEach(i => i.value = pos.lat);
                        document.querySelectorAll('input[name=lng]').forEach(i => i.value = pos.lng);
                    });
                }
            };
        </script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ urlencode($mapsKey) }}&libraries=places&callback=initShohayokMap"
            async defer></script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const el = document.getElementById('nearby-map');
                if (el) el.innerHTML =
                    '<div class="p-5 text-center text-secondary">Google Maps API key is not configured yet. Add it from Admin → Settings or .env.</div>';
            });
        </script>
    @endif











    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const switches = document.querySelectorAll('.location-toggle');

            switches.forEach(function(toggle) {
                toggle.addEventListener('change', function() {
                    const isOn = this.checked;

                    switches.forEach(function(item) {
                        item.checked = isOn;
                    });
                });
            });
        });
    </script>
@endsection
