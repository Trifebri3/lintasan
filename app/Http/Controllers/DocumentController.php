<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    /**
     * Display public listing of documents & publications.
     */
    public function index(Request $request)
    {
        $query = Document::published();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        $activeCategory = $request->query('category', 'all');
        if ($activeCategory !== 'all' && !empty($activeCategory)) {
            $query->where('category', $activeCategory);
        }

        // Year filter
        $activeYear = $request->query('year', 'all');
        if ($activeYear !== 'all' && !empty($activeYear)) {
            $query->where('year', $activeYear);
        }

        $documents = $query->orderBy('sort_order', 'asc')
                           ->orderBy('published_at', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(9)
                           ->withQueryString();

        // Distinct categories with counts
        $categories = Document::published()
            ->select('category')
            ->selectRaw('count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        // Distinct years
        $years = Document::published()
            ->whereNotNull('year')
            ->distinct()
            ->pluck('year')
            ->sortDesc()
            ->values();

        $totalDocuments = Document::published()->count();

        // Featured/Latest Annual Report if any
        $featuredReport = Document::published()
            ->where(function($q) {
                $q->where('category', 'Annual Report')
                  ->orWhere('category', 'Laporan Tahunan');
            })
            ->orderBy('year', 'desc')
            ->orderBy('published_at', 'desc')
            ->first();

        return view('public.documents.index', compact(
            'documents',
            'categories',
            'years',
            'activeCategory',
            'activeYear',
            'totalDocuments',
            'featuredReport'
        ));
    }

    /**
     * Download document file and increment download counter.
     */
    public function download(string $slug)
    {
        $document = Document::published()
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)->orWhere('id', $slug);
            })
            ->firstOrFail();

        // Increment downloads count safely
        $document->increment('downloads_count');

        $relative = str_replace('/storage/', '', $document->file_path);
        $disk = Storage::disk('public');

        if (!$disk->exists($relative)) {
            return redirect()->back()->with('error', 'Berkas dokumen tidak ditemukan di server.');
        }

        $filePath = $disk->path($relative);
        $downloadName = $document->file_name ?: ($document->title . '.' . $document->file_type);

        return response()->download($filePath, $downloadName);
    }

    /**
     * View document inline (PDF viewer)
     */
    public function preview(string $slug)
    {
        $document = Document::published()
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)->orWhere('id', $slug);
            })
            ->firstOrFail();

        $relative = str_replace('/storage/', '', $document->file_path);
        $disk = Storage::disk('public');

        if (!$disk->exists($relative)) {
            abort(404, 'Berkas dokumen tidak ditemukan.');
        }

        $filePath = $disk->path($relative);
        return response()->file($filePath);
    }
}
