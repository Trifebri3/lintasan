@extends('admin.layout.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.hero-images.index') }}" class="text-xs text-gray-500 hover:text-brand-green flex items-center gap-1.5 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Slide
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900 leading-tight mt-3">Edit Slide Hero</h1>
        <p class="text-xs text-gray-500 mt-1">Perbarui file gambar, slogan, dan prioritas urutan slideshow</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.hero-images.update', $slide->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <!-- Current Image Preview -->
            <div>
                <label class="block font-bold text-gray-400 uppercase mb-2">Pratinjau Gambar Saat Ini</label>
                <div class="w-full h-48 sm:h-64 rounded-xl bg-cover bg-center border border-gray-200 mb-3 shadow-inner" style="background-image: url('{{ $slide->image_path }}');"></div>
                
                <label for="image" class="block font-bold text-gray-700 uppercase mb-2">Ganti File Gambar (Kosongkan jika tidak ingin mengubah)</label>
                <input type="file" id="image" name="image" class="w-full border border-gray-200 rounded-lg p-2.5 outline-none focus:border-brand-green">
                @error('image') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- ID captions -->
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-150 space-y-4">
                <h3 class="font-bold text-gray-700 text-xs uppercase flex items-center gap-1.5">
                    <span class="bg-red-50 text-red-600 text-[9px] px-1.5 py-0.5 rounded font-extrabold border border-red-100">ID</span> Slogan (Bahasa Indonesia)
                </h3>
                
                <div>
                    <label for="title_id" class="block font-bold text-gray-600 mb-2">Judul Utama (Title)</label>
                    <input type="text" id="title_id" name="title_id" required value="{{ old('title_id', $slide->title_id) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green outline-none font-extrabold">
                    @error('title_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="subtitle_id" class="block font-bold text-gray-600 mb-2">Deskripsi Sub-slogan (Subtitle)</label>
                    <textarea id="subtitle_id" name="subtitle_id" rows="3" class="hero-editor w-full border border-gray-200 rounded-lg p-3 focus:border-brand-green outline-none">{{ old('subtitle_id', $slide->subtitle_id) }}</textarea>
                    @error('subtitle_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- EN captions -->
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-150 space-y-4">
                <h3 class="font-bold text-gray-700 text-xs uppercase flex items-center gap-1.5">
                    <span class="bg-blue-50 text-blue-600 text-[9px] px-1.5 py-0.5 rounded font-extrabold border border-blue-100">EN</span> Slogan (English Translation)
                </h3>

                <div>
                    <label for="title_en" class="block font-bold text-gray-600 mb-2">Judul Utama (Title)</label>
                    <input type="text" id="title_en" name="title_en" required value="{{ old('title_en', $slide->title_en) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green outline-none font-extrabold">
                    @error('title_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="subtitle_en" class="block font-bold text-gray-600 mb-2">Deskripsi Sub-slogan (Subtitle)</label>
                    <textarea id="subtitle_en" name="subtitle_en" rows="3" class="hero-editor w-full border border-gray-200 rounded-lg p-3 focus:border-brand-green outline-none">{{ old('subtitle_en', $slide->subtitle_en) }}</textarea>
                    @error('subtitle_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="sort_order" class="block font-bold text-gray-700 uppercase mb-2">Urutan Tampilan</label>
                    <input type="number" id="sort_order" name="sort_order" required value="{{ old('sort_order', $slide->sort_order) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green outline-none font-bold">
                    @error('sort_order') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="is_active" class="block font-bold text-gray-700 uppercase mb-2">Status Visibilitas</label>
                    <select id="is_active" name="is_active" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green outline-none font-bold">
                        <option value="1" {{ $slide->is_active ? 'selected' : '' }}>Aktif (Tampilkan di Beranda)</option>
                        <option value="0" {{ !$slide->is_active ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="button_link" class="block font-bold text-gray-700 uppercase mb-2">Custom Link Tombol "Lihat Dampak" (Opsional)</label>
                <input type="text" id="button_link" name="button_link" value="{{ old('button_link', $slide->button_link) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green outline-none" placeholder="Contoh: /donasi atau https://example.com (Kosongkan untuk link default /cerita-dampak)">
                @error('button_link') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.hero-images.index') }}" class="bg-white border border-gray-200 hover:border-gray-300 text-gray-600 font-bold px-4 py-2.5 rounded transition">Batal</a>
                <button type="submit" class="bg-brand-green hover:bg-brand-darkgreen text-white font-bold px-6 py-2.5 rounded shadow transition flex items-center gap-1">
                    <i class="fas fa-save"></i> Perbarui Slide
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '.hero-editor',
            height: 220,
            menubar: 'edit insert format help',
            plugins: 'advlist autolink lists link charmap preview searchreplace code table wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            content_style: 'body { font-family: "Instrument Sans", sans-serif; font-size: 13px; line-height: 1.6; color: #374151; }',
            branding: false,
            promotion: false,
            setup: function(editor) {
                editor.on('change keyup', function() {
                    editor.save();
                });
            }
        });
    });
</script>
@endsection
