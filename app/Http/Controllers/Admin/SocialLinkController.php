<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of social links.
     */
    public function index()
    {
        $socialLinks = SocialLink::orderBy('sort_order')->get();
        return view('admin.socials.index', compact('socialLinks'));
    }

    /**
     * Show the form for creating a new social link.
     */
    public function create()
    {
        return view('admin.socials.create');
    }

    /**
     * Store a newly created social link.
     */
    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'description_id' => 'nullable|string|max:255',
            'description_en' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        SocialLink::create([
            'platform' => $request->platform,
            'name' => $request->name,
            'url' => $request->url,
            'description_id' => $request->description_id,
            'description_en' => $request->description_en,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order,
        ]);

        Cache::forget('site_social_links');

        return redirect()->route('admin.social-links.index')->with('success', 'Media sosial baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified social link.
     */
    public function edit($id)
    {
        $socialLink = SocialLink::findOrFail($id);
        return view('admin.socials.edit', compact('socialLink'));
    }

    /**
     * Update the specified social link.
     */
    public function update(Request $request, $id)
    {
        $socialLink = SocialLink::findOrFail($id);

        $request->validate([
            'platform' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'description_id' => 'nullable|string|max:255',
            'description_en' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        $socialLink->update([
            'platform' => $request->platform,
            'name' => $request->name,
            'url' => $request->url,
            'description_id' => $request->description_id,
            'description_en' => $request->description_en,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order,
        ]);

        Cache::forget('site_social_links');

        return redirect()->route('admin.social-links.index')->with('success', 'Media sosial berhasil diperbarui.');
    }

    /**
     * Remove the specified social link.
     */
    public function destroy($id)
    {
        $socialLink = SocialLink::findOrFail($id);
        $socialLink->delete();

        Cache::forget('site_social_links');

        return redirect()->route('admin.social-links.index')->with('success', 'Media sosial berhasil dihapus.');
    }
}
