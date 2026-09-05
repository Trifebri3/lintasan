<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of page settings.
     */
    public function index()
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

        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
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

        return redirect()->route('admin.settings.index')->with('success', "Konten '{$setting->key}' berhasil diperbarui.");
    }
}
