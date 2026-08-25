<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    /**
     * Display volunteer sign-up page and showcase registered active volunteers.
     */
    public function index()
    {
        $volunteers = Volunteer::where('status', 'aktif')->latest()->get();
        return view('public.relawan.index', compact('volunteers'));
    }

    /**
     * Save volunteer registration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'bio' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photo_path = null;
        if ($request->hasFile('photo')) {
            $photo_path = \App\Helpers\ImageHelper::compressAndSave($request->file('photo'), 'volunteers', $request->name);
        }

        // Default registered via web are set to status 'pending'
        Volunteer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'motivation' => $validated['bio'],
            'bio' => $validated['bio'],
            'photo_path' => $photo_path,
            'role' => 'Relawan Terdaftar',
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Pendaftaran relawan Anda berhasil dikirim dan sedang kami review.');
    }
}
