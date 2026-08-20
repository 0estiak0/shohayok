<div class="mb-4">
    <h2 class="fw-bold">Admin Support</h2>
    <p class="text-secondary mb-0">Messages between you and the Shohayok admin team.</p>
</div>
<div class="card-soft p-4">
    <div style="min-height:320px;max-height:520px;overflow:auto">
        @forelse($messages as $message)
            <div class="d-flex {{ $message->is_from_admin ? 'justify-content-start' : 'justify-content-end' }} mb-3">
                <div class="p-3 rounded-4 {{ $message->is_from_admin ? 'bg-light' : 'bg-primary text-white' }}" style="max-width:75%">
                    <div class="small fw-semibold mb-1">{{ $message->is_from_admin ? 'Admin' : 'You' }}</div>
                    {{ $message->message }}
                    <div class="small opacity-75 mt-1">{{ $message->created_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>
        @empty
            <div class="text-center text-secondary py-5">No messages yet.</div>
        @endforelse
    </div>
    <form method="post" action="{{ auth()->user()->isProvider() ? route('provider.messages.store') : route('support.messages.store') }}" class="d-flex gap-2 border-top pt-3">
        @csrf
        <textarea class="form-control" name="message" rows="2" maxlength="3000" required placeholder="Write a message..."></textarea>
        <button class="btn btn-primary px-4">Send</button>
    </form>
</div>
