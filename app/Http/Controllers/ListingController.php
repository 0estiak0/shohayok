<?php
namespace App\Http\Controllers;
use App\Models\{Listing, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ListingController extends Controller
{
    public function explore(Request $r)
{
    $q = Listing::with(['provider', 'category'])
        ->where('status', 'active');

    // Apply type/category only when explicitly selected
    if ($r->filled('type')) {
        $q->where('type', $r->type);
    }

    if ($r->filled('category')) {
        $q->where('category_id', $r->category);
    }

    // Search title, description and category name
    if ($r->filled('q')) {
        $search = trim($r->q);

        $q->where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhereHas('category', function ($categoryQuery) use ($search) {
                    $categoryQuery->where('name', 'like', '%' . $search . '%');
                });
        });
    }

    $listings = $q->latest()
        ->paginate(12)
        ->withQueryString();

    $categories = Category::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    return view('listings.explore', compact('listings', 'categories'));
}
    public function show(Listing $listing)
    {
        $listing->increment('views');
        $listing->load(['provider', 'category']);
        return view('listings.show', compact('listing'));
    }
    public function store(Request $r)
    {
        abort_unless($r->user()->isProvider(), 403);
        $data = $r->validate(['type' => 'required|in:service,rental', 'category_id' => 'required|exists:categories,id', 'title' => 'required|max:180', 'description' => 'required', 'price' => 'nullable|numeric', 'price_unit' => 'required', 'latitude' => 'nullable|numeric', 'longitude' => 'nullable|numeric', 'address' => 'required', 'city' => 'required', 'country' => 'required', 'images' => 'nullable|array', 'images.*' => 'image|max:5120']);
        $data['provider_id'] = $r->user()->id;
        $data['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));
        if ($r->hasFile('images')) {
            $paths = [];
            foreach ($r->file('images') as $file)
                $paths[] = $file->store('listings', 'public');
            $data['images'] = $paths;
        }
        Listing::create($data);
        return back()->with('success', 'Listing submitted successfully.');
    }
}
