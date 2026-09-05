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
        ], $this->validationMessages(true));

        try {
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
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menambahkan slide hero: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan slide hero: ' . $e->getMessage());
        }
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
        ], $this->validationMessages(false));

        try {
            $imagePath = $slide->image_path;
            if ($request->hasFile('image')) {
                // Delete old file if local
                \App\Helpers\ImageHelper::deleteFile($slide->image_path);
                $imagePath = \App\Helpers\ImageHelper::compressAndSave($request->file('image'), 'hero', 'slide');
            }

            $slide->update([
                'image_path' => $imagePath,
                'title_id' => $request->title_id,
                'title_en' => $request->title_en,
                'subtitle_id' => $request->subtitle_id,
                'subtitle_en' => $request->subtitle_en,
                'sort_order' => $request->sort_order,
                'is_active' => $request->is_active,
                'button_link' => $request->button_link,
            ]);

            return redirect()->route('admin.hero-images.index')->with('success', 'Slide Hero berhasil diperbarui.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal memperbarui slide hero: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui slide hero: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $slide = HeroImage::findOrFail($id);

        \App\Helpers\ImageHelper::deleteFile($slide->image_path);

        $slide->delete();

        return redirect()->route('admin.hero-images.index')->with('success', 'Slide Hero berhasil dihapus.');
    }

    /**
     * Custom Indonesian validation messages for hero slides.
     */
    private function validationMessages(bool $isCreate = true): array
    {
        return [
            'image.required' => 'File gambar slide hero wajib diunggah.',
            'image.image' => 'Berkas slide harus berupa file gambar.',
            'image.mimes' => 'Format gambar slide harus JPG, JPEG, PNG, WEBP, atau SVG.',
            'image.max' => 'Ukuran gambar slide tidak boleh melebihi 4 MB (4096 KB).',
            'image.uploaded' => 'Gagal mengunggah gambar slide. Ukuran file kemungkinan melebihi kapasitas server.',
            'title_id.required' => 'Judul utama slogan (Bahasa Indonesia) wajib diisi.',
            'title_en.required' => 'Judul utama slogan (Bahasa Inggris) wajib diisi.',
            'subtitle_id.required' => 'Deskripsi sub-slogan (Bahasa Indonesia) wajib diisi.',
            'subtitle_en.required' => 'Deskripsi sub-slogan (Bahasa Inggris) wajib diisi.',
            'sort_order.required' => 'Urutan tampil slide wajib diisi.',
            'sort_order.integer' => 'Urutan tampil harus berupa angka.',
            'is_active.required' => 'Status visibilitas slide wajib ditentukan.',
        ];
    }
}
