@extends('admin.layout.app')

@section('content')
<div class="space-y-6 max-w-2xl">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Edit Program</h1>
            <p class="text-xs text-gray-500 mt-1">Ubah data program unggulan Yayasan LINTASAN.</p>
        </div>
        <a href="{{ route('admin.programs.index') }}" class="text-gray-500 text-xs font-semibold hover:text-brand-green transition flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Program</label>
                <input type="text" id="title" name="title" required value="{{ old('title', $program->title) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Sekolah Aman Bencana">
                @error('title') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                @if($program->image_url)
                    <div class="mb-3">
                        <span class="block text-xs font-bold text-gray-700 uppercase mb-2">Gambar Saat Ini</span>
                        <div class="w-48 h-32 rounded-lg bg-gray-200 bg-cover bg-center border border-gray-100 shadow-sm" style="background-image: url('{{ $program->image_url }}');"></div>
                    </div>
                @endif
                <label for="image_url" class="block text-xs font-bold text-gray-700 uppercase mb-2">Ganti Gambar Program (Kosongkan jika tidak diganti)</label>
                <input type="file" id="image_url" name="image_url" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                @error('image_url') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Icon Dropdown & Preview -->
                <div>
                    <label for="icon" class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih Simbol Ikon Program</label>
                    <div class="flex items-center gap-3">
                        <select id="icon" name="icon" onchange="document.getElementById('icon-preview').className = 'fas ' + this.value" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white">
                            @php
                                $currentIcon = old('icon', $program->icon);
                            @endphp
                            <option value="fa-shield-halved" {{ $currentIcon == 'fa-shield-halved' ? 'selected' : '' }}>Perisai (Keamanan & Kebencanaan)</option>
                            <option value="fa-fish" {{ $currentIcon == 'fa-fish' ? 'selected' : '' }}>Ikan (Kelautan & Nelayan)</option>
                            <option value="fa-laptop-code" {{ $currentIcon == 'fa-laptop-code' ? 'selected' : '' }}>Laptop/Komputer (Pendidikan & Vokasi)</option>
                            <option value="fa-tree" {{ $currentIcon == 'fa-tree' ? 'selected' : '' }}>Pohon (Hutan & Lingkungan)</option>
                            <option value="fa-heart-pulse" {{ $currentIcon == 'fa-heart-pulse' ? 'selected' : '' }}>Detak Jantung (Kesehatan & Sosial)</option>
                            <option value="fa-book-open" {{ $currentIcon == 'fa-book-open' ? 'selected' : '' }}>Buku Terbuka (Pendidikan & Belajar)</option>
                            <option value="fa-handshake" {{ $currentIcon == 'fa-handshake' ? 'selected' : '' }}>Jabat Tangan (Kemitraan & Kolaborasi)</option>
                            <option value="fa-users" {{ $currentIcon == 'fa-users' ? 'selected' : '' }}>Orang Banyak (Komunitas & Relawan)</option>
                            <option value="fa-seedling" {{ $currentIcon == 'fa-seedling' ? 'selected' : '' }}>Tunas Tanaman (Pertanian & Pemberdayaan)</option>
                            <option value="fa-globe" {{ $currentIcon == 'fa-globe' ? 'selected' : '' }}>Bola Dunia (Sosial & Umum)</option>
                        </select>
                        <div class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center bg-gray-50 text-gray-700 text-sm shrink-0">
                            <i id="icon-preview" class="fas {{ $currentIcon }}"></i>
                        </div>
                    </div>
                    @error('icon') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Theme Color Dropdown & Preview -->
                <div>
                    <label for="color_theme" class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih Warna Tema Program</label>
                    <div class="flex items-center gap-3">
                        @php
                            $currentColorClass = old('color_class', $program->color_class);
                        @endphp
                        <select id="color_theme" onchange="updateColorTheme()" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white">
                            <option value="orange" data-bg="bg-brand-orange" data-text="text-brand-orange" {{ $currentColorClass == 'bg-brand-orange' ? 'selected' : '' }}>Oranye (Siaga Bencana)</option>
                            <option value="emerald" data-bg="bg-emerald-600" data-text="text-emerald-700" {{ $currentColorClass == 'bg-emerald-600' ? 'selected' : '' }}>Hijau Toska (Nelayan/Kelautan)</option>
                            <option value="blue" data-bg="bg-blue-600" data-text="text-blue-700" {{ $currentColorClass == 'bg-blue-600' ? 'selected' : '' }}>Biru (Pendidikan/Vokasi)</option>
                            <option value="green" data-bg="bg-green-700" data-text="text-green-700" {{ $currentColorClass == 'bg-green-700' ? 'selected' : '' }}>Hijau Hutan (Lingkungan)</option>
                            <option value="rose" data-bg="bg-rose-600" data-text="text-rose-600" {{ $currentColorClass == 'bg-rose-600' ? 'selected' : '' }}>Merah Rose (Kesehatan)</option>
                        </select>
                        <div id="color-preview" class="w-10 h-10 border border-gray-200 rounded-lg shrink-0 transition-all duration-200"></div>
                    </div>
                    <!-- Hidden inputs for backend compatibility -->
                    <input type="hidden" id="color_class" name="color_class" value="{{ $currentColorClass }}">
                    <input type="hidden" id="text_color" name="text_color" value="{{ old('text_color', $program->text_color) }}">
                    @error('color_class') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    @error('text_color') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-gray-700 uppercase mb-2">Deskripsi Lengkap Program</label>
                <textarea id="description" name="description" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tulis deskripsi program secara lengkap di sini...">{{ old('description', $program->description) }}</textarea>
                @error('description') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.programs.index') }}" class="border border-gray-200 text-gray-700 text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="bg-brand-green text-white text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Initialize color theme preview and set hidden fields
    function updateColorTheme() {
        const select = document.getElementById('color_theme');
        const selectedOption = select.options[select.selectedIndex];
        const bgClass = selectedOption.getAttribute('data-bg');
        const textClass = selectedOption.getAttribute('data-text');

        document.getElementById('color_class').value = bgClass;
        document.getElementById('text_color').value = textClass;

        // Set class preview
        const preview = document.getElementById('color-preview');
        preview.className = 'w-10 h-10 border border-gray-200 rounded-lg shrink-0 transition-all duration-200 ' + bgClass;
    }

    // Run on startup
    document.addEventListener('DOMContentLoaded', function() {
        updateColorTheme();
        
        // Initialize TinyMCE
        tinymce.init({
            selector: '#description',
            height: 350,
            menubar: 'edit insert format table help',
            plugins: 'advlist autolink lists link charmap preview anchor searchreplace code table wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table',
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
