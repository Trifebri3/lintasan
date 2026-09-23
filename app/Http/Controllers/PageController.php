<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Village;
use App\Models\Setting;
use App\Models\Story;
use App\Models\Gallery;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display Partner Villages (Desa Mitra Lintasan) page with dynamic database records.
     */
    public function desaBinaan()
    {
        $villages = Village::all();
        return view('public.desabinaan.index', compact('villages'));
    }

    /**
     * Display detailed narrative profile and map of a single partner village.
     */
    public function showVillage($slug)
    {
        $village = Village::where('slug', $slug)->firstOrFail();
        $otherVillages = Village::where('id', '!=', $village->id)->limit(3)->get();
        return view('public.desabinaan.show', compact('village', 'otherVillages'));
    }

    /**
     * Display Partners (Mitra) list.
     */
    public function mitra()
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('public.mitra.index', compact('partners'));
    }

    /**
     * Store new partner collaboration application from public form.
     */
    public function storePartnerApplication(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'partnership_type' => 'nullable|string|max:100',
            'address' => 'required|string',
            'proposal' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ], [
            'institution_name.required' => 'Nama instansi / lembaga / perusahaan wajib diisi.',
            'pic_name.required' => 'Nama kontak person / PIC wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid (contoh: kontak@instansi.com).',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'address.required' => 'Alamat instansi / kantor wajib diisi.',
            'proposal.required' => 'Rencana / ide kolaborasi wajib diisi.',
            'logo.image' => 'Berkas logo harus berupa gambar.',
            'logo.mimes' => 'Format file logo harus JPG, JPEG, PNG, WEBP, GIF, atau SVG.',
            'logo.max' => 'Ukuran file logo tidak boleh melebihi 4 MB.',
        ]);

        try {
            $logo_path = null;
            if ($request->hasFile('logo')) {
                $logo_path = \App\Helpers\ImageHelper::compressAndSave($request->file('logo'), 'partners', $request->institution_name);
            }

            \App\Models\PartnerApplication::create([
                'institution_name' => $validated['institution_name'],
                'pic_name' => $validated['pic_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'partnership_type' => $validated['partnership_type'] ?? 'Kolaborasi Umum',
                'address' => $validated['address'],
                'proposal' => $validated['proposal'],
                'logo_path' => $logo_path,
                'status' => 'pending',
            ]);

            return redirect()->back()->with('success', 'Terima kasih! Formulir pengajuan kemitraan berhasil dikirim. Tim kami akan segera meninjau dan menghubungi Anda.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengajukan kemitraan: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memproses pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Display About Us (Tentang Kami) page.
     */
    public function tentangKami()
    {
        $localeCol = session('locale') == 'en' ? 'value_en' : 'value_id';
        $settings = Setting::pluck($localeCol, 'key')->all();
        $organizationValues = \App\Models\OrganizationValue::orderBy('order')->get();
        return view('public.tentangkami.index', compact('settings', 'organizationValues'));
    }

    /**
     * Display Gallery (Galeri & Dokumentasi) page with items from the galleries database.
     */
    public function galeri()
    {
        $galleryItems = Gallery::orderBy('sort_order')->get();
        return view('public.galeri.index', compact('galleryItems'));
    }
}
