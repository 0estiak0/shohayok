@extends('layouts.app', ['title' => __('ui.provider_payment') . ' — Shohayok'])
@section('content')
    <div class="container py-5" style="max-width:900px">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">{{ __('ui.provider_payment') }}</h2>
                <p class="text-secondary">Activate your service provider account. Pricing is controlled by the admin panel.
                </p>
            </div>
        </div>
        @if (auth()->user()->isProvider())
            <div class="alert alert-success">Your account is already a provider account. <a
                    href="{{ route('provider.dashboard') }}">Open dashboard</a>.</div>
        @else
            @if ($latest)
                <div
                    class="alert {{ $latest->status === 'approved' ? 'alert-success' : ($latest->status === 'rejected' ? 'alert-danger' : 'alert-warning') }}">
                    <b>Latest application:</b> {{ ucfirst($latest->status) }} @if ($latest->admin_note)
                        <br><small>{{ $latest->admin_note }}</small>
                    @endif
                </div>
            @endif
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card-soft p-4">
                        <h5>Price Summary</h5>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span>{{ __('ui.regular_price') }}</span><b>৳ {{ number_format($regular, 2) }}</b></div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span>{{ __('ui.discount') }}</span><b>{{ number_format($discountPercent, 0) }}%</b></div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span>{{ __('ui.discount_price') }}</span><b class="text-success">- ৳
                                {{ number_format($discountAmount, 2) }}</b></div>
                        <div class="d-flex justify-content-between py-3 fs-5"><span>{{ __('ui.total') }}</span><b
                                class="text-primary">৳ {{ number_format($total, 2) }}</b></div>
                        @if ($total <= 0)
                            <div class="alert alert-success mb-0">100% discount is active. No payment is required.</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card-soft p-4">
                        <h5>{{ $total > 0 ? 'Manual Payment' : 'Activate Provider Account' }}</h5>
                        @if ($total > 0)
                            <p class="text-secondary">Send ৳ {{ number_format($total, 2) }} to one of the numbers below
                                using <b>Send Money</b>, then submit the transaction information.</p>
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-3"><b>bKash</b>
                                        <div class="fs-5">{{ $bkash }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3"><b>Nagad</b>
                                        <div class="fs-5">{{ $nagad }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <form method="post" action="{{ route('provider.apply.store') }}">@csrf @if ($total > 0)
                                <label>{{ __('ui.payment_method') }}</label><select class="form-select mb-3"
                                    name="payment_method" required>
                                    <option value="">Select</option>
                                    <option value="bkash">bKash</option>
                                    <option value="nagad">Nagad</option>
                                </select><label>{{ __('ui.sender_number') }}</label><input class="form-control mb-3"
                                    name="sender_number" required><label>{{ __('ui.transaction_id') }}</label><input
                                    class="form-control mb-3" name="transaction_id" required>
                            @endif
                            <button class="btn btn-primary w-100">
                                {{ $total > 0 ? __('ui.submit_payment') : 'Activate with 100% Discount' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
