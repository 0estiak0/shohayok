@extends('layouts.app', ['title' => 'Reviews & Ratings — Shohayok'])
@section('content')
    <div class="container-fluid">
        <div class="row">@include('provider.partials.sidebar')<main class="col-lg-10 dashboard-main p-4 p-xl-5">
                <h2 class="fw-bold">Reviews &amp; Ratings</h2>
                <p class="text-secondary mb-4">Feedback received from your customers.</p>
                <div class="card-soft p-4">
                    @forelse($reviews as $review)
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between"><b>{{ $review->customer->name }}</b><span
                                    class="text-warning">{{ str_repeat('★', $review->rating) }} <span
                                        class="text-dark">{{ $review->rating }}/5</span></span></div>
                            <div class="small text-secondary mb-2">{{ $review->listing->title }} ·
                                {{ $review->created_at->format('d M Y') }}</div>
                            <div>{{ $review->comment ?: 'No written comment.' }}</div>
                    </div>@empty<p class="text-secondary mb-0">No reviews yet.</p>
                    @endforelse
                </div>
                <div class="mt-3">{{ $reviews->links() }}</div>
            </main>
        </div>
    </div>
@endsection
