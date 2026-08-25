<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * Display a listing of collaborative partners.
     */
    public function index()
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('admin.mitra.index', compact('partners'));
    }

    /**
     * Show form to create new partner.
     */
    public function create()
    {
        return view('admin.mitra.create');
    }

    /**
     * Save new partner including uploaded logo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_icon' => 'nullable|string|max:100',
            'logo_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'required|integer',
        ], [
            'name.required' => 'Nama instansi/lembaga wajib diisi.',
            'logo_path.required' => 'File logo wajib diunggah.',
            'logo_path.image' => 'File logo harus berupa gambar.',
            'logo_path.mimes' => 'Format file logo harus berupa jpeg, png, jpg, gif, atau svg.',
            'logo_path.max' => 'Ukuran file logo tidak boleh melebihi 2MB (2048 KB).',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
            'sort_order.integer' => 'Urutan tampil harus berupa angka.',
        ]);

        $logo_path = null;
        if ($request->hasFile('logo_path')) {
            $logo_path = \App\Helpers\ImageHelper::compressAndSave($request->file('logo_path'), 'partners', $request->name);
        }

        Partner::create([
            'name' => $request->name,
            'logo_icon' => $request->logo_icon ?? 'fa-handshake',
            'logo_path' => $logo_path,
            'url' => $request->url,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    /**
     * Show form to edit partner.
     */
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.mitra.edit', compact('partner'));
    }

    /**
     * Update partner details and swap logo files.
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo_icon' => 'nullable|string|max:100',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'required|integer',
        ], [
            'name.required' => 'Nama instansi/lembaga wajib diisi.',
            'logo_path.image' => 'File logo harus berupa gambar.',
            'logo_path.mimes' => 'Format file logo harus berupa jpeg, png, jpg, gif, atau svg.',
            'logo_path.max' => 'Ukuran file logo tidak boleh melebihi 2MB (2048 KB).',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
            'sort_order.integer' => 'Urutan tampil harus berupa angka.',
        ]);

        $logo_path = $partner->logo_path;
        if ($request->hasFile('logo_path')) {
            // Delete old file
            if ($partner->logo_path) {
                if (str_starts_with($partner->logo_path, '/storage/')) {
                    $relativePath = str_replace('/storage/', '', $partner->logo_path);
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                } elseif (File::exists(public_path($partner->logo_path))) {
                    File::delete(public_path($partner->logo_path));
                }
            }

            $logo_path = \App\Helpers\ImageHelper::compressAndSave($request->file('logo_path'), 'partners', $request->name);
        }

        $partner->update([
            'name' => $request->name,
            'logo_icon' => $request->logo_icon ?? 'fa-handshake',
            'logo_path' => $logo_path,
            'url' => $request->url,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    /**
     * Delete partner and remove their logo file.
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        
        if ($partner->logo_path) {
            if (str_starts_with($partner->logo_path, '/storage/')) {
                $relativePath = str_replace('/storage/', '', $partner->logo_path);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            } elseif (File::exists(public_path($partner->logo_path))) {
                File::delete(public_path($partner->logo_path));
            }
        }

        $partner->delete();
        
        return redirect()->route('admin.partners.index')->with('success', 'Mitra berhasil dihapus.');
    }
}
