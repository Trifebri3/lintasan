@extends('admin.layout.app')

@section('content')
<div class="bg-gray-50/50 min-h-screen text-xs">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb & Header -->
        <div class="mb-8">
            <nav class="flex text-xs text-gray-500 gap-2 mb-3">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-green transition">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.galleries.index') }}" class="hover:text-brand-green transition">Galeri</a>
                <span>/</span>
                <span class="text-gray-800 font-medium">Edit Item</span>
            </nav>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Edit Item Galeri</h1>
            <p class="text-xs text-gray-500 mt-1">Ubah rincian foto dokumentasi atau tautan video YouTube.</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-150 p-6 sm:p-8">
            <form action="{{ route('admin.galleries.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Tabs header for Bilingual Captions -->
                <div>
                    <span class="block text-gray-400 font-bold uppercase text-[9px] tracking-wider mb-3">Keterangan / Judul (Opsional)</span>
                    <div class="border-b border-gray-200">
                        <nav class="flex gap-4" aria-label="Tabs">
                            <button type="button" onclick="switchLangTab('id')" id="tab-btn-id" class="border-b-2 border-brand-green text-brand-green py-2.5 px-1 font-bold text-xs focus:outline-none transition">
                                Bahasa Indonesia
                            </button>
                            <button type="button" onclick="switchLangTab('en')" id="tab-btn-en" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2.5 px-1 font-bold text-xs focus:outline-none transition">
                                English
                            </button>
                        </nav>
                    </div>

                    <!-- Bilingual inputs -->
                    <div class="mt-4">
                        <!-- ID Tab -->
                        <div id="tab-content-id" class="space-y-4">
                            <div>
                                <label for="title_id" class="block font-bold text-gray-700 mb-1">Judul / Keterangan (ID)</label>
                                <input type="text" name="title_id" id="title_id" value="{{ old('title_id', $item->title_id) }}" placeholder="Contoh: Pendampingan Peternak Pesisir" class="w-full bg-gray-50 border border-gray-200 focus:border-brand-green focus:bg-white rounded-lg p-2.5 text-xs outline-none transition">
                            </div>
                        </div>

                        <!-- EN Tab -->
                        <div id="tab-content-en" class="space-y-4 hidden">
                            <div>
                                <label for="title_en" class="block font-bold text-gray-700 mb-1">Title / Caption (EN)</label>
                                <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $item->title_en) }}" placeholder="Example: Coastal Livestock Mentorship" class="w-full bg-gray-50 border border-gray-200 focus:border-brand-green focus:bg-white rounded-lg p-2.5 text-xs outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type Selector -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">Tipe Dokumentasi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 hover:border-brand-green px-4 py-3 rounded-lg w-1/2 transition">
                            <input type="radio" name="type" value="image" {{ old('type', $item->type) === 'image' ? 'checked' : '' }} onclick="toggleTypeFields('image')" class="text-brand-green focus:ring-brand-green">
                            <div>
                                <div class="font-bold text-gray-800 text-xs">Foto / Gambar</div>
                                <span class="text-[9px] text-gray-400">Unggah berkas foto kegiatan</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 hover:border-brand-green px-4 py-3 rounded-lg w-1/2 transition">
                            <input type="radio" name="type" value="video" {{ old('type', $item->type) === 'video' ? 'checked' : '' }} onclick="toggleTypeFields('video')" class="text-brand-green focus:ring-brand-green">
                            <div>
                                <div class="font-bold text-gray-800 text-xs">Video YouTube</div>
                                <span class="text-[9px] text-gray-400">Tempel link video YouTube</span>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-[10px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload & Preview Field -->
                <div id="field-image-upload">
                    <label class="block font-bold text-gray-700 mb-1">Preview Gambar Saat Ini</label>
                    @if($item->image_path)
                        <div class="w-48 aspect-video rounded-lg overflow-hidden border border-gray-200 mb-3 bg-gray-50 flex items-center justify-center">
                            <img src="{{ $item->image_path }}" alt="Current Image" class="w-full h-full object-cover">
                        </div>
                    @else
                        <p class="text-gray-400 italic mb-3">Tidak ada berkas gambar tersimpan.</p>
                    @endif

                    <label for="image_file" class="block font-bold text-gray-700 mb-1">Ganti Berkas Foto (Opsional)</label>
                    <div class="border-2 border-dashed border-gray-200 hover:border-brand-green bg-gray-50/50 hover:bg-white rounded-xl p-6 transition text-center relative group cursor-pointer">
                        <input type="file" name="image_file" id="image_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                        <div class="text-gray-400 mb-2 text-2xl group-hover:scale-110 transition"><i class="fas fa-cloud-arrow-up"></i></div>
                        <p class="font-bold text-gray-700 text-xs mb-1">Klik untuk pilih gambar baru atau seret file ke sini</p>
                        <p class="text-[9px] text-gray-400">Mendukung format JPEG, PNG, JPG, WEBP (Maksimal 4MB). Gambar baru akan dikompresi otomatis.</p>
                    </div>
                    @error('image_file')
                        <p class="text-red-500 text-[10px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video URL Field -->
                <div id="field-video-url" class="hidden">
                    <label class="block font-bold text-gray-700 mb-1">Preview Thumbnail Video Saat Ini</label>
                    @if($item->youtube_id)
                        <div class="w-48 aspect-video rounded-lg overflow-hidden border border-gray-200 mb-3 bg-gray-50 relative flex items-center justify-center">
                            <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/mqdefault.jpg" alt="Video Thumbnail" class="w-full h-full object-cover">
                            <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                                <i class="fas fa-play text-white"></i>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-400 italic mb-3">Tidak ada video YouTube yang terdaftar.</p>
                    @endif

                    <label for="video_url" class="block font-bold text-gray-700 mb-1">Link Video YouTube</label>
                    <input type="text" name="video_url" id="video_url" value="{{ old('video_url', $item->video_url) }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-gray-50 border border-gray-200 focus:border-brand-green focus:bg-white rounded-lg p-2.5 text-xs outline-none transition">
                    <span class="block text-[10px] text-gray-400 mt-1">Sistem akan secara otomatis mengekstrak thumbnail dan link embed pemutaran video.</span>
                    @error('video_url')
                        <p class="text-red-500 text-[10px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block font-bold text-gray-700 mb-1">Urutan Tampil (Sort Order)</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $item->sort_order) }}" required class="w-32 bg-gray-50 border border-gray-200 focus:border-brand-green focus:bg-white rounded-lg p-2.5 text-xs outline-none transition">
                    <span class="block text-[10px] text-gray-400 mt-1">Semakin kecil angkanya, semakin awal ditampilkan di grid.</span>
                    @error('sort_order')
                        <p class="text-red-500 text-[10px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit / Back buttons -->
                <div class="flex items-center gap-3 pt-4 border-t border-gray-150">
                    <button type="submit" class="bg-brand-green text-white text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">
                        Perbarui Item
                    </button>
                    <a href="{{ route('admin.galleries.index') }}" class="bg-white border border-gray-200 hover:border-gray-300 text-gray-700 text-xs font-bold px-6 py-2.5 rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function switchLangTab(lang) {
        const tabs = ['id', 'en'];
        tabs.forEach(t => {
            const btn = document.getElementById('tab-btn-' + t);
            const content = document.getElementById('tab-content-' + t);
            
            if (t === lang) {
                btn.className = "border-b-2 border-brand-green text-brand-green py-2.5 px-1 font-bold text-xs focus:outline-none transition";
                content.classList.remove('hidden');
            } else {
                btn.className = "border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2.5 px-1 font-bold text-xs focus:outline-none transition";
                content.classList.add('hidden');
            }
        });
    }

    function toggleTypeFields(type) {
        const imgField = document.getElementById('field-image-upload');
        const videoField = document.getElementById('field-video-url');

        if (type === 'image') {
            imgField.classList.remove('hidden');
            videoField.classList.add('hidden');
        } else {
            imgField.classList.add('hidden');
            videoField.classList.remove('hidden');
        }
    }

    // Initialize display values on load
    document.addEventListener('DOMContentLoaded', () => {
        const activeType = document.querySelector('input[name="type"]:checked').value;
        toggleTypeFields(activeType);
    });
</script>
@endsection
