<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\OrganizationValue;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of page settings.
     */
    public function index(Request $request)
    {
        // Auto-initialize background photo settings if missing
        Setting::firstOrCreate(
            ['key' => 'bg_photo_impact'],
            [
                'value_id' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'value_en' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'type' => 'image'
            ]
        );
        Setting::firstOrCreate(
            ['key' => 'bg_photo_cta'],
            [
                'value_id' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=1000&q=80',
                'value_en' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=1000&q=80',
                'type' => 'image'
            ]
        );
        Setting::firstOrCreate(
            ['key' => 'title_impact'],
            [
                'value_id' => 'Lintasan Dalam Angka',
                'value_en' => 'Lintasan in Numbers',
                'type' => 'text'
            ]
        );

        $allSettings = Setting::all()->keyBy('key');
        $organizationValues = OrganizationValue::orderBy('order')->get();

        $categories = [
            'profil' => [
                'id' => 'profil',
                'title' => 'Profil & Visi Misi',
                'badge' => 'Tentang Kami',
                'subtitle' => 'Pengaturan teks kutipan profil, visi, misi, dan penutup pada halaman Tentang Kami',
                'icon' => 'fa-building-columns',
                'keys' => ['about_profile', 'about_visi', 'about_misi', 'about_conclusion']
            ],
            'nilai' => [
                'id' => 'nilai',
                'title' => 'Nilai Lintasan',
                'badge' => $organizationValues->count() . ' Nilai',
                'subtitle' => 'Kelola nilai/pilar utama Yayasan LINTASAN dari company profile. Bisa ditambah (+) dan dikurangi (-).',
                'icon' => 'fa-award',
                'keys' => []
            ],
            'banner' => [
                'id' => 'banner',
                'title' => 'Foto Latar & Banner',
                'badge' => 'Visual Beranda & Footer',
                'subtitle' => 'Kelola foto latar belakang seksi statistik dampak dan banner ajakan aksi (CTA)',
                'icon' => 'fa-images',
                'keys' => ['title_impact', 'bg_photo_impact', 'bg_photo_cta']
            ],
            'label' => [
                'id' => 'label',
                'title' => 'Label & Teks Tambahan',
                'badge' => 'UI & Frasa Publik',
                'subtitle' => 'Daftar teks tombol, judul navigasi, dan frasa umum lainnya di situs web',
                'icon' => 'fa-language',
                'keys' => []
            ]
        ];

        // Gather keys belonging to top categories + legacy pillar keys
        $assignedKeys = array_merge(
            $categories['profil']['keys'],
            $categories['nilai']['keys'],
            $categories['banner']['keys'],
            [
                'about_pillar_kolaborasi', 
                'about_pillar_edukasi', 
                'about_pillar_inovasi', 
                'about_pillar_transparansi', 
                'about_pillar_5_title', 
                'about_pillar_5_desc'
            ]
        );

        // Put any remaining settings in the 'label' category
        $otherSettings = Setting::whereNotIn('key', $assignedKeys)->orderBy('key')->get();

        $activeTab = $request->query('tab', 'profil');
        if (!array_key_exists($activeTab, $categories)) {
            $activeTab = 'profil';
        }

        return view('admin.settings.index', compact(
            'allSettings', 
            'categories', 
            'otherSettings', 
            'activeTab',
            'organizationValues'
        ));
    }

    /**
     * Update the specified setting.
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        if ($setting->type === 'image') {
            $request->validate([
                'value_id' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
                'value_en' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            ], [
                'value_id.image' => 'File foto versi Bahasa Indonesia harus berupa gambar yang valid.',
                'value_id.mimes' => 'Format foto versi Bahasa Indonesia harus JPG, JPEG, PNG, WEBP, atau SVG.',
                'value_id.max' => 'Ukuran foto versi Bahasa Indonesia maksimal 4 MB (4096 KB).',
                'value_id.uploaded' => 'Gagal mengunggah foto versi Bahasa Indonesia. Ukuran berkas kemungkinan melebihi batas server.',
                'value_en.image' => 'File foto versi Bahasa Inggris harus berupa gambar yang valid.',
                'value_en.mimes' => 'Format foto versi Bahasa Inggris harus JPG, JPEG, PNG, WEBP, atau SVG.',
                'value_en.max' => 'Ukuran foto versi Bahasa Inggris maksimal 4 MB (4096 KB).',
                'value_en.uploaded' => 'Gagal mengunggah foto versi Bahasa Inggris. Ukuran berkas kemungkinan melebihi batas server.',
            ]);

            try {
                $data = [];
                
                if ($request->hasFile('value_id')) {
                    \App\Helpers\ImageHelper::deleteFile($setting->value_id);
                    $data['value_id'] = \App\Helpers\ImageHelper::compressAndSave($request->file('value_id'), 'settings', 'bg_impact');
                }

                if ($request->hasFile('value_en')) {
                    \App\Helpers\ImageHelper::deleteFile($setting->value_en);
                    $data['value_en'] = \App\Helpers\ImageHelper::compressAndSave($request->file('value_en'), 'settings', 'bg_impact_en');
                }

                if (!empty($data)) {
                    $setting->update($data);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Gagal memperbarui pengaturan gambar: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan gambar pengaturan: ' . $e->getMessage());
            }
        } else {
            $request->validate([
                'value_id' => 'required|string',
                'value_en' => 'required|string',
            ], [
                'value_id.required' => 'Nilai pengaturan (Bahasa Indonesia) wajib diisi.',
                'value_en.required' => 'Nilai pengaturan (Bahasa Inggris) wajib diisi.',
            ]);

            $setting->update([
                'value_id' => $request->value_id,
                'value_en' => $request->value_en,
            ]);
        }

        \Illuminate\Support\Facades\Cache::forget('site_social_settings');

        $activeTab = $request->input('active_tab', '');
        $redirectUrl = route('admin.settings.index');
        if ($activeTab) {
            $redirectUrl .= '?tab=' . urlencode($activeTab);
        }

        return redirect($redirectUrl)->with('success', "Konten '{$setting->key}' berhasil diperbarui.");
    }
}
