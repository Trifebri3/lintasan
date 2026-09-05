<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VolunteerController extends Controller
{
    /**
     * Display a listing of registered volunteers.
     */
    public function index()
    {
        $volunteers = Volunteer::latest()->get();
        return view('admin.relawan.index', compact('volunteers'));
    }

    /**
     * Show form to manually add a volunteer.
     */
    public function create()
    {
        return view('admin.relawan.create');
    }

    /**
     * Save manually registered volunteer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'role' => 'required|string|max:100',
            'address' => 'required|string',
            'motivation' => 'required|string',
            'bio' => 'nullable|string',
            'status' => 'required|in:pending,aktif',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ], $this->validationMessages());

        try {
            $photo_path = null;
            if ($request->hasFile('photo_path')) {
                $photo_path = \App\Helpers\ImageHelper::compressAndSave($request->file('photo_path'), 'volunteers', $request->name);
            }

            Volunteer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'address' => $request->address,
                'motivation' => $request->motivation,
                'bio' => $request->bio,
                'status' => $request->status,
                'photo_path' => $photo_path,
            ]);

            return redirect()->route('admin.volunteers.index')->with('success', 'Relawan berhasil ditambahkan.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menambahkan relawan: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data relawan: ' . $e->getMessage());
        }
    }

    /**
     * Show form to edit volunteer status/profile.
     */
    public function edit($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        return view('admin.relawan.edit', compact('volunteer'));
    }

    /**
     * Update volunteer profile in database.
     */
    public function update(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'role' => 'required|string|max:100',
            'address' => 'required|string',
            'motivation' => 'required|string',
            'bio' => 'nullable|string',
            'status' => 'required|in:pending,aktif',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ], $this->validationMessages());

        try {
            $photo_path = $volunteer->photo_path;
            if ($request->hasFile('photo_path')) {
                // Delete old photo
                \App\Helpers\ImageHelper::deleteFile($volunteer->photo_path);
                $photo_path = \App\Helpers\ImageHelper::compressAndSave($request->file('photo_path'), 'volunteers', $request->name);
            }

            $volunteer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'address' => $request->address,
                'motivation' => $request->motivation,
                'bio' => $request->bio,
                'status' => $request->status,
                'photo_path' => $photo_path,
            ]);

            return redirect()->route('admin.volunteers.index')->with('success', 'Data relawan berhasil diperbarui.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal memperbarui data relawan: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui relawan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified volunteer from storage.
     */
    public function destroy($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        
        \App\Helpers\ImageHelper::deleteFile($volunteer->photo_path);

        $volunteer->delete();

        return redirect()->route('admin.volunteers.index')->with('success', 'Data pendaftaran relawan berhasil dihapus.');
    }

    /**
     * Custom Indonesian validation messages for volunteers.
     */
    private function validationMessages(): array
    {
        return [
            'name.required' => 'Nama relawan wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid (contoh: nama@domain.com).',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'role.required' => 'Peran / posisi relawan wajib diisi.',
            'address.required' => 'Alamat tinggal relawan wajib diisi.',
            'motivation.required' => 'Motivasi / ide kolaborasi relawan wajib diisi.',
            'status.required' => 'Status relawan wajib dipilih.',
            'status.in' => 'Status relawan harus berupa pending atau aktif.',
            'photo_path.image' => 'Berkas foto profil relawan harus berupa gambar.',
            'photo_path.mimes' => 'Format foto profil harus JPG, JPEG, PNG, WEBP, GIF, atau SVG.',
            'photo_path.max' => 'Ukuran foto profil tidak boleh melebihi 4 MB (4096 KB).',
            'photo_path.uploaded' => 'Gagal mengunggah foto profil. Ukuran file kemungkinan melebihi batas server.',
        ];
    }
}
