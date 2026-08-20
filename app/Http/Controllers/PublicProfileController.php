<?php

namespace App\Http\Controllers;

use App\Models\{User, Work};
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function providers()
    {
        $providers = User::where('role', 'provider')->withCount('reviews')->withAvg('reviews', 'rating')->latest()->paginate(18);
        return view('providers.index', compact('providers'));
    }

    public function provider(User $provider)
    {
        abort_unless($provider->isProvider(), 404);
        $provider->load(['listings.category', 'works'])->loadCount('reviews')->loadAvg('reviews', 'rating');
        return view('providers.show', compact('provider'));
    }

    public function works()
    {
        $works = Work::with('provider')->latest()->paginate(12);
        return view('works.index', compact('works'));
    }

    public function likeWork(Request $request, Work $work)
    {
        $key = 'liked_work_' . $work->id;
        if (!$request->session()->has($key)) {
            $work->increment('likes');
            $request->session()->put($key, true);
        }
        return back();
    }
}
