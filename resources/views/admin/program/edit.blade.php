@extends('admin.layout.app')

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Edit Program</h1>
            <p class="text-xs text-gray-500 mt-1">Ubah data program unggulan Yayasan LINTASAN (mendukung Bahasa Indonesia & English).</p>
        </div>
        <a href="{{ route('admin.programs.index') }}" class="text-gray-500 text-xs font-semibold hover:text-brand-green transition flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Language Tabs -->
            <div class="flex border-b border-gray-200 mb-6">
                <button type="button" onclick="switchLanguageTab('id')" id="tab-id" class="px-4 py-2 text-xs font-bold border-b-2 border-brand-green text-brand-green outline-none transition flex items-center gap-1.5">
                    <span class="bg-red-50 text-red-600 text-[10px] px-1.5 py-0.5 rounded font-extrabold border border-red-100">ID</span> Bahasa Indonesia
                </button>
                <button type="button" onclick="switchLanguageTab('en')" id="tab-en" class="px-4 py-2 text-xs font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 outline-none transition flex items-center gap-1.5">
                    <span class="bg-blue-50 text-blue-600 text-[10px] px-1.5 py-0.5 rounded font-extrabold border border-blue-100">EN</span> English
                </button>
            </div>

            <!-- Tab 1: Bahasa Indonesia -->
            <div id="content-tab-id" class="space-y-5">
                <div>
                    <label for="title" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Nama Program <span class="text-red-500">*</span> <span class="text-gray-400 font-normal lowercase">(Bahasa Indonesia)</span>
                    </label>
                    <input type="text" id="title" name="title" required value="{{ old('title', $program->getRawOriginal('title')) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Sekolah Aman Bencana (SPAB)">
                    @error('title') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Deskripsi Singkat (Kartu Depan) ID -->
                <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-200/60">
                    <label for="short_description" class="block text-xs font-bold text-amber-950 uppercase mb-1 flex items-center gap-1.5">
                        <i class="fas fa-layer-group text-brand-orange text-xs"></i>
                        <span>Deskripsi Singkat (Tampil di Kartu Depan / Halaman Utama)</span>
                    </label>
                    <p class="text-[11px] text-gray-500 mb-2 leading-relaxed">
                        Teks ringkas 1-2 kalimat yang tampil langsung pada kartu program di beranda dan halaman daftar program.
                    </p>
                    <textarea id="short_description" name="short_description" rows="2" maxlength="500" class="w-full border border-amber-200 rounded-lg px-3.5 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white" placeholder="Contoh: Membangun budaya sadar bencana di sekolah dan masyarakat.">{{ old('short_description', $program->getRawOriginal('short_description')) }}</textarea>
                    @error('short_description') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Deskripsi Lengkap Program <span class="text-red-500">*</span> <span class="text-gray-400 font-normal lowercase">(Tampil di Halaman Detail)</span>
                    </label>
                    <textarea id="description" name="description" rows="6" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tulis deskripsi program secara lengkap di sini...">{{ old('description', $program->getRawOriginal('description')) }}</textarea>
                    @error('description') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Tab 2: English -->
            <div id="content-tab-en" class="space-y-5 hidden">
                <div>
                    <label for="title_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Program Name <span class="text-gray-400 font-normal lowercase">(English Translation)</span>
                    </label>
                    <input type="text" id="title_en" name="title_en" value="{{ old('title_en', $program->title_en) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="e.g. Disaster Preparedness School (SPAB)">
                    <p class="text-[10px] text-gray-400 mt-1"><i class="fas fa-circle-info text-blue-500"></i> Jika dikosongkan, sistem akan otomatis menggunakan nama versi Bahasa Indonesia.</p>
                    @error('title_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Short Description (Front Card) EN -->
                <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-200/60">
                    <label for="short_description_en" class="block text-xs font-bold text-blue-950 uppercase mb-1 flex items-center gap-1.5">
                        <i class="fas fa-layer-group text-blue-500 text-xs"></i>
                        <span>Short Description (Shown on Front Card / Homepage - English)</span>
                    </label>
                    <p class="text-[11px] text-gray-500 mb-2 leading-relaxed">
                        Brief 1-2 sentences shown on the program card on the homepage when visitor switches language to English.
                    </p>
                    <textarea id="short_description_en" name="short_description_en" rows="2" maxlength="500" class="w-full border border-blue-200 rounded-lg px-3.5 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white" placeholder="e.g. Building a culture of disaster awareness in schools and communities.">{{ old('short_description_en', $program->short_description_en) }}</textarea>
                    <p class="text-[10px] text-gray-400 mt-1"><i class="fas fa-circle-info text-blue-500"></i> Jika dikosongkan, sistem akan menggunakan deskripsi singkat versi Bahasa Indonesia.</p>
                    @error('short_description_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Full Program Description <span class="text-gray-400 font-normal lowercase">(Detail Page - English)</span>
                    </label>
                    <textarea id="description_en" name="description_en" rows="6" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Write full program description in English...">{{ old('description_en', $program->description_en) }}</textarea>
                    <p class="text-[10px] text-gray-400 mt-1"><i class="fas fa-circle-info text-blue-500"></i> Jika dikosongkan, sistem akan otomatis menggunakan deskripsi versi Bahasa Indonesia.</p>
                    @error('description_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- Shared Media & Customization Fields -->
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

            <!-- Urutan Tampilan -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <label for="sort_order" class="block font-bold text-gray-900 text-xs uppercase mb-0.5">Urutan Tampilan (Tampilan Keberapa) <span class="text-red-500">*</span></label>
                    <p class="text-[11px] text-gray-500">Tentukan nomor urutan pemunculan program ini di Beranda dan Halaman Program. Angka 1 berarti tampil paling awal/pertama.</p>
                    @error('sort_order') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="shrink-0 flex items-center gap-2">
                    <span class="text-xs font-black text-gray-400">#</span>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $program->sort_order ?? 1) }}" min="1" required class="w-24 bg-white border border-gray-300 focus:border-brand-green rounded-lg p-2.5 text-xs font-bold text-gray-900 text-center outline-none">
                </div>
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
    function switchLanguageTab(locale) {
        const tabId = document.getElementById('tab-id');
        const tabEn = document.getElementById('tab-en');
        const contentId = document.getElementById('content-tab-id');
        const contentEn = document.getElementById('content-tab-en');

        if (locale === 'id') {
            tabId.className = "px-4 py-2 text-xs font-bold border-b-2 border-brand-green text-brand-green outline-none transition flex items-center gap-1.5";
            tabEn.className = "px-4 py-2 text-xs font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 outline-none transition flex items-center gap-1.5";
            contentId.classList.remove('hidden');
            contentEn.classList.add('hidden');
        } else {
            tabId.className = "px-4 py-2 text-xs font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 outline-none transition flex items-center gap-1.5";
            tabEn.className = "px-4 py-2 text-xs font-bold border-b-2 border-brand-green text-brand-green outline-none transition flex items-center gap-1.5";
            contentId.classList.add('hidden');
            contentEn.classList.remove('hidden');
        }
    }

    // Initialize color theme preview and set hidden fields
    function updateColorTheme() {
        const select = document.getElementById('color_theme');
        if (!select) return;
        const selectedOption = select.options[select.selectedIndex];
        const bgClass = selectedOption.getAttribute('data-bg');
        const textClass = selectedOption.getAttribute('data-text');

        document.getElementById('color_class').value = bgClass;
        document.getElementById('text_color').value = textClass;

        const preview = document.getElementById('color-preview');
        if (preview) {
            preview.className = 'w-10 h-10 border border-gray-200 rounded-lg shrink-0 transition-all duration-200 ' + bgClass;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateColorTheme();
        
        // Initialize TinyMCE for both ID and EN description editors
        tinymce.init({
            selector: '#description, #description_en',
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
