@extends('layouts.app', ['title' => 'Message ' . $provider->name . ' — Shohayok'])
@section('content')
<div class="container py-5" style="max-width:850px"><div class="d-flex justify-content-between align-items-center mb-4"><div><h2 class="fw-bold">{{ $provider->name }}</h2><p class="text-secondary mb-0">Direct conversation with your service provider.</p></div><a class="btn btn-outline-primary" href="{{ url()->previous() }}">Back</a></div>@include('messages.partials.thread', ['otherUser'=>$provider, 'formAction'=>route('customer.messages.store', $provider)])</div>
@endsection
