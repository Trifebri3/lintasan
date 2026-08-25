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
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photo_path = $volunteer->photo_path;
        if ($request->hasFile('photo_path')) {
            // Delete old photo
            if ($volunteer->photo_path) {
                if (str_starts_with($volunteer->photo_path, '/storage/')) {
                    $relativePath = str_replace('/storage/', '', $volunteer->photo_path);
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                } elseif (File::exists(public_path($volunteer->photo_path))) {
                    File::delete(public_path($volunteer->photo_path));
                }
            }

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
    }

    /**
     * Remove the specified volunteer from storage.
     */
    public function destroy($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        
        if ($volunteer->photo_path) {
            if (str_starts_with($volunteer->photo_path, '/storage/')) {
                $relativePath = str_replace('/storage/', '', $volunteer->photo_path);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            } elseif (File::exists(public_path($volunteer->photo_path))) {
                File::delete(public_path($volunteer->photo_path));
            }
        }

        $volunteer->delete();

        return redirect()->route('admin.volunteers.index')->with('success', 'Data pendaftaran relawan berhasil dihapus.');
    }
}
