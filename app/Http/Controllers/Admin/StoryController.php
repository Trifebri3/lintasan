<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stories = Story::latest()->get();
        return view('admin.ceritadampak.index', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = \App\Models\Program::all();
        return view('admin.ceritadampak.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'category_en' => 'required|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'content_id' => 'required|string',
            'content_en' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'impact_number' => 'nullable|string|max:50',
            'impact_label_id' => 'nullable|string|max:100',
            'impact_label_en' => 'nullable|string|max:100',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'youtube_links' => 'nullable|string',
            'program_id' => 'nullable|exists:programs,id',
            'related_links' => 'nullable|string',
        ], $this->validationMessages());

        try {
            $gallery = [];
            
            // 1. Process uploaded images with compression
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $path = \App\Helpers\ImageHelper::compressAndSave($file, 'stories', 'gallery');
                    $gallery[] = [
                        'type' => 'image',
                        'path' => $path
                    ];
                }
            }

            // 2. Process YouTube video links
            if ($request->filled('youtube_links')) {
                $links = explode("\n", str_replace("\r", "", $request->youtube_links));
                foreach ($links as $link) {
                    $link = trim($link);
                    if (empty($link)) continue;

                    $youtubeId = $this->getYoutubeId($link);
                    if ($youtubeId) {
                        $gallery[] = [
                            'type' => 'video',
                            'path' => $link,
                            'youtube_id' => $youtubeId,
                            'embed_url' => 'https://www.youtube.com/embed/' . $youtubeId,
                            'thumbnail' => 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg'
                        ];
                    }
                }
            }

            // Auto-assign colors depending on category
            $category = $request->category_id;
            $category_bg = 'bg-gray-100';
            $category_color = 'text-gray-700';

            if (stripos($category, 'spab') !== false) {
                $category_bg = 'bg-orange-100';
                $category_color = 'text-brand-orange';
            } elseif (stripos($category, 'tabur') !== false || stripos($category, 'laut') !== false || stripos($category, 'nelayan') !== false) {
                $category_bg = 'bg-emerald-100';
                $category_color = 'text-emerald-700';
            } elseif (stripos($category, 'smk') !== false) {
                $category_bg = 'bg-blue-100';
                $category_color = 'text-blue-700';
            } elseif (stripos($category, 'hutan') !== false || stripos($category, 'tanaman') !== false || stripos($category, 'pohon') !== false) {
                $category_bg = 'bg-green-100';
                $category_color = 'text-green-700';
            }

            $image_url = '';
            if ($request->hasFile('image_url')) {
                $image_url = \App\Helpers\ImageHelper::compressAndSave($request->file('image_url'), 'stories', 'thumb');
            }

            Story::create(array_merge($validated, [
                'image_url' => $image_url,
                'category_bg' => $category_bg,
                'category_color' => $category_color,
                'gallery' => $gallery,
                'link' => '#'
            ]));

            return redirect()->route('admin.stories.index')->with('success', 'Cerita lapangan berhasil ditambahkan.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menambahkan cerita: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan cerita: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $story = Story::findOrFail($id);
        $programs = \App\Models\Program::all();
        return view('admin.ceritadampak.edit', compact('story', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $story = Story::findOrFail($id);

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'category_en' => 'required|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'content_id' => 'required|string',
            'content_en' => 'required|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'impact_number' => 'nullable|string|max:50',
            'impact_label_id' => 'nullable|string|max:100',
            'impact_label_en' => 'nullable|string|max:100',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'youtube_links' => 'nullable|string',
            'program_id' => 'nullable|exists:programs,id',
            'related_links' => 'nullable|string',
        ], $this->validationMessages());

        try {
            $gallery = $story->gallery ?? [];
            
            // Remove photos/videos selected for deletion
            if ($request->has('remove_gallery')) {
                foreach ($request->input('remove_gallery') as $path) {
                    foreach ($gallery as $key => $item) {
                        $itemPath = is_array($item) ? ($item['path'] ?? '') : $item;
                        $itemType = is_array($item) ? ($item['type'] ?? 'image') : 'image';
                        if ($itemPath === $path) {
                            unset($gallery[$key]);
                            if ($itemType === 'image') {
                                \App\Helpers\ImageHelper::deleteFile($path);
                            }
                            break;
                        }
                    }
                }
                $gallery = array_values($gallery); // Re-index
            }

            // Upload and append new photos with compression
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $path = \App\Helpers\ImageHelper::compressAndSave($file, 'stories', 'gallery');
                    $gallery[] = [
                        'type' => 'image',
                        'path' => $path
                    ];
                }
            }

            // Process new YouTube video links
            if ($request->filled('youtube_links')) {
                $links = explode("\n", str_replace("\r", "", $request->youtube_links));
                foreach ($links as $link) {
                    $link = trim($link);
                    if (empty($link)) continue;

                    $youtubeId = $this->getYoutubeId($link);
                    if ($youtubeId) {
                        $gallery[] = [
                            'type' => 'video',
                            'path' => $link,
                            'youtube_id' => $youtubeId,
                            'embed_url' => 'https://www.youtube.com/embed/' . $youtubeId,
                            'thumbnail' => 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg'
                        ];
                    }
                }
            }

            // Auto-assign colors depending on category
            $category = $request->category_id;
            $category_bg = 'bg-gray-100';
            $category_color = 'text-gray-700';

            if (stripos($category, 'spab') !== false) {
                $category_bg = 'bg-orange-100';
                $category_color = 'text-brand-orange';
            } elseif (stripos($category, 'tabur') !== false || stripos($category, 'laut') !== false || stripos($category, 'nelayan') !== false) {
                $category_bg = 'bg-emerald-100';
                $category_color = 'text-emerald-700';
            } elseif (stripos($category, 'smk') !== false) {
                $category_bg = 'bg-blue-100';
                $category_color = 'text-blue-700';
            } elseif (stripos($category, 'hutan') !== false || stripos($category, 'tanaman') !== false || stripos($category, 'pohon') !== false) {
                $category_bg = 'bg-green-100';
                $category_color = 'text-green-700';
            }

            $image_url = $story->image_url;
            if ($request->hasFile('image_url')) {
                // Delete old file
                \App\Helpers\ImageHelper::deleteFile($story->image_url);
                $image_url = \App\Helpers\ImageHelper::compressAndSave($request->file('image_url'), 'stories', 'thumb');
            }

            $story->update(array_merge($validated, [
                'image_url' => $image_url,
                'category_bg' => $category_bg,
                'category_color' => $category_color,
                'gallery' => $gallery
            ]));

            return redirect()->route('admin.stories.index')->with('success', 'Cerita lapangan berhasil diperbarui.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal memperbarui cerita: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui cerita: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $story = Story::findOrFail($id);

        // Delete all gallery files
        $gallery = $story->gallery ?? [];
        foreach ($gallery as $item) {
            $path = is_array($item) ? ($item['path'] ?? '') : $item;
            $type = is_array($item) ? ($item['type'] ?? 'image') : 'image';
            if ($path && $type === 'image') {
                if (str_starts_with($path, '/storage/')) {
                    $relativePath = str_replace('/storage/', '', $path);
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                } elseif (File::exists(public_path($path))) {
                    File::delete(public_path($path));
                }
            }
        }

        if ($story->image_url) {
            if (str_starts_with($story->image_url, '/storage/')) {
                $relativePath = str_replace('/storage/', '', $story->image_url);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            } elseif (File::exists(public_path($story->image_url))) {
                File::delete(public_path($story->image_url));
            }
        }

        $story->delete();
        return redirect()->route('admin.stories.index')->with('success', 'Cerita lapangan berhasil dihapus.');
    }

    /**
     * Upload an image from the rich text editor (e.g. CKEditor).
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file') || $request->hasFile('image') || $request->hasFile('upload')) {
            $file = $request->file('file') ?? $request->file('image') ?? $request->file('upload');
            
            $request->validate([
                'file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
                'upload' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            ]);

            $url = \App\Helpers\ImageHelper::compressAndSave($file, 'stories/content_images', 'editor');

            return response()->json([
                'location' => $url,
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Export all stories to Excel-compatible CSV.
     */
    public function export()
    {
        $headers = [
            'Content-type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=cerita-lapangan-ekspor.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $stories = Story::with('program')->get();

        $columns = [
            'title_id', 'title_en', 'category_id', 'category_en',
            'description_id', 'description_en', 'content_id', 'content_en',
            'impact_number', 'impact_label_id', 'impact_label_en',
            'image_url', 'youtube_links', 'related_links', 'program_code'
        ];

        $callback = function() use($stories, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns, ';');

            foreach ($stories as $story) {
                $youtubeLinks = [];
                $gallery = $story->gallery ?? [];
                foreach ($gallery as $item) {
                    if (is_array($item) && ($item['type'] ?? '') === 'video' && isset($item['path'])) {
                        $youtubeLinks[] = $item['path'];
                    }
                }
                
                $row = [
                    $story->title_id,
                    $story->title_en,
                    $story->category_id,
                    $story->category_en,
                    $story->description_id,
                    $story->description_en,
                    $story->content_id,
                    $story->content_en,
                    $story->impact_number,
                    $story->impact_label_id,
                    $story->impact_label_en,
                    $story->image_url,
                    implode("\n", $youtubeLinks),
                    $story->related_links,
                    $story->program ? $story->program->code : ''
                ];

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download the CSV import template.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=template-cerita-lapangan.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = [
            'title_id', 'title_en', 'category_id', 'category_en',
            'description_id', 'description_en', 'content_id', 'content_en',
            'impact_number', 'impact_label_id', 'impact_label_en',
            'image_url', 'youtube_links', 'related_links', 'program_code'
        ];

        $sampleRow = [
            'Menanam Harapan, Menjaga Bumi',
            'Planting Hope, Saving the Planet',
            'Hutan Anak Negeri',
            'Hutan Anak Negeri',
            'Gerakan menanam pohon untuk kelestarian lingkungan dan lanskap yang lestari.',
            'Tree planting movement for environmental preservation and sustainable landscapes.',
            '<p>Tulis cerita artikel lengkap di sini dengan format HTML jika dibutuhkan.</p>',
            '<p>Write full English article content here with HTML tags if needed.</p>',
            '5.000+',
            'Bibit Mangrove Ditanam',
            'Mangrove Seedlings Planted',
            'https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?w=600',
            "https://www.youtube.com/watch?v=dQw4w9WgXcQ\nhttps://youtu.be/zpOULjyy-n8",
            'belajar-hari-ini-sukses-esok-hari',
            'insert-program-code-here-or-leave-blank'
        ];

        $callback = function() use($columns, $sampleRow) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';');
            fputcsv($file, $sampleRow, ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import stories from an uploaded Excel-compatible CSV.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:4096'
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Auto-detect delimiter (comma vs semicolon)
        $firstLine = fgets($handle);
        $delimiter = (str_contains($firstLine, ';')) ? ';' : ',';
        rewind($handle);
        
        // Read BOM if present
        $bom = fgets($handle, 4);
        if ($bom !== chr(0xEF) . chr(0xBB) . chr(0xBF)) {
            rewind($handle);
        }

        $headers = fgetcsv($handle, 0, $delimiter);
        if (!$headers) {
            fclose($handle);
            return redirect()->back()->with('error', 'File CSV kosong atau tidak valid.');
        }

        // Clean headers
        $headers = array_map(function($h) {
            return trim(str_replace(["\xEF\xBB\xBF", '"', "'"], '', $h));
        }, $headers);

        $importedCount = 0;
        $updatedCount = 0;

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            if (count($row) < count($headers)) {
                $row = array_pad($row, count($headers), '');
            }
            
            $data = array_combine($headers, array_slice($row, 0, count($headers)));
            
            if (empty(trim($data['title_id'] ?? ''))) {
                continue; // Skip empty rows
            }

            foreach ($data as $key => $val) {
                $data[$key] = trim($val);
            }

            // Resolve program_id by program_code
            $programId = null;
            if (!empty($data['program_code'])) {
                $program = \App\Models\Program::where('code', $data['program_code'])->first();
                if ($program) {
                    $programId = $program->id;
                }
            }

            // Parse youtube links into gallery JSON array
            $gallery = [];
            if (!empty($data['youtube_links'])) {
                $links = explode("\n", str_replace("\r", "", $data['youtube_links']));
                foreach ($links as $link) {
                    $link = trim($link);
                    if (empty($link)) continue;

                    $youtubeId = $this->getYoutubeId($link);
                    if ($youtubeId) {
                        $gallery[] = [
                            'type' => 'video',
                            'path' => $link,
                            'youtube_id' => $youtubeId,
                            'embed_url' => 'https://www.youtube.com/embed/' . $youtubeId,
                            'thumbnail' => 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg'
                        ];
                    }
                }
            }

            // Auto-assign colors depending on category
            $category = $data['category_id'] ?? 'Umum';
            $category_bg = 'bg-gray-100';
            $category_color = 'text-gray-700';

            if (stripos($category, 'spab') !== false) {
                $category_bg = 'bg-orange-100';
                $category_color = 'text-brand-orange';
            } elseif (stripos($category, 'tabur') !== false || stripos($category, 'laut') !== false || stripos($category, 'nelayan') !== false) {
                $category_bg = 'bg-emerald-100';
                $category_color = 'text-emerald-700';
            } elseif (stripos($category, 'smk') !== false) {
                $category_bg = 'bg-blue-100';
                $category_color = 'text-blue-700';
            } elseif (stripos($category, 'hutan') !== false || stripos($category, 'tanaman') !== false || stripos($category, 'pohon') !== false) {
                $category_bg = 'bg-green-100';
                $category_color = 'text-green-700';
            }

            // Generate slug from title_id
            $slug = \Illuminate\Support\Str::slug($data['title_id']);
            
            $existingStory = Story::where('slug', $slug)->first();

            $storyData = [
                'title_id' => $data['title_id'],
                'title_en' => $data['title_en'] ?? $data['title_id'],
                'category_id' => $data['category_id'] ?? 'Umum',
                'category_en' => $data['category_en'] ?? ($data['category_id'] ?? 'General'),
                'category_bg' => $category_bg,
                'category_color' => $category_color,
                'description_id' => $data['description_id'] ?? '',
                'description_en' => $data['description_en'] ?? '',
                'content_id' => $data['content_id'] ?? '',
                'content_en' => $data['content_en'] ?? '',
                'impact_number' => $data['impact_number'] ?? null,
                'impact_label_id' => $data['impact_label_id'] ?? null,
                'impact_label_en' => $data['impact_label_en'] ?? null,
                'image_url' => $data['image_url'] ?? 'https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?w=600',
                'gallery' => $gallery,
                'related_links' => $data['related_links'] ?? null,
                'program_id' => $programId,
                'link' => '#',
                'slug' => $slug
            ];

            if ($existingStory) {
                $existingStory->update($storyData);
                $updatedCount++;
            } else {
                Story::create($storyData);
                $importedCount++;
            }
        }

        fclose($handle);

        $msg = "Impor selesai. {$importedCount} cerita baru berhasil ditambahkan";
        if ($updatedCount > 0) {
            $msg .= ", {$updatedCount} cerita berhasil diperbarui.";
        } else {
            $msg .= ".";
        }

        return redirect()->route('admin.stories.index')->with('success', $msg);
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

    /**
     * Custom Indonesian validation messages for stories.
     */
    private function validationMessages(): array
    {
        return [
            'title_id.required' => 'Judul artikel (Bahasa Indonesia) wajib diisi.',
            'title_en.required' => 'Judul artikel (Bahasa Inggris) wajib diisi.',
            'category_id.required' => 'Kategori (Bahasa Indonesia) wajib dipilih atau diisi.',
            'category_en.required' => 'Kategori (Bahasa Inggris) wajib dipilih atau diisi.',
            'description_id.required' => 'Ringkasan deskripsi (Bahasa Indonesia) wajib diisi.',
            'description_en.required' => 'Ringkasan deskripsi (Bahasa Inggris) wajib diisi.',
            'content_id.required' => 'Isi lengkap artikel (Bahasa Indonesia) wajib diisi.',
            'content_en.required' => 'Isi lengkap artikel (Bahasa Inggris) wajib diisi.',
            'image_url.required' => 'Foto utama (thumbnail) artikel wajib diunggah.',
            'image_url.image' => 'Berkas foto utama harus berupa file gambar.',
            'image_url.mimes' => 'Format foto utama harus JPG, JPEG, PNG, WEBP, atau SVG.',
            'image_url.max' => 'Ukuran foto utama maksimal 4 MB (4096 KB).',
            'image_url.uploaded' => 'Gagal mengunggah foto utama. Ukuran berkas kemungkinan melebihi batas server.',
            'gallery.array' => 'Data galeri foto harus berupa daftar file.',
            'gallery.*.image' => 'Setiap berkas galeri yang dipilih harus berupa file gambar.',
            'gallery.*.mimes' => 'Format setiap foto galeri harus JPG, JPEG, PNG, WEBP, atau SVG.',
            'gallery.*.max' => 'Ukuran setiap foto galeri maksimal 4 MB (4096 KB).',
            'gallery.*.uploaded' => 'Gagal mengunggah salah satu foto galeri karena melebihi batas kapasitas upload.',
            'program_id.exists' => 'Program yang dipilih tidak ditemukan dalam sistem database.',
        ];
    }
}

