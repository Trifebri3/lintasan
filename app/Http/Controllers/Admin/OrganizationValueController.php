<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationValue;

class OrganizationValueController extends Controller
{
    /**
     * Store a newly created organization value in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description' => 'required|string',
            'description_en' => 'nullable|string',
            'icon' => 'required|string|max:50',
            'theme' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ], [
            'title.required' => 'Judul Nilai (Bahasa Indonesia) wajib diisi.',
            'description.required' => 'Deskripsi Nilai (Bahasa Indonesia) wajib diisi.',
            'icon.required' => 'Simbol ikon wajib dipilih.',
        ]);

        $themeMap = [
            'emerald' => ['color' => 'text-emerald-700', 'bg' => 'bg-emerald-50/50', 'border' => 'border-emerald-100/50'],
            'blue' => ['color' => 'text-blue-700', 'bg' => 'bg-blue-50/50', 'border' => 'border-blue-100/50'],
            'amber' => ['color' => 'text-amber-700', 'bg' => 'bg-amber-50/50', 'border' => 'border-amber-100/50'],
            'purple' => ['color' => 'text-purple-700', 'bg' => 'bg-purple-50/50', 'border' => 'border-purple-100/50'],
            'teal' => ['color' => 'text-teal-700', 'bg' => 'bg-teal-50/50', 'border' => 'border-teal-100/50'],
            'rose' => ['color' => 'text-rose-700', 'bg' => 'bg-rose-50/50', 'border' => 'border-rose-100/50'],
        ];

        $theme = $themeMap[$request->input('theme', 'emerald')] ?? $themeMap['emerald'];

        $maxOrder = OrganizationValue::max('order') ?? 0;
        $order = $request->filled('order') ? (int)$request->order : ($maxOrder + 1);

        OrganizationValue::create([
            'title' => $validated['title'],
            'title_en' => $validated['title_en'] ?? $validated['title'],
            'description' => $validated['description'],
            'description_en' => $validated['description_en'] ?? $validated['description'],
            'icon' => $validated['icon'],
            'color_class' => $theme['color'],
            'bg_class' => $theme['bg'],
            'border_class' => $theme['border'],
            'order' => $order,
        ]);

        return redirect()->route('admin.settings.index', ['tab' => 'nilai'])
            ->with('success', "Nilai Lintasan '{$validated['title']}' berhasil ditambahkan.");
    }

    /**
     * Update the specified organization value in storage.
     */
    public function update(Request $request, $id)
    {
        $val = OrganizationValue::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description' => 'required|string',
            'description_en' => 'nullable|string',
            'icon' => 'required|string|max:50',
            'theme' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
        ], [
            'title.required' => 'Judul Nilai (Bahasa Indonesia) wajib diisi.',
            'description.required' => 'Deskripsi Nilai (Bahasa Indonesia) wajib diisi.',
            'icon.required' => 'Simbol ikon wajib dipilih.',
        ]);

        $themeMap = [
            'emerald' => ['color' => 'text-emerald-700', 'bg' => 'bg-emerald-50/50', 'border' => 'border-emerald-100/50'],
            'blue' => ['color' => 'text-blue-700', 'bg' => 'bg-blue-50/50', 'border' => 'border-blue-100/50'],
            'amber' => ['color' => 'text-amber-700', 'bg' => 'bg-amber-50/50', 'border' => 'border-amber-100/50'],
            'purple' => ['color' => 'text-purple-700', 'bg' => 'bg-purple-50/50', 'border' => 'border-purple-100/50'],
            'teal' => ['color' => 'text-teal-700', 'bg' => 'bg-teal-50/50', 'border' => 'border-teal-100/50'],
            'rose' => ['color' => 'text-rose-700', 'bg' => 'bg-rose-50/50', 'border' => 'border-rose-100/50'],
        ];

        $theme = $themeMap[$request->input('theme', 'emerald')] ?? $themeMap['emerald'];

        $val->update([
            'title' => $validated['title'],
            'title_en' => $validated['title_en'] ?? $val->title_en,
            'description' => $validated['description'],
            'description_en' => $validated['description_en'] ?? $val->description_en,
            'icon' => $validated['icon'],
            'color_class' => $theme['color'],
            'bg_class' => $theme['bg'],
            'border_class' => $theme['border'],
            'order' => $request->filled('order') ? (int)$request->order : $val->order,
        ]);

        return redirect()->route('admin.settings.index', ['tab' => 'nilai'])
            ->with('success', "Nilai Lintasan '{$val->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified organization value from storage.
     */
    public function destroy($id)
    {
        $val = OrganizationValue::findOrFail($id);
        $title = $val->title;
        $val->delete();

        return redirect()->route('admin.settings.index', ['tab' => 'nilai'])
            ->with('success', "Nilai Lintasan '{$title}' berhasil dihapus.");
    }
}
