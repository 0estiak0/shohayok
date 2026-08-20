<?php

namespace App\Http\Controllers;

use App\Models\{Booking, Category, Listing, Review, Work};
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function dashboard(Request $request)
    {
        abort_unless($request->user()->isProvider(), 403);
        $u = $request->user();
        $completed = Booking::where('provider_id', $u->id)->where('status', 'completed')->count();
        $pending = Booking::where('provider_id', $u->id)->where('status', 'pending')->count();
        $income = Booking::where('provider_id', $u->id)->whereIn('status', ['confirmed', 'completed'])->whereMonth('created_at', now()->month)->sum('amount');
        $rating = Review::where('provider_id', $u->id)->avg('rating') ?: 0;
        $views = Listing::where('provider_id', $u->id)->sum('views');
        $listings = Listing::with('category')->where('provider_id', $u->id)->latest()->get();
        $works = Work::where('provider_id', $u->id)->latest()->get();
        $reviews = Review::with(['customer', 'listing'])->where('provider_id', $u->id)->latest()->limit(10)->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $notifications = $u->notifications()->latest()->limit(10)->get();
        return view('provider.dashboard', compact('u', 'completed', 'pending', 'income', 'rating', 'views', 'listings', 'works', 'reviews', 'categories', 'notifications'));
    }

    public function updateProfile(Request $request)
    {
        abort_unless($request->user()->isProvider(), 403);
        $data = $request->validate(['name'=>'required|string|max:255','phone'=>'nullable|string|max:30','address'=>'nullable|string|max:500','city'=>'nullable|string|max:100','country'=>'nullable|string|max:100','avatar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:3072']);
        if ($request->hasFile('avatar')) $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        $request->user()->update($data);
        return redirect()->route('provider.profile')->with('success', 'Profile updated.');
    }

    public function profile(Request $request) { return view('provider.profile', ['u' => $this->provider($request)]); }
    public function editProfile(Request $request) { return view('provider.edit-profile', ['u' => $this->provider($request)]); }

    public function services(Request $request)
    {
        $u = $this->provider($request);
        $listings = Listing::with('category')->where('provider_id', $u->id)->latest()->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('provider.services', compact('u', 'listings', 'categories'));
    }

    public function createWork(Request $request) { return view('provider.create-work', ['u' => $this->provider($request)]); }

    public function works(Request $request)
    {
        $u = $this->provider($request);
        $works = Work::where('provider_id', $u->id)->latest()->get();
        return view('provider.works', compact('u', 'works'));
    }

    public function reviews(Request $request)
    {
        $u = $this->provider($request);
        $reviews = Review::with(['customer', 'listing'])->where('provider_id', $u->id)->latest()->paginate(10);
        return view('provider.reviews', compact('u', 'reviews'));
    }

    public function notifications(Request $request)
    {
        $u = $this->provider($request);
        $notifications = $u->notifications()->latest()->paginate(15);
        $u->unreadNotifications->markAsRead();
        return view('provider.notifications', compact('u', 'notifications'));
    }

    public function settings(Request $request) { return view('provider.settings', ['u' => $this->provider($request)]); }

    public function updateSettings(Request $request)
    {
        $u = $this->provider($request);
        $data = $request->validate(['availability_status' => 'required|in:available,busy,inactive']);
        $u->update($data);
        return back()->with('success', 'Settings updated.');
    }

    public function work(Request $request)
    {
        abort_unless($request->user()->isProvider(), 403);
        $data = $request->validate(['customer_name'=>'required','title'=>'required','description'=>'nullable','location'=>'nullable','rating'=>'nullable|numeric|min:1|max:5','images'=>'nullable|array','images.*'=>'image|max:5120']);
        $data['provider_id'] = $request->user()->id;
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) $paths[] = $file->store('works', 'public');
            $data['images'] = $paths;
        }
        Work::create($data);
        return redirect()->route('provider.works')->with('success', 'Work added.');
    }

    private function provider(Request $request)
    {
        abort_unless($request->user()->isProvider(), 403);
        return $request->user();
    }
}
