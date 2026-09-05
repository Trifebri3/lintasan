<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Gallery::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('admin.galeri.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title_id' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'type' => 'required|in:image,video',
            'sort_order' => 'required|integer',
        ];

        if ($request->type === 'image') {
            $rules['image_file'] = 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096';
        } else {
            $rules['video_url'] = 'required|url';
        }

        $validated = $request->validate($rules, $this->validationMessages());

        try {
            $image_path = null;
            $video_url = null;
            $youtube_id = null;
            $embed_url = null;

            if ($request->type === 'image') {
                $image_path = \App\Helpers\ImageHelper::compressAndSave($request->file('image_file'), 'gallery', $request->title_id ?? 'gallery');
            } else {
                $video_url = $request->video_url;
                $youtube_id = $this->getYoutubeId($video_url);
                if ($youtube_id) {
                    $embed_url = 'https://www.youtube.com/embed/' . $youtube_id;
                } else {
                    return back()->withErrors(['video_url' => 'Format link YouTube tidak valid. Harap gunakan URL video YouTube yang benar.'])->withInput();
                }
            }

            Gallery::create([
                'title_id' => $request->title_id,
                'title_en' => $request->title_en,
                'type' => $request->type,
                'image_path' => $image_path,
                'video_url' => $video_url,
                'youtube_id' => $youtube_id,
                'embed_url' => $embed_url,
                'sort_order' => $request->sort_order,
            ]);

            return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil ditambahkan.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menambahkan item galeri: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan item galeri: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Gallery::findOrFail($id);
        return view('admin.galeri.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = Gallery::findOrFail($id);

        $rules = [
            'title_id' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'type' => 'required|in:image,video',
            'sort_order' => 'required|integer',
        ];

        if ($request->type === 'image' && !$item->image_path) {
            $rules['image_file'] = 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096';
        } elseif ($request->type === 'image') {
            $rules['image_file'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096';
        } elseif ($request->type === 'video') {
            $rules['video_url'] = 'required|url';
        }

        $request->validate($rules, $this->validationMessages());

        try {
            $image_path = $item->image_path;
            $video_url = $item->video_url;
            $youtube_id = $item->youtube_id;
            $embed_url = $item->embed_url;

            if ($request->type === 'image') {
                if ($request->hasFile('image_file')) {
                    // Delete old image if exists
                    \App\Helpers\ImageHelper::deleteFile($item->image_path);
                    $image_path = \App\Helpers\ImageHelper::compressAndSave($request->file('image_file'), 'gallery', $request->title_id ?? 'gallery');
                }
                $video_url = null;
                $youtube_id = null;
                $embed_url = null;
            } else {
                // Delete old image if it is switching from image to video
                \App\Helpers\ImageHelper::deleteFile($item->image_path);
                $image_path = null;

                $video_url = $request->video_url;
                $youtube_id = $this->getYoutubeId($video_url);
                if ($youtube_id) {
                    $embed_url = 'https://www.youtube.com/embed/' . $youtube_id;
                } else {
                    return back()->withErrors(['video_url' => 'Format link YouTube tidak valid. Harap gunakan URL video YouTube yang benar.'])->withInput();
                }
            }

            $item->update([
                'title_id' => $request->title_id,
                'title_en' => $request->title_en,
                'type' => $request->type,
                'image_path' => $image_path,
                'video_url' => $video_url,
                'youtube_id' => $youtube_id,
                'embed_url' => $embed_url,
                'sort_order' => $request->sort_order,
            ]);

            return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil diperbarui.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal memperbarui item galeri: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui item galeri: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Gallery::findOrFail($id);
        
        if ($item->type === 'image') {
            \App\Helpers\ImageHelper::deleteFile($item->image_path);
        }

        $item->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil dihapus.');
    }

    /**
     * Custom Indonesian validation messages for gallery items.
     */
    private function validationMessages(): array
    {
        return [
            'type.required' => 'Tipe dokumentasi galeri (Foto atau Video) wajib dipilih.',
            'type.in' => 'Tipe dokumentasi harus berupa image (foto) atau video.',
            'image_file.required' => 'File foto galeri wajib diunggah.',
            'image_file.image' => 'Berkas yang diunggah harus berupa file gambar.',
            'image_file.mimes' => 'Format foto harus JPG, JPEG, PNG, WEBP, GIF, atau SVG.',
            'image_file.max' => 'Ukuran foto galeri tidak boleh melebihi 4 MB (4096 KB).',
            'image_file.uploaded' => 'Gagal mengunggah foto galeri. Ukuran berkas kemungkinan melebihi kapasitas server.',
            'video_url.required' => 'Tautan URL video YouTube wajib diisi.',
            'video_url.url' => 'Format tautan link YouTube tidak valid (contoh: https://www.youtube.com/watch?v=...).',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
            'sort_order.integer' => 'Urutan tampil harus berupa angka.',
        ];
    }

    /**
     * Extract the unique YouTube video ID from a URL.
     */
    private function getYoutubeId($url)
    {
        $regExp = '/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/';
        if (preg_match($regExp, trim($url), $matches)) {
            return (strlen($matches[2]) == 11) ? $matches[2] : null;
        }
        return null;
    }
}
