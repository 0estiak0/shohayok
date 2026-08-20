@extends('layouts.app', ['title' => 'Admin Messages — Shohayok'])
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<main class="col-lg-10 dashboard-main p-4 p-xl-5">
    <div class="mb-4"><h2 class="fw-bold">User &amp; Provider Messages</h2><p class="text-secondary">All support messages sent from the website.</p></div>
    <div class="card-soft p-3">@forelse($threads as $thread)
        <a href="{{ route('admin.messages.thread', $thread->user_id) }}" class="d-flex align-items-center text-decoration-none text-dark border-bottom p-3"><div class="provider-avatar me-3" style="width:48px;height:48px;font-size:1.2rem">💬</div><div class="flex-grow-1"><b>{{ $thread->user?->name ?? 'User' }}</b><div class="small text-secondary">{{ $thread->user?->role }} · Last message {{ \Carbon\Carbon::parse($thread->last_message_at)->diffForHumans() }}</div></div>@if($thread->unread_count)<span class="badge bg-danger">{{ $thread->unread_count }}</span>@endif</a>
    @empty<div class="text-center text-secondary py-5">No messages yet.</div>@endforelse</div>
</main></div></div>
@endsection
