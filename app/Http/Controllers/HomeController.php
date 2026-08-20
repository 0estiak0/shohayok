<?php

namespace App\Http\Controllers;

use App\Models\{Banner, Category, Listing, Work, User};

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $services = Listing::with(['provider', 'category'])
            ->where('type', 'service')
            ->where('status', 'active')
            ->latest()
            ->limit(6)
            ->get();

        $rentals = Listing::with(['provider', 'category'])
            ->where('type', 'rental')
            ->where('status', 'active')
            ->latest()
            ->limit(6)
            ->get();

        $providers = User::where('role', 'provider')
            ->where('is_verified', true)
            ->withCount('reviews')
            ->limit(6)
            ->get();

        $works = Work::with('provider')
            ->latest()
            ->limit(3)
            ->get();

        return view('home.index', compact(
            'banners',
            'categories',
            'services',
            'rentals',
            'providers',
            'works'
        ));
    }
}