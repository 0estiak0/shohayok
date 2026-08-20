@extends('layouts.app', ['title' => 'Incoming Bookings — Shohayok'])
@section('content')
<div class="container-fluid"><div class="row">
    @include('provider.partials.sidebar')
    <main class="col-lg-10 dashboard-main p-4 p-xl-5">
        <div class="mb-4"><h2 class="fw-bold">Incoming Bookings</h2><p class="text-secondary">Review and update customer requests.</p></div>
        <div class="card-soft p-3"><div class="table-responsive"><table class="table align-middle">
            <thead><tr><th>Customer</th><th>Listing</th><th>Date</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>@forelse($bookings as $booking)
                <tr><td>{{ $booking->customer->name }}</td><td>{{ $booking->listing->title }}</td><td>{{ optional($booking->start_at)->format('d M Y H:i') ?: 'Not scheduled' }}</td><td>৳ {{ number_format($booking->amount) }}</td><td><span class="badge bg-light text-dark">{{ ucfirst($booking->status) }}</span></td><td>
                    <form method="post" action="{{ route('provider.booking.update', $booking) }}" class="d-flex gap-1">@csrf @method('PATCH')
                        <select name="status" class="form-select form-select-sm" aria-label="Booking status">
                            @foreach(['confirmed'=>'Confirm','rejected'=>'Reject','completed'=>'Complete','cancelled'=>'Cancel'] as $value=>$label)<option value="{{ $value }}" @selected($booking->status === $value)>{{ $label }}</option>@endforeach
                        </select><button class="btn btn-sm btn-primary">Save</button>
                    </form>
                </td></tr>
            @empty<tr><td colspan="6" class="text-center py-5">No bookings yet.</td></tr>@endforelse</tbody>
        </table></div><div class="mt-3">{{ $bookings->links() }}</div></div>
    </main>
</div></div>
@endsection
