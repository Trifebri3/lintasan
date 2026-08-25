<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HeroImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = HeroImage::orderBy('sort_order')->get();
        return view('admin.hero.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'subtitle_id' => 'required|string',
            'subtitle_en' => 'required|string',
            'sort_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'button_link' => 'nullable|string|max:255',
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = \App\Helpers\ImageHelper::compressAndSave($request->file('image'), 'hero', 'slide');
        }

        HeroImage::create([
            'image_path' => $imagePath,
            'title_id' => $request->title_id,
            'title_en' => $request->title_en,
            'subtitle_id' => $request->subtitle_id,
            'subtitle_en' => $request->subtitle_en,
            'sort_order' => $request->sort_order,
            'is_active' => $request->is_active,
            'button_link' => $request->button_link,
        ]);

        return redirect()->route('admin.hero-images.index')->with('success', 'Slide Hero baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slide = HeroImage::findOrFail($id);
        return view('admin.hero.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $slide = HeroImage::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'subtitle_id' => 'required|string',
            'subtitle_en' => 'required|string',
            'sort_order' => 'required|integer',
            'is_active' => 'required|boolean',
            'button_link' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Delete old file if local
            if ($slide->image_path) {
                if (str_starts_with($slide->image_path, '/storage/')) {
                    $relativePath = str_replace('/storage/', '', $slide->image_path);
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                } elseif (File::exists(public_path($slide->image_path))) {
                    File::delete(public_path($slide->image_path));
                }
            }

            $slide->image_path = \App\Helpers\ImageHelper::compressAndSave($request->file('image'), 'hero', 'slide');
        }

        $slide->update([
            'title_id' => $request->title_id,
            'title_en' => $request->title_en,
            'subtitle_id' => $request->subtitle_id,
            'subtitle_en' => $request->subtitle_en,
            'sort_order' => $request->sort_order,
            'is_active' => $request->is_active,
            'button_link' => $request->button_link,
        ]);

        return redirect()->route('admin.hero-images.index')->with('success', 'Slide Hero berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $slide = HeroImage::findOrFail($id);

        if ($slide->image_path) {
            if (str_starts_with($slide->image_path, '/storage/')) {
                $relativePath = str_replace('/storage/', '', $slide->image_path);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            } elseif (File::exists(public_path($slide->image_path))) {
                File::delete(public_path($slide->image_path));
            }
        }

        $slide->delete();

        return redirect()->route('admin.hero-images.index')->with('success', 'Slide Hero berhasil dihapus.');
    }
}
