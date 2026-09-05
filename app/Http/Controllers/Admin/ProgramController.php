<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('admin.program.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.program.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
            'color_class' => 'required|string|max:50',
            'text_color' => 'required|string|max:50',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ], $this->validationMessages(true));

        try {
            $image_url = '';
            if ($request->hasFile('image_url')) {
                $image_url = \App\Helpers\ImageHelper::compressAndSave($request->file('image_url'), 'programs', $request->title);
            }

            Program::create(array_merge($validated, [
                'image_url' => $image_url,
                'link' => '#'
            ]));

            return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menambahkan program: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan program: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.program.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
            'color_class' => 'required|string|max:50',
            'text_color' => 'required|string|max:50',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
        ], $this->validationMessages(false));

        try {
            $image_url = $program->image_url;
            if ($request->hasFile('image_url')) {
                // Delete old file
                \App\Helpers\ImageHelper::deleteFile($program->image_url);
                $image_url = \App\Helpers\ImageHelper::compressAndSave($request->file('image_url'), 'programs', $request->title);
            }

            $program->update(array_merge($validated, [
                'image_url' => $image_url
            ]));

            return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal memperbarui program: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui program: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        
        \App\Helpers\ImageHelper::deleteFile($program->image_url);

        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }

    /**
     * Custom Indonesian validation messages for programs.
     */
    private function validationMessages(bool $isCreate = true): array
    {
        return [
            'title.required' => 'Nama program wajib diisi.',
            'description.required' => 'Deskripsi program wajib diisi.',
            'icon.required' => 'Simbol ikon program wajib dipilih.',
            'color_class.required' => 'Warna latar program wajib diisi.',
            'text_color.required' => 'Warna teks program wajib diisi.',
            'image_url.required' => 'Gambar utama program wajib diunggah.',
            'image_url.image' => 'Berkas gambar program harus berupa file gambar.',
            'image_url.mimes' => 'Format gambar program harus JPG, JPEG, PNG, WEBP, GIF, atau SVG.',
            'image_url.max' => 'Ukuran gambar program tidak boleh melebihi 4 MB (4096 KB).',
            'image_url.uploaded' => 'Gagal mengunggah gambar program. Ukuran file kemungkinan melebihi batas server.',
        ];
    }
}
