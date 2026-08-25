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
        ]);

        $image_url = '';
        if ($request->hasFile('image_url')) {
            $image_url = \App\Helpers\ImageHelper::compressAndSave($request->file('image_url'), 'programs', $request->title);
        }

        Program::create(array_merge($validated, [
            'image_url' => $image_url,
            'link' => '#'
        ]));

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan.');
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
        ]);

        $image_url = $program->image_url;
        if ($request->hasFile('image_url')) {
            // Delete old file
            if ($program->image_url) {
                if (str_starts_with($program->image_url, '/storage/')) {
                    $relativePath = str_replace('/storage/', '', $program->image_url);
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                } elseif (File::exists(public_path($program->image_url))) {
                    File::delete(public_path($program->image_url));
                }
            }

            $image_url = \App\Helpers\ImageHelper::compressAndSave($request->file('image_url'), 'programs', $request->title);
        }

        $program->update(array_merge($validated, [
            'image_url' => $image_url
        ]));

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        
        if ($program->image_url) {
            if (str_starts_with($program->image_url, '/storage/')) {
                $relativePath = str_replace('/storage/', '', $program->image_url);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            } elseif (File::exists(public_path($program->image_url))) {
                File::delete(public_path($program->image_url));
            }
        }

        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
