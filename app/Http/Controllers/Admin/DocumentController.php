<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents in admin.
     */
    public function index(Request $request)
    {
        $query = Document::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Year filter
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Sort
        $documents = $query->orderBy('sort_order', 'asc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(12)
                           ->withQueryString();

        // Summary statistics
        $stats = [
            'total' => Document::count(),
            'published' => Document::where('is_published', true)->count(),
            'annual_reports' => Document::where('category', 'Annual Report')->orWhere('category', 'Laporan Tahunan')->count(),
            'total_downloads' => Document::sum('downloads_count'),
        ];

        // Unique categories & years for filter dropdowns
        $categories = Document::distinct()->pluck('category')->filter()->values();
        $years = Document::distinct()->pluck('year')->filter()->sortDesc()->values();

        return view('admin.documents.index', compact('documents', 'stats', 'categories', 'years'));
    }

    /**
     * Show form to upload new document.
     */
    public function create()
    {
        $currentYear = date('Y');
        $years = range($currentYear + 1, 2020);
        $categories = [
            'Annual Report',
            'Laporan Tahunan',
            'Laporan Keuangan',
            'Panduan & Modul',
            'Riset & Publikasi',
            'Dokumen Kebijakan',
            'Lainnya',
        ];

        return view('admin.documents.create', compact('currentYear', 'years', 'categories'));
    }

    /**
     * Store uploaded document and process auto cover.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'year' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'document_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:51200', // max 50MB
            'custom_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'auto_cover_base64' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'category.required' => 'Kategori dokumen wajib dipilih.',
            'document_file.required' => 'Berkas dokumen (PDF / Word) wajib diunggah.',
            'document_file.mimes' => 'Format berkas dokumen harus berupa PDF, Word (.doc, .docx), Excel (.xls, .xlsx), atau PowerPoint (.ppt, .pptx).',
            'document_file.max' => 'Ukuran berkas dokumen tidak boleh melebihi 50 MB.',
            'custom_cover.image' => 'Cover kustom harus berupa file gambar.',
            'custom_cover.max' => 'Ukuran cover kustom tidak boleh melebihi 5 MB.',
        ]);

        try {
            $file = $request->file('document_file');
            $originalName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension() ?: 'pdf');
            $fileSize = $file->getSize();

            // Store document file in storage/public/documents/files
            $cleanTitle = Str::slug($request->title);
            $fileNameToSave = time() . '_' . $cleanTitle . '_' . Str::random(6) . '.' . $extension;
            $disk = Storage::disk('public');
            
            // Ensure directories exist
            if (!file_exists($disk->path('documents/files'))) {
                @mkdir($disk->path('documents/files'), 0755, true);
            }
            if (!file_exists($disk->path('documents/covers'))) {
                @mkdir($disk->path('documents/covers'), 0755, true);
            }

            $diskPath = $file->storeAs('documents/files', $fileNameToSave, 'public');
            $filePath = '/storage/' . $diskPath;

            // Handle Cover: Priority: 1. Custom Upload, 2. Auto-generated Base64 from Page 1, 3. Docx zip extraction
            $coverPath = null;

            if ($request->hasFile('custom_cover')) {
                // Admin manually chose a custom cover image
                $coverPath = ImageHelper::compressAndSave($request->file('custom_cover'), 'documents/covers', $request->title);
            } elseif ($request->filled('auto_cover_base64')) {
                // Auto-generated cover from Page 1 (extracted on client side seamlessly)
                $coverPath = $this->saveBase64Cover($request->input('auto_cover_base64'), $request->title);
            }

            // Fallback for DOCX if no cover yet: check if docx has embedded image in word/media/
            if (empty($coverPath) && in_array($extension, ['docx'])) {
                $coverPath = $this->extractCoverFromDocx($disk->path($diskPath), $request->title);
            }

            $isPublished = $request->has('is_published') ? (bool) $request->is_published : true;
            $publishedAt = $request->filled('published_at') ? $request->published_at : now()->toDateString();

            $document = Document::create([
                'title' => $request->title,
                'category' => $request->category,
                'year' => $request->year,
                'description' => $request->description,
                'file_path' => $filePath,
                'file_name' => $originalName,
                'file_type' => $extension,
                'file_size' => $fileSize,
                'cover_path' => $coverPath,
                'is_published' => $isPublished,
                'published_at' => $publishedAt,
                'sort_order' => 0,
            ]);

            return redirect()->route('admin.documents.index')
                             ->with('success', 'Dokumen "' . $document->title . '" berhasil diunggah dengan cover otomatis dari halaman pertama!');
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan dokumen: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat memproses unggahan dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Show form to edit document.
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $currentYear = date('Y');
        $years = range($currentYear + 1, 2020);
        $categories = [
            'Annual Report',
            'Laporan Tahunan',
            'Laporan Keuangan',
            'Panduan & Modul',
            'Riset & Publikasi',
            'Dokumen Kebijakan',
            'Lainnya',
        ];

        return view('admin.documents.edit', compact('document', 'currentYear', 'years', 'categories'));
    }

    /**
     * Update existing document details or replace file/cover.
     */
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'year' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:51200',
            'custom_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'auto_cover_base64' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        try {
            $dataToUpdate = [
                'title' => $request->title,
                'category' => $request->category,
                'year' => $request->year,
                'description' => $request->description,
                'is_published' => $request->has('is_published') ? (bool) $request->is_published : false,
                'published_at' => $request->filled('published_at') ? $request->published_at : $document->published_at,
            ];

            // If new file is uploaded
            if ($request->hasFile('document_file')) {
                // Delete old file if exists
                $this->deletePhysicalFile($document->file_path);

                $file = $request->file('document_file');
                $originalName = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension() ?: 'pdf');
                $fileSize = $file->getSize();

                $cleanTitle = Str::slug($request->title);
                $fileNameToSave = time() . '_' . $cleanTitle . '_' . Str::random(6) . '.' . $extension;
                $diskPath = $file->storeAs('documents/files', $fileNameToSave, 'public');

                $dataToUpdate['file_path'] = '/storage/' . $diskPath;
                $dataToUpdate['file_name'] = $originalName;
                $dataToUpdate['file_type'] = $extension;
                $dataToUpdate['file_size'] = $fileSize;

                // Handle auto cover if extracted
                if ($request->filled('auto_cover_base64')) {
                    $this->deletePhysicalFile($document->cover_path);
                    $dataToUpdate['cover_path'] = $this->saveBase64Cover($request->input('auto_cover_base64'), $request->title);
                }
            }

            // If custom cover is explicitly provided
            if ($request->hasFile('custom_cover')) {
                $this->deletePhysicalFile($document->cover_path);
                $dataToUpdate['cover_path'] = ImageHelper::compressAndSave($request->file('custom_cover'), 'documents/covers', $request->title);
            } elseif ($request->filled('auto_cover_base64') && !isset($dataToUpdate['cover_path'])) {
                // Case where file didn't change, but cover was re-extracted or selected
                $this->deletePhysicalFile($document->cover_path);
                $dataToUpdate['cover_path'] = $this->saveBase64Cover($request->input('auto_cover_base64'), $request->title);
            }

            $document->update($dataToUpdate);

            return redirect()->route('admin.documents.index')
                             ->with('success', 'Dokumen "' . $document->title . '" berhasil diperbarui!');
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui dokumen: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat memperbarui dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Delete document and physical files from storage.
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        try {
            // Delete files from storage
            $this->deletePhysicalFile($document->file_path);
            $this->deletePhysicalFile($document->cover_path);

            $title = $document->title;
            $document->delete();

            return redirect()->route('admin.documents.index')
                             ->with('success', 'Dokumen "' . $title . '" berhasil dihapus beserta berkasnya.');
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus dokumen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Quick toggle publish status.
     */
    public function togglePublish($id)
    {
        $document = Document::findOrFail($id);
        $document->is_published = !$document->is_published;
        $document->save();

        $statusText = $document->is_published ? 'dipublikasikan' : 'diarsipkan (draft)';
        return redirect()->back()->with('success', 'Status dokumen "' . $document->title . '" berhasil diubah menjadi ' . $statusText . '.');
    }

    /**
     * Helper to save base64 encoded cover image to disk.
     */
    protected function saveBase64Cover(string $base64String, string $title): ?string
    {
        try {
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
                $ext = strtolower($matches[1]);
                $base64Data = substr($base64String, strpos($base64String, ',') + 1);
            } else {
                $ext = 'jpg';
                $base64Data = $base64String;
            }

            $data = base64_decode($base64Data);
            if ($data === false) {
                return null;
            }

            $cleanTitle = Str::slug($title);
            $filename = 'cover_' . time() . '_' . $cleanTitle . '_' . Str::random(5) . '.' . ($ext === 'png' ? 'png' : 'jpg');
            
            $disk = Storage::disk('public');
            $disk->put('documents/covers/' . $filename, $data);

            return '/storage/documents/covers/' . $filename;
        } catch (\Throwable $e) {
            Log::error('Error saving base64 cover: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Helper to extract embedded cover image from docx zip.
     */
    protected function extractCoverFromDocx(string $fullFilePath, string $title): ?string
    {
        if (!class_exists('\ZipArchive') || !file_exists($fullFilePath)) {
            return null;
        }

        try {
            $zip = new \ZipArchive();
            if ($zip->open($fullFilePath) === true) {
                $foundImage = null;
                $foundExt = 'jpg';

                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entryName = $zip->getNameIndex($i);
                    // Match first image in word/media/
                    if (preg_match('/word\/media\/image1\.(jpe?g|png)/i', $entryName, $m)) {
                        $foundImage = $zip->getFromIndex($i);
                        $foundExt = strtolower($m[1]) === 'png' ? 'png' : 'jpg';
                        break;
                    }
                }
                $zip->close();

                if ($foundImage) {
                    $cleanTitle = Str::slug($title);
                    $filename = 'cover_' . time() . '_' . $cleanTitle . '_' . Str::random(5) . '.' . $foundExt;
                    Storage::disk('public')->put('documents/covers/' . $filename, $foundImage);
                    return '/storage/documents/covers/' . $filename;
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Docx cover extraction skipped: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Safely delete physical file on public disk.
     */
    protected function deletePhysicalFile(?string $webPath): void
    {
        if (empty($webPath)) {
            return;
        }

        try {
            // Convert /storage/documents/files/xxx to documents/files/xxx
            $relative = str_replace('/storage/', '', $webPath);
            $disk = Storage::disk('public');
            if ($disk->exists($relative)) {
                $disk->delete($relative);
            }
        } catch (\Throwable $e) {
            Log::warning('Could not delete storage file: ' . $webPath . ' - ' . $e->getMessage());
        }
    }
}
