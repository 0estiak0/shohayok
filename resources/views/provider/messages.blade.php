@extends('layouts.app', ['title' => 'Customer Messages — Shohayok'])
@section('content')
<div class="container-fluid"><div class="row">@include('provider.partials.sidebar')
<main class="col-lg-10 dashboard-main p-4 p-xl-5"><h2 class="fw-bold">Customer Messages</h2><p class="text-secondary mb-4">Messages between you and your customers.</p>
@isset($customer)<div class="d-flex align-items-center gap-3 mb-3"><a class="btn btn-outline-primary" href="{{ route('provider.messages') }}">← Conversations</a><h5 class="mb-0">{{ $customer->name }}</h5></div>@include('messages.partials.thread', ['otherUser'=>$customer, 'formAction'=>route('provider.messages.store', $customer)])
@else<div class="card-soft p-4">@forelse($conversations as $conversation)<a class="d-flex justify-content-between align-items-center border-bottom py-3 text-dark" href="{{ route('provider.messages.thread', $conversation->customer) }}"><div><b>{{ $conversation->customer->name }}</b><div class="text-secondary">{{ Str::limit($conversation->message, 80) }}</div></div><small class="text-secondary">{{ $conversation->created_at->diffForHumans() }}</small></a>@empty<div class="text-center text-secondary py-5">No customer conversations yet.</div>@endforelse</div>@endisset
</main></div></div>
@endsection
