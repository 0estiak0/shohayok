@extends('layouts.app', ['title' => 'Ads Management — Shohayok'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('admin.partials.sidebar')<main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <h2 class="fw-bold">Ads Management</h2>
                <p class="text-secondary mb-4">Control sponsored and featured placement for service and rental listings.</p>
                <div class="card-soft p-3 table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Provider</th>
                                <th>Type</th>
                                <th>Promotion</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($listings as $listing)
                                <tr>
                                    <td><b>{{ $listing->title }}</b>
                                        <div class="small text-secondary">{{ $listing->category->name }}</div>
                                    </td>
                                    <td>{{ $listing->provider->name }}</td>
                                    <td>{{ ucfirst($listing->type) }}</td>
                                    <td>
                                        @if ($listing->is_sponsored)
                                            <span class="badge bg-warning text-dark">Sponsored</span>
                                            @endif @if ($listing->is_featured)
                                                <span class="badge bg-primary">Featured</span>
                                                @endif @if (!$listing->is_sponsored && !$listing->is_featured)
                                                    <span class="text-secondary">Standard</span>
                                                @endif
                                    </td>
                                    <td>
                                        <form method="post" action="{{ route('admin.ads.update', $listing) }}"
                                            class="d-flex gap-2">@csrf @method('PATCH')<select
                                                class="form-select form-select-sm" name="is_sponsored">
                                                <option value="0" @selected(!$listing->is_sponsored)>Not sponsored</option>
                                                <option value="1" @selected($listing->is_sponsored)>Sponsored</option>
                                            </select><select class="form-select form-select-sm" name="is_featured">
                                                <option value="0" @selected(!$listing->is_featured)>Not featured</option>
                                                <option value="1" @selected($listing->is_featured)>Featured</option>
                                            </select><button class="btn btn-sm btn-primary">Save</button></form>
                                    </td>
                            </tr>@empty<tr>
                                    <td colspan="5" class="text-center py-5 text-secondary">No listings found.</td>
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
