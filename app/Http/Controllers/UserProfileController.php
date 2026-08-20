<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $bookings = Booking::with(['listing.provider'])->where('customer_id', $user->id)->latest()->limit(5)->get();
        return view('profile.show', compact('user', 'bookings'));
    }

    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);
        if ($request->hasFile('avatar')) $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        $user->update($data);
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function notifications(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->latest()->paginate(15);
        $user->unreadNotifications->markAsRead();
        return view('profile.notifications', compact('user', 'notifications'));
    }
}
