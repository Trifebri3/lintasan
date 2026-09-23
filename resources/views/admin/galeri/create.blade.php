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
                <span class="text-gray-800 font-medium">Tambah Item</span>
            </nav>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Tambah Item Galeri</h1>
            <p class="text-xs text-gray-500 mt-1">Daftarkan foto dokumentasi atau tautan video YouTube baru.</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-150 p-6 sm:p-8">
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

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
                                <input type="text" name="title_id" id="title_id" value="{{ old('title_id') }}" placeholder="Contoh: Pendampingan Peternak Pesisir" class="w-full bg-gray-50 border border-gray-200 focus:border-brand-green focus:bg-white rounded-lg p-2.5 text-xs outline-none transition">
                            </div>
                        </div>

                        <!-- EN Tab -->
                        <div id="tab-content-en" class="space-y-4 hidden">
                            <div>
                                <label for="title_en" class="block font-bold text-gray-700 mb-1">Title / Caption (EN)</label>
                                <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}" placeholder="Example: Coastal Livestock Mentorship" class="w-full bg-gray-50 border border-gray-200 focus:border-brand-green focus:bg-white rounded-lg p-2.5 text-xs outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type Selector -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">Tipe Dokumentasi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 hover:border-brand-green px-4 py-3 rounded-lg w-1/2 transition">
                            <input type="radio" name="type" value="image" checked onclick="toggleTypeFields('image')" class="text-brand-green focus:ring-brand-green">
                            <div>
                                <div class="font-bold text-gray-800 text-xs">Foto / Gambar</div>
                                <span class="text-[9px] text-gray-400">Unggah berkas foto kegiatan</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 hover:border-brand-green px-4 py-3 rounded-lg w-1/2 transition">
                            <input type="radio" name="type" value="video" onclick="toggleTypeFields('video')" class="text-brand-green focus:ring-brand-green">
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

                <!-- Image Upload Field -->
                <div id="field-image-upload">
                    <label for="image_file" class="block font-bold text-gray-700 mb-1">Berkas Foto</label>
                    <div class="border-2 border-dashed border-gray-200 hover:border-brand-green bg-gray-50/50 hover:bg-white rounded-xl p-6 transition text-center relative group cursor-pointer">
                        <input type="file" name="image_file" id="image_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                        <div class="text-gray-400 mb-2 text-2xl group-hover:scale-110 transition"><i class="fas fa-cloud-arrow-up"></i></div>
                        <p class="font-bold text-gray-700 text-xs mb-1">Klik untuk pilih gambar atau seret file ke sini</p>
                        <p class="text-[9px] text-gray-400">Mendukung format JPEG, PNG, JPG, WEBP (Maksimal 4MB). Foto akan dikompresi server secara otomatis.</p>
                    </div>
                    @error('image_file')
                        <p class="text-red-500 text-[10px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video URL Field -->
                <div id="field-video-url" class="hidden">
                    <label for="video_url" class="block font-bold text-gray-700 mb-1">Link Video YouTube</label>
                    <input type="text" name="video_url" id="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-gray-50 border border-gray-200 focus:border-brand-green focus:bg-white rounded-lg p-2.5 text-xs outline-none transition">
                    <span class="block text-[10px] text-gray-400 mt-1">Sistem akan secara otomatis mengekstrak thumbnail dan link embed pemutaran video.</span>
                    @error('video_url')
                        <p class="text-red-500 text-[10px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bento Grid Layout Size Selector -->
                <div>
                    <label class="block font-bold text-gray-800 mb-1 flex items-center justify-between">
                        <span>Pilihan Ukuran Layout (Bento Grid)</span>
                        <span class="text-[10px] text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                            <i class="fas fa-shapes mr-1"></i> Tampilan Unik Dinamis
                        </span>
                    </label>
                    <p class="text-[10px] text-gray-500 mb-3">Tentukan proporsi kartu dokumentasi ini agar halaman galeri publik tampil variatif dan tidak monoton.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <!-- 1. Normal (1x1) -->
                        <label class="relative flex flex-col p-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-emerald-500 hover:bg-emerald-50/20 transition group has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/40 has-[:checked]:ring-1 has-[:checked]:ring-emerald-600">
                            <input type="radio" name="layout_size" value="normal" {{ old('layout_size', 'normal') === 'normal' ? 'checked' : '' }} class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-xs text-gray-900 group-hover:text-emerald-700">Normal (1x1)</span>
                                <div class="w-6 h-6 rounded bg-gray-200 group-has-[:checked]:bg-emerald-600 group-has-[:checked]:text-white flex items-center justify-center text-[10px]">
                                    <i class="fas fa-square"></i>
                                </div>
                            </div>
                            <div class="w-full h-12 bg-white rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 group-has-[:checked]:border-emerald-300 mb-2">
                                <div class="w-8 h-8 rounded bg-gray-100 group-has-[:checked]:bg-emerald-100 flex items-center justify-center text-[10px] text-gray-500 font-mono">1x1</div>
                            </div>
                            <span class="text-[10px] text-gray-500 leading-tight">Ukuran kotak standar 1 kolom x 1 baris.</span>
                        </label>

                        <!-- 2. Featured (2x2) -->
                        <label class="relative flex flex-col p-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-500 hover:bg-purple-50/20 transition group has-[:checked]:border-purple-600 has-[:checked]:bg-purple-50/40 has-[:checked]:ring-1 has-[:checked]:ring-purple-600">
                            <input type="radio" name="layout_size" value="featured" {{ old('layout_size') === 'featured' ? 'checked' : '' }} class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-xs text-gray-900 group-hover:text-purple-700">Besar (2x2)</span>
                                <div class="w-6 h-6 rounded bg-gray-200 group-has-[:checked]:bg-purple-600 group-has-[:checked]:text-white flex items-center justify-center text-[10px]">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="w-full h-12 bg-white rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 group-has-[:checked]:border-purple-300 mb-2">
                                <div class="w-12 h-10 rounded bg-purple-100 text-purple-700 flex items-center justify-center text-[10px] font-mono font-bold">2x2</div>
                            </div>
                            <span class="text-[10px] text-gray-500 leading-tight">Sorotan utama besar (2 kolom x 2 baris).</span>
                        </label>

                        <!-- 3. Wide (2x1) -->
                        <label class="relative flex flex-col p-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50/20 transition group has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/40 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                            <input type="radio" name="layout_size" value="wide" {{ old('layout_size') === 'wide' ? 'checked' : '' }} class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-xs text-gray-900 group-hover:text-blue-700">Lebar (2x1)</span>
                                <div class="w-6 h-6 rounded bg-gray-200 group-has-[:checked]:bg-blue-600 group-has-[:checked]:text-white flex items-center justify-center text-[10px]">
                                    <i class="fas fa-arrows-left-right"></i>
                                </div>
                            </div>
                            <div class="w-full h-12 bg-white rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 group-has-[:checked]:border-blue-300 mb-2">
                                <div class="w-16 h-6 rounded bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-mono font-bold">2x1</div>
                            </div>
                            <span class="text-[10px] text-gray-500 leading-tight">Panjang mendatar (2 kolom x 1 baris).</span>
                        </label>

                        <!-- 4. Tall (1x2) -->
                        <label class="relative flex flex-col p-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-amber-500 hover:bg-amber-50/20 transition group has-[:checked]:border-amber-600 has-[:checked]:bg-amber-50/40 has-[:checked]:ring-1 has-[:checked]:ring-amber-600">
                            <input type="radio" name="layout_size" value="tall" {{ old('layout_size') === 'tall' ? 'checked' : '' }} class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-xs text-gray-900 group-hover:text-amber-700">Tinggi (1x2)</span>
                                <div class="w-6 h-6 rounded bg-gray-200 group-has-[:checked]:bg-amber-600 group-has-[:checked]:text-white flex items-center justify-center text-[10px]">
                                    <i class="fas fa-arrows-up-down"></i>
                                </div>
                            </div>
                            <div class="w-full h-12 bg-white rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 group-has-[:checked]:border-amber-300 mb-2">
                                <div class="w-6 h-10 rounded bg-amber-100 text-amber-700 flex items-center justify-center text-[10px] font-mono font-bold">1x2</div>
                            </div>
                            <span class="text-[10px] text-gray-500 leading-tight">Tegak potret vertikal (1 kolom x 2 baris).</span>
                        </label>
                    </div>
                    @error('layout_size')
                        <p class="text-red-500 text-[10px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order (Urutan Tampilan Keberapa) -->
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <label for="sort_order" class="block font-bold text-gray-900 mb-0.5">Urutan Tampilan (Tampilan Keberapa) <span class="text-red-500">*</span></label>
                        <p class="text-[11px] text-gray-500">Tentukan nomor urutan pemunculan foto/video ini di halaman galeri. Angka <strong>1</strong> berarti tampil paling awal/pertama.</p>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <span class="text-xs font-black text-gray-400">#</span>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder ?? 1) }}" min="1" required class="w-24 bg-white border border-gray-300 focus:border-brand-green rounded-lg p-2.5 text-xs font-bold text-gray-900 text-center outline-none">
                    </div>
                </div>
                @error('sort_order')
                    <p class="text-red-500 text-[10px] -mt-3 font-semibold">{{ $message }}</p>
                @enderror

                <!-- Submit / Back buttons -->
                <div class="flex items-center gap-3 pt-4 border-t border-gray-150">
                    <button type="submit" class="bg-brand-green text-white text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">
                        Simpan Item
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

    // Preserve old dynamic field types on validation fail redirect
    document.addEventListener('DOMContentLoaded', () => {
        const activeType = document.querySelector('input[name="type"]:checked').value;
        toggleTypeFields(activeType);
    });
</script>
@endsection
