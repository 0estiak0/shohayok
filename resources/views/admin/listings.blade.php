@extends('layouts.app', ['title' => 'Services & Rentals — Shohayok'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('admin.partials.sidebar')<main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold">Services &amp; Rentals</h2>
                        <p class="text-secondary">Create and review service or rental listings.</p>
                    </div><button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#createListing">+ Create
                        New</button>
                </div>
                <div class="collapse mb-4" id="createListing">
                    <div class="card-soft p-4">
                        <h5>Create Service / Rental</h5>
                        <form method="post" action="{{ route('admin.listings.store') }}" enctype="multipart/form-data"
                            class="row g-3">@csrf
                            <div class="col-md-4"><label class="form-label">Listing type</label><select class="form-select"
                                    name="type" required>
                                    <option value="service">Service</option>
                                    <option value="rental">Rental</option>
                                </select></div>
                            <div class="col-md-4"><label class="form-label">Provider</label><select class="form-select"
                                    name="provider_id">
                                    <option value="">Select or enter manually</option>
                                    @foreach ($providers as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                                <label class="form-label mt-2">Manual provider</label>
                                <input class="form-control" name="manual_provider"
                                    placeholder="Email, phone, or exact name">
                                <div class="form-text">Manual provider overrides the dropdown.</div>
                            </div>
                            <div class="col-md-4"><label class="form-label">Category</label><select
                                    class="form-select" name="category_id" required>
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}
                                            ({{ ucfirst($category->type) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12"><label class="form-label">Title</label><input class="form-control"
                                    name="title" required></div>
                            <div class="col-12"><label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-4"><label class="form-label">Regular price</label><input class="form-control"
                                    type="number" name="price" min="0" step="0.01" required></div>
                            <div class="col-md-4"><label class="form-label">Discount price</label><input
                                    class="form-control" type="number" name="discount_price" min="0" step="0.01"
                                    placeholder="Optional"></div>
                            <div class="col-md-4"><label class="form-label">Price unit</label><select class="form-select"
                                    name="price_unit">
                                    <option value="per_job">Per job</option>
                                    <option value="per_hour">Per hour</option>
                                    <option value="per_day">Per day</option>
                                    <option value="per_month">Per month</option>
                                </select></div>
                            <div class="col-12"><label class="form-label">Address</label><input class="form-control"
                                    name="address" required></div>
                            <div class="col-md-6"><label class="form-label">City</label><input class="form-control"
                                    name="city" required></div>
                            <div class="col-md-6"><label class="form-label">Country</label><input class="form-control"
                                    name="country" value="Bangladesh" required></div>
                            <div class="col-12"><label class="form-label">Images</label><input class="form-control"
                                    type="file" name="images[]" multiple accept="image/*"></div>
                            <div><button class="btn btn-primary">Create Listing</button></div>
                        </form>
                    </div>
                </div>
                <div class="card-soft p-3 table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Type</th>
                                <th>Provider</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($listings as $listing)
                                <tr>
                                    <td><a href="{{ route('listing.show', $listing) }}"><b>{{ $listing->title }}</b></a>
                                        <div class="small text-secondary">{{ $listing->category->name }}</div>
                                    </td>
                                    <td>{{ ucfirst($listing->type) }}</td>
                                    <td><a
                                            href="{{ route('admin.users.show', $listing->provider) }}">{{ $listing->provider->name }}</a>
                                    </td>
                                    <td>
                                        @if ($listing->discount_price)
                                            <span
                                                class="text-decoration-line-through text-secondary">৳{{ number_format($listing->price) }}</span>
                                            <b
                                            class="text-success">৳{{ number_format($listing->discount_price) }}</b>@else৳{{ number_format($listing->price) }}
                                        @endif
                                    </td>
                                    <td><span
                                            class="badge bg-success-subtle text-success">{{ ucfirst($listing->status) }}</span>
                                    </td>
                            </tr>@empty<tr>
                                    <td colspan="5" class="text-center py-5">No listings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $listings->links() }}</div>
            </main>
        </div>
    </div>
@endsection
