@extends('admin.layout.app')

@section('content')
<div class="space-y-6 max-w-4xl text-xs">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Edit Cerita Lapangan</h1>
            <p class="text-xs text-gray-500 mt-1">Ubah data kisah lapangan Yayasan LINTASAN.</p>
        </div>
        <a href="{{ route('admin.stories.index') }}" class="text-gray-500 text-xs font-semibold hover:text-brand-green transition flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.stories.update', $story->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Language Tabs -->
            <div class="flex border-b border-gray-200 mb-6">
                <button type="button" onclick="switchLanguageTab('id')" id="tab-id" class="px-4 py-2 text-xs font-bold border-b-2 border-brand-green text-brand-green outline-none transition flex items-center gap-1.5">
                    <i class="fas fa-flag"></i> Bahasa Indonesia (ID)
                </button>
                <button type="button" onclick="switchLanguageTab('en')" id="tab-en" class="px-4 py-2 text-xs font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 outline-none transition flex items-center gap-1.5">
                    <i class="fas fa-globe"></i> English (EN)
                </button>
            </div>

            <!-- Indonesian Tab -->
            <div id="content-tab-id" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="title_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">Judul Artikel (ID)</label>
                        <input type="text" id="title_id" name="title_id" required value="{{ old('title_id', $story->title_id) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Masukkan judul menarik">
                        @error('title_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">Kategori / Program (ID)</label>
                        <input type="text" id="category_id" name="category_id" required value="{{ old('category_id', $story->category_id) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: SPAB Cijayana, Tabur Laut">
                        @error('category_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">Ringkasan Deskripsi (ID - Untuk Kartu Depan)</label>
                    <textarea id="description_id" name="description_id" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tulis ringkasan singkat untuk tampilan kartu depan homepage">{{ old('description_id', $story->description_id) }}</textarea>
                    @error('description_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="content_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">Isi Lengkap Artikel (ID)</label>
                    <textarea id="content_id" name="content_id" rows="10" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tuliskan seluruh isi artikel/kisah lapangan di sini.">{{ old('content_id', $story->content_id) }}</textarea>
                    @error('content_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="impact_label_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">Label Dampak (ID - Misal: Siswa & Guru Terlatih)</label>
                    <input type="text" id="impact_label_id" name="impact_label_id" value="{{ old('impact_label_id', $story->impact_label_id) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Masukkan deskripsi metrik dampak dalam Bahasa Indonesia">
                    @error('impact_label_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- English Tab -->
            <div id="content-tab-en" class="space-y-6 hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="title_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">Judul Artikel (EN)</label>
                        <input type="text" id="title_en" name="title_en" required value="{{ old('title_en', $story->title_en) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Enter engaging English title">
                        @error('title_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="category_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">Kategori / Program (EN)</label>
                        <input type="text" id="category_en" name="category_en" required value="{{ old('category_en', $story->category_en) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="e.g. SPAB Cijayana, Tabur Laut">
                        @error('category_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">Ringkasan Deskripsi (EN - Untuk Kartu Depan)</label>
                    <textarea id="description_en" name="description_en" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Write short summary for front card homepage in English">{{ old('description_en', $story->description_en) }}</textarea>
                    @error('description_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="content_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">Isi Lengkap Artikel (EN)</label>
                    <textarea id="content_en" name="content_en" rows="10" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Write full article body text in English here.">{{ old('content_en', $story->content_en) }}</textarea>
                    @error('content_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="impact_label_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">Label Dampak (EN - Misal: Students & Teachers Trained)</label>
                    <input type="text" id="impact_label_en" name="impact_label_en" value="{{ old('impact_label_en', $story->impact_label_en) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Enter English impact metric description">
                    @error('impact_label_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Shared General Fields -->
            <div class="border-t border-gray-150 pt-6 space-y-6">
                <h3 class="text-xs font-bold text-brand-green uppercase tracking-wider mb-2"><i class="fas fa-circle-info mr-1"></i> Data & Dokumentasi Umum</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        @if($story->image_url)
                            <div class="mb-3">
                                <span class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Foto Utama Saat Ini</span>
                                <div class="w-48 h-32 rounded-lg bg-gray-200 bg-cover bg-center border border-gray-100 shadow-sm" style="background-image: url('{{ $story->image_url }}');"></div>
                            </div>
                        @endif
                        <label for="image_url" class="block text-xs font-bold text-gray-700 uppercase mb-2">Ganti Foto Utama (Thumbnail)</label>
                        <input type="file" id="image_url" name="image_url" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                        <p class="text-[10px] text-gray-500 mt-1"><i class="fas fa-circle-info text-brand-green mr-1"></i> File gambar otomatis dikompresi.</p>
                        @error('image_url') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="program_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">Hubungkan ke Program (Tag Program)</label>
                        <select id="program_id" name="program_id" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-semibold">
                            <option value="">-- Cerita Umum / Tidak Ada --</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}" {{ old('program_id', $story->program_id) == $prog->id ? 'selected' : '' }}>{{ $prog->title }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-500 mt-1"><i class="fas fa-circle-info text-brand-green mr-1"></i> Cerita akan tertaut dan tampil di halaman program terpilih.</p>
                        @error('program_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="impact_number" class="block text-xs font-bold text-gray-700 uppercase mb-2">Angka Dampak / Statistik (Opsional, Misal: 150+ / 85%)</label>
                        <input type="text" id="impact_number" name="impact_number" value="{{ old('impact_number', $story->impact_number) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: 450+, 85%">
                        @error('impact_number') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Existing Gallery Images -->
                @php
                    $existingImages = array_filter($story->gallery ?? [], function($item) {
                        return !is_array($item) || ($item['type'] ?? '') === 'image';
                    });
                @endphp
                @if(count($existingImages) > 0)
                    <div class="border-t border-gray-100 pt-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-3">Foto Galeri Saat Ini (Centang untuk menghapus)</label>
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                            @foreach($existingImages as $item)
                                @php
                                    $photoPath = is_array($item) ? ($item['path'] ?? '') : $item;
                                @endphp
                                <div class="relative group rounded-lg overflow-hidden border border-gray-150 shadow-sm aspect-video bg-gray-50">
                                    <img src="{{ $photoPath }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/45 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <label class="flex items-center gap-1.5 text-white font-bold text-[10px] cursor-pointer">
                                            <input type="checkbox" name="remove_gallery[]" value="{{ $photoPath }}" class="rounded text-red-600 focus:ring-red-500">
                                            <span>Hapus</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload New Gallery -->
                <div class="border-t border-gray-100 pt-6">
                    <label for="gallery" class="block text-xs font-bold text-gray-700 uppercase mb-2">Unggah Foto Galeri Tambahan (Bisa pilih banyak sekaligus)</label>
                    <input type="file" id="gallery" name="gallery[]" multiple class="w-full border border-gray-200 rounded-lg p-2.5 outline-none focus:border-brand-green text-xs file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                    <p class="text-[10px] text-gray-500 mt-1"><i class="fas fa-circle-info text-brand-green mr-1"></i> File foto yang diunggah akan otomatis dikompresi.</p>
                    @error('gallery') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Existing YouTube Videos -->
                @php
                    $existingVideos = array_filter($story->gallery ?? [], function($item) {
                        return is_array($item) && ($item['type'] ?? '') === 'video';
                    });
                @endphp
                @if(count($existingVideos) > 0)
                    <div class="border-t border-gray-100 pt-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-3">Video YouTube Saat Ini (Centang untuk menghapus)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($existingVideos as $video)
                                <div class="relative group rounded-lg overflow-hidden border border-gray-150 shadow-sm aspect-video bg-black">
                                    <iframe class="w-full h-full pointer-events-none" src="{{ $video['embed_url'] }}" frameborder="0"></iframe>
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <label class="flex items-center gap-1.5 text-white font-bold text-[10px] cursor-pointer">
                                            <input type="checkbox" name="remove_gallery[]" value="{{ $video['path'] }}" class="rounded text-red-600 focus:ring-red-500">
                                            <span>Hapus Video</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- YouTube Links Area -->
                <div class="border-t border-gray-100 pt-6">
                    <label for="youtube_links" class="block text-xs font-bold text-gray-700 uppercase mb-2">Sematkan Link Video YouTube Baru (Opsional, Satu link per baris)</label>
                    <textarea id="youtube_links" name="youtube_links" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-mono" placeholder="Masukkan link video YouTube, contoh:&#10;https://www.youtube.com/watch?v=dQw4w9WgXcQ">{{ old('youtube_links') }}</textarea>
                    @error('youtube_links') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Related Links Area -->
                <div class="border-t border-gray-100 pt-6">
                    <label for="related_links" class="block text-xs font-bold text-gray-700 uppercase mb-2">Tautan Artikel Terkait / Kesamaan (Opsional, Satu link atau slug per baris)</label>
                    <textarea id="related_links" name="related_links" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-mono" placeholder="Masukkan link atau slug artikel, contoh:&#10;belajar-hari-ini-sukses-esok-hari&#10;https://lintassenyumanaknegeri.org/cerita-dampak/nelayan-kuat-ekonomi-naik">{{ old('related_links', $story->related_links) }}</textarea>
                    <p class="text-[10px] text-gray-500 mt-1"><i class="fas fa-circle-info text-brand-green mr-1"></i> Admin bebas menentukan berita/artikel mana yang akan sama/terkait dengan memasukkan slug atau URL artikel di sini.</p>
                    @error('related_links') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-3 border-t border-gray-100">
                <a href="{{ route('admin.stories.index') }}" class="border border-gray-200 text-gray-700 text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="bg-brand-green text-white text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Tab switching logic
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

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TinyMCE for main body content editors
        tinymce.init({
            selector: '#content_id, #content_en',
            height: 380,
            menubar: 'edit insert format table help',
            plugins: 'advlist autolink lists link charmap preview anchor searchreplace code table wordcount image media',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table image media',
            content_style: 'body { font-family: "Instrument Sans", sans-serif; font-size: 13px; line-height: 1.6; color: #374151; }',
            branding: false,
            promotion: false,
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function (resolve, reject) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route("admin.stories.upload_image") }}', true);
                    xhr.setRequestHeader('x-csrf-token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    
                    xhr.upload.onprogress = function (e) {
                        progress(e.loaded / e.total * 100);
                    };
                    
                    xhr.onload = function () {
                        if (xhr.status === 403) {
                            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                            return;
                        }
                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject('HTTP Error: ' + xhr.status);
                            return;
                        }
                        var json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.url !== 'string') {
                            reject('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        resolve(json.url);
                    };
                    
                    xhr.onerror = function () {
                        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    };
                    
                    var formData = new FormData();
                    formData.append('upload', blobInfo.blob(), blobInfo.filename());
                    
                    xhr.send(formData);
                });
            },
            setup: function(editor) {
                editor.on('change keyup', function() {
                    editor.save();
                });
            }
        });

        // Initialize TinyMCE for summary/description editors
        tinymce.init({
            selector: '#description_id, #description_en',
            height: 200,
            menubar: 'edit insert format help',
            plugins: 'advlist autolink lists link charmap preview searchreplace code table wordcount',
            toolbar: 'undo redo | blocks | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
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
