<?php

namespace App\Http\Controllers;

use App\Models\{ProviderMessage, User};
use Illuminate\Http\Request;

class ProviderMessageController extends Controller
{
    public function index(Request $request)
    {
        $provider = $this->provider($request);
        $conversations = ProviderMessage::with('customer')->where('provider_id', $provider->id)->latest()->get()->unique('customer_id')->values();
        return view('provider.messages', compact('provider', 'conversations'));
    }

    public function providerThread(Request $request, User $customer)
    {
        $provider = $this->provider($request);
        abort_if($customer->isAdmin() || $customer->id === $provider->id, 404);
        $messages = $this->messages($provider, $customer);
        ProviderMessage::where('provider_id', $provider->id)->where('customer_id', $customer->id)->where('sender_id', $customer->id)->whereNull('read_at')->update(['read_at' => now()]);
        return view('provider.messages', compact('provider', 'customer', 'messages'));
    }

    public function providerStore(Request $request, User $customer)
    {
        $provider = $this->provider($request);
        abort_if($customer->isAdmin() || $customer->id === $provider->id, 404);
        $this->store($request, $provider, $customer);
        return back()->with('success', 'Message sent.');
    }

    public function customerThread(Request $request, User $provider)
    {
        abort_unless($provider->isProvider() && $provider->id !== $request->user()->id, 404);
        $customer = $request->user();
        $messages = $this->messages($provider, $customer);
        ProviderMessage::where('provider_id', $provider->id)->where('customer_id', $customer->id)->where('sender_id', $provider->id)->whereNull('read_at')->update(['read_at' => now()]);
        return view('messages.provider-thread', compact('provider', 'customer', 'messages'));
    }

    public function customerStore(Request $request, User $provider)
    {
        abort_unless($provider->isProvider() && $provider->id !== $request->user()->id, 404);
        $this->store($request, $provider, $request->user());
        return back()->with('success', 'Message sent.');
    }

    private function messages(User $provider, User $customer)
    {
        return ProviderMessage::where('provider_id', $provider->id)->where('customer_id', $customer->id)->oldest()->get();
    }

    private function store(Request $request, User $provider, User $customer): void
    {
        $data = $request->validate(['message' => 'required|string|max:3000']);
        ProviderMessage::create(['provider_id' => $provider->id, 'customer_id' => $customer->id, 'sender_id' => $request->user()->id, 'message' => $data['message']]);
    }

    private function provider(Request $request): User
    {
        abort_unless($request->user()->isProvider(), 403);
        return $request->user();
    }
}
