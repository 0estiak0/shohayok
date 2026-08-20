@extends('layouts.app', ['title' => 'My Services — Shohayok'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('provider.partials.sidebar')
            <main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold">My Services</h2>
                        <p class="text-secondary">Create and review your service listings.</p>
                    </div><button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#newService">+ Add
                        Service</button>
                </div>
                <div class="collapse mb-4" id="newService">
                    <div class="card-soft p-4">
                        <form method="post" action="{{ route('provider.listing.store') }}" enctype="multipart/form-data"
                            class="row g-3">@csrf<input type="hidden" name="type" value="service">
                            <div class="col-md-6"><label class="form-label">Category</label><select class="form-select"
                                    name="category_id" required>
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6"><label class="form-label">Title</label><input class="form-control"
                                    name="title" required></div>
                            <div class="col-12"><label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6"><label class="form-label">Price</label><input class="form-control"
                                    type="number" min="0" step="0.01" name="price"></div>
                            <div class="col-md-6"><label class="form-label">Price unit</label><select class="form-select"
                                    name="price_unit">
                                    <option value="per_job">Per job</option>
                                    <option value="per_hour">Per hour</option>
                                    <option value="per_day">Per day</option>
                                </select></div>
                            <div class="col-12"><label class="form-label">Address</label><input class="form-control"
                                    name="address" value="{{ $u->address }}" required></div>
                            <div class="col-md-6"><label class="form-label">City</label><input class="form-control"
                                    name="city" value="{{ $u->city }}" required></div>
                            <div class="col-md-6"><label class="form-label">Country</label><input class="form-control"
                                    name="country" value="{{ $u->country }}" required></div>
                            <div class="col-12"><label class="form-label">Images</label><input class="form-control"
                                    type="file" name="images[]" multiple accept="image/*"></div>
                            <div><button class="btn btn-primary">Save Service</button></div>
                        </form>
                    </div>
                </div>
                <div class="card-soft p-4">
                    @forelse($listings as $listing)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                            <div>
                                <h5 class="mb-1">{{ $listing->title }}</h5><span
                                    class="text-secondary">{{ $listing->category->name }} · ৳
                                    {{ number_format($listing->price) }} / {{ $listing->price_unit }}</span>
                            </div><span class="badge bg-success-subtle text-success">{{ ucfirst($listing->status) }}</span>
                    </div>@empty<p class="text-secondary mb-0">You have not added any services yet.</p>
                    @endforelse
                </div>
            </main>
        </div>
    </div>
@endsection
