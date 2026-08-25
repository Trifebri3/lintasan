<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VillageController extends Controller
{
    /**
     * Display a listing of assisted villages.
     */
    public function index()
    {
        $villages = Village::all();
        return view('admin.desabinaan.index', compact('villages'));
    }

    /**
     * Show the form for creating a new assisted village.
     */
    public function create()
    {
        return view('admin.desabinaan.create');
    }

    /**
     * Store a newly created village in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'narrative' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_iframe' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $image_path = '';
        if ($request->hasFile('image_path')) {
            $image_path = \App\Helpers\ImageHelper::compressAndSave($request->file('image_path'), 'villages', $request->name);
        }

        Village::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'location' => $request->location,
            'description' => $request->description,
            'narrative' => $request->narrative,
            'image_path' => $image_path,
            'map_iframe' => $request->map_iframe,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('admin.villages.index')->with('success', 'Desa mitra lintasan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified village.
     */
    public function edit($id)
    {
        $village = Village::findOrFail($id);
        return view('admin.desabinaan.edit', compact('village'));
    }

    /**
     * Update the specified village in storage.
     */
    public function update(Request $request, $id)
    {
        $village = Village::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'narrative' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_iframe' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $image_path = $village->image_path;
        if ($request->hasFile('image_path')) {
            // Delete old file
            if ($village->image_path) {
                if (str_starts_with($village->image_path, '/storage/')) {
                    $relativePath = str_replace('/storage/', '', $village->image_path);
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                } elseif (File::exists(public_path($village->image_path))) {
                    File::delete(public_path($village->image_path));
                }
            }

            $image_path = \App\Helpers\ImageHelper::compressAndSave($request->file('image_path'), 'villages', $request->name);
        }

        $village->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'location' => $request->location,
            'description' => $request->description,
            'narrative' => $request->narrative,
            'image_path' => $image_path,
            'map_iframe' => $request->map_iframe,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('admin.villages.index')->with('success', 'Desa mitra lintasan berhasil diperbarui.');
    }

    /**
     * Remove the specified village from storage.
     */
    public function destroy($id)
    {
        $village = Village::findOrFail($id);
        
        // Delete associated image file
        if ($village->image_path) {
            if (str_starts_with($village->image_path, '/storage/')) {
                $relativePath = str_replace('/storage/', '', $village->image_path);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            } elseif (File::exists(public_path($village->image_path))) {
                File::delete(public_path($village->image_path));
            }
        }

        $village->delete();

        return redirect()->route('admin.villages.index')->with('success', 'Desa mitra lintasan berhasil dihapus.');
    }
}
