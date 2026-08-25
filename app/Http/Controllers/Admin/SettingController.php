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
                'value_id' => 'nullable|image|max:3072',
                'value_en' => 'nullable|image|max:3072',
            ]);

            $data = [];
            
            if ($request->hasFile('value_id')) {
                // Delete old file if stored locally
                if (str_starts_with($setting->value_id, '/storage/settings/')) {
                    $oldPath = str_replace('/storage/', '', $setting->value_id);
                    Storage::disk('public')->delete($oldPath);
                }
                $data['value_id'] = \App\Helpers\ImageHelper::compressAndSave($request->file('value_id'), 'settings', 'bg_impact');
            }

            if ($request->hasFile('value_en')) {
                // Delete old file if stored locally
                if (str_starts_with($setting->value_en, '/storage/settings/')) {
                    $oldPath = str_replace('/storage/', '', $setting->value_en);
                    Storage::disk('public')->delete($oldPath);
                }
                $data['value_en'] = \App\Helpers\ImageHelper::compressAndSave($request->file('value_en'), 'settings', 'bg_impact_en');
            }

            if (!empty($data)) {
                $setting->update($data);
            }
        } else {
            $request->validate([
                'value_id' => 'required|string',
                'value_en' => 'required|string',
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
