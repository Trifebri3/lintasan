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
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'map_iframe' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], $this->validationMessages(true));

        try {
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
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menambahkan desa mitra: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan desa mitra: ' . $e->getMessage());
        }
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
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'map_iframe' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], $this->validationMessages(false));

        try {
            $image_path = $village->image_path;
            if ($request->hasFile('image_path')) {
                // Delete old file
                \App\Helpers\ImageHelper::deleteFile($village->image_path);
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
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal memperbarui desa mitra: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui desa mitra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified village from storage.
     */
    public function destroy($id)
    {
        $village = Village::findOrFail($id);
        
        // Delete associated image file
        \App\Helpers\ImageHelper::deleteFile($village->image_path);

        $village->delete();

        return redirect()->route('admin.villages.index')->with('success', 'Desa mitra lintasan berhasil dihapus.');
    }

    /**
     * Custom Indonesian validation messages for villages.
     */
    private function validationMessages(bool $isCreate = true): array
    {
        return [
            'name.required' => 'Nama desa wajib diisi.',
            'location.required' => 'Lokasi / kabupaten desa wajib diisi.',
            'description.required' => 'Rangkuman singkat desa wajib diisi.',
            'narrative.required' => 'Kisah lengkap narasi desa wajib diisi.',
            'image_path.required' => 'Foto utama desa wajib diunggah.',
            'image_path.image' => 'Berkas foto utama desa harus berupa gambar.',
            'image_path.mimes' => 'Format foto desa harus JPG, JPEG, PNG, WEBP, GIF, atau SVG.',
            'image_path.max' => 'Ukuran foto desa tidak boleh melebihi 4 MB (4096 KB).',
            'image_path.uploaded' => 'Gagal mengunggah foto desa. Ukuran file kemungkinan melebihi batas upload server.',
            'latitude.numeric' => 'Nilai koordinat latitude harus berupa angka desimal.',
            'latitude.between' => 'Titik latitude harus berada dalam rentang -90 sampai 90.',
            'longitude.numeric' => 'Nilai koordinat longitude harus berupa angka desimal.',
            'longitude.between' => 'Titik longitude harus berada dalam rentang -180 sampai 180.',
        ];
    }
}
