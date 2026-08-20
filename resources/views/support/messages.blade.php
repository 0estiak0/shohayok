@extends('layouts.app', ['title' => 'Messages — Shohayok'])
@section('content')
@if(auth()->user()->isProvider())
    <div class="container-fluid"><div class="row">
        @include('provider.partials.sidebar')
        <main class="col-lg-10 dashboard-main p-4 p-xl-5">
            @include('support.partials.message-panel')
        </main>
    </div></div>
@else
    <div class="container-fluid"><div class="row">
        @include('profile.partials.sidebar')
        <main class="col-lg-10 dashboard-main p-4 p-xl-5">@include('support.partials.message-panel')</main>
    </div></div>
@endif
@endsection
