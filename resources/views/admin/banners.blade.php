@extends('layouts.app', ['title' => 'Banner Management — Shohayok'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('admin.partials.sidebar')<main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <div class="mb-4">
                    <h2 class="fw-bold">Carousel / Banner Management</h2>
                    <p class="text-secondary">Control homepage offers and campaigns.</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card-soft p-4">
                            <h5>Add New Banner</h5>
                            <form method="post" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                                @csrf<div class="mb-2"><label>Title</label><input class="form-control" name="title"
                                        required></div>
                                <div class="mb-2"><label>Subtitle</label>
                                    <textarea class="form-control" name="subtitle"></textarea>
                                </div>
                                <div class="row g-2">
                                    <div class="col"><input class="form-control" name="button_text"
                                            placeholder="Button text"></div>
                                    <div class="col"><input class="form-control" name="button_url"
                                            placeholder="Button URL"></div>
                                </div>
                                <div class="my-2"><label>Image</label><input class="form-control" type="file"
                                        name="image"></div>
                                <div class="mb-2"><label>Sort order</label><input class="form-control" type="number"
                                        name="sort_order" value="0"></div><button class="btn btn-primary w-100">Create
                                    Banner</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card-soft p-4">
                            <h5>Active Banners</h5>
                            @forelse($banners as $banner)
                                <div class="d-flex gap-3 align-items-center border-bottom py-3">
                                    <div class="listing-thumb" style="width:150px;height:80px;font-size:2rem">🖼️</div>
                                    <div class="flex-grow-1"><b>{{ $banner->title }}</b>
                                        <div class="small text-secondary">{{ $banner->subtitle }}</div>
                                    </div><span
                                        class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $banner->is_active ? 'Active' : 'Off' }}</span>
                            </div>@empty<p class="text-secondary">No banners yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
