<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of team & board members.
     */
    public function index(Request $request)
    {
        $query = TeamMember::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('role_id', 'like', "%{$search}%")
                  ->orWhere('role_en', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('sort_order', 'asc')->get();
        $categories = TeamMember::getCategories();

        return view('admin.team.index', compact('members', 'categories'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        $categories = TeamMember::getCategories();
        return view('admin.team.create', compact('categories'));
    }

    /**
     * Store a newly created member in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:pendiri,pembina,pengawas,pengurus,tim',
            'role_id' => 'required|string|max:255',
            'role_en' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'bio_id' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'social_linkedin' => 'nullable|url|max:255',
            'social_email' => 'nullable|email|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama lengkap beserta gelar wajib diisi.',
            'category.required' => 'Kategori struktur organisasi wajib dipilih.',
            'role_id.required' => 'Peran / Jabatan (Indonesia) wajib diisi.',
            'photo.image' => 'Berkas foto harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 4 MB.',
            'social_linkedin.url' => 'Format URL profil LinkedIn tidak valid.',
            'social_email.email' => 'Format alamat email tidak valid.',
        ]);

        try {
            $photo_path = null;
            if ($request->hasFile('photo')) {
                $photo_path = \App\Helpers\ImageHelper::compressAndSave($request->file('photo'), 'team', $request->name);
            }

            TeamMember::create([
                'name' => $request->name,
                'category' => $request->category,
                'role_id' => $request->role_id,
                'role_en' => $request->role_en,
                'photo_path' => $photo_path,
                'bio_id' => $request->bio_id,
                'bio_en' => $request->bio_en,
                'social_linkedin' => $request->social_linkedin,
                'social_email' => $request->social_email,
                'sort_order' => $request->sort_order,
                'is_active' => $request->is_active,
            ]);

            return redirect()->route('admin.people.index')->with('success', 'Profil pengurus/tim berhasil ditambahkan.');
        } catch (\Throwable $e) {
            Log::error('Gagal menambahkan profil pengurus/tim: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the member.
     */
    public function edit($id)
    {
        $member = TeamMember::findOrFail($id);
        $categories = TeamMember::getCategories();
        return view('admin.team.edit', compact('member', 'categories'));
    }

    /**
     * Update the member in database.
     */
    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:pendiri,pembina,pengawas,pengurus,tim',
            'role_id' => 'required|string|max:255',
            'role_en' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'bio_id' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'social_linkedin' => 'nullable|url|max:255',
            'social_email' => 'nullable|email|max:255',
            'sort_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama lengkap beserta gelar wajib diisi.',
            'category.required' => 'Kategori struktur organisasi wajib dipilih.',
            'role_id.required' => 'Peran / Jabatan (Indonesia) wajib diisi.',
            'photo.image' => 'Berkas foto harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 4 MB.',
            'social_linkedin.url' => 'Format URL profil LinkedIn tidak valid.',
            'social_email.email' => 'Format alamat email tidak valid.',
        ]);

        try {
            $photo_path = $member->photo_path;

            if ($request->hasFile('photo')) {
                // Delete old local file if present
                if ($photo_path && !str_starts_with($photo_path, 'http') && File::exists(public_path($photo_path))) {
                    File::delete(public_path($photo_path));
                }
                $photo_path = \App\Helpers\ImageHelper::compressAndSave($request->file('photo'), 'team', $request->name);
            }

            $member->update([
                'name' => $request->name,
                'category' => $request->category,
                'role_id' => $request->role_id,
                'role_en' => $request->role_en,
                'photo_path' => $photo_path,
                'bio_id' => $request->bio_id,
                'bio_en' => $request->bio_en,
                'social_linkedin' => $request->social_linkedin,
                'social_email' => $request->social_email,
                'sort_order' => $request->sort_order,
                'is_active' => $request->is_active,
            ]);

            return redirect()->route('admin.people.index')->with('success', 'Profil figur berhasil diperbarui.');
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui figur: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the member from storage.
     */
    public function destroy($id)
    {
        try {
            $member = TeamMember::findOrFail($id);

            if ($member->photo_path && !str_starts_with($member->photo_path, 'http') && File::exists(public_path($member->photo_path))) {
                File::delete(public_path($member->photo_path));
            }

            $member->delete();

            return redirect()->route('admin.people.index')->with('success', 'Profil figur berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus figur: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}

