@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 leading-tight">Pengaturan Konten Halaman</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola teks profil yayasan, visi misi, 5 nilai lintasan, dan foto latar secara terstruktur per kategori.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="openLivePreviewModal('/tentang-kami')" class="bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 text-xs font-bold px-3.5 py-2.5 rounded-lg transition flex items-center gap-1.5 shadow-sm">
                <i class="fas fa-desktop"></i> Live Preview Tentang Kami
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green p-4 rounded-xl text-xs font-semibold shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-circle-check text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Category Tabs Navigation -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-2 flex flex-col md:flex-row md:items-center justify-between gap-3 select-none">
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <button type="button" onclick="switchCategoryTab('profil')" id="tab-btn-profil" class="category-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold transition flex items-center gap-2 {{ $activeTab === 'profil' ? 'bg-brand-green text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fas fa-building-columns text-sm"></i>
                <span>Profil & Visi Misi</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $activeTab === 'profil' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">4</span>
            </button>

            <button type="button" onclick="switchCategoryTab('nilai')" id="tab-btn-nilai" class="category-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold transition flex items-center gap-2 {{ $activeTab === 'nilai' ? 'bg-brand-green text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fas fa-award text-sm text-brand-yellow"></i>
                <span>Nilai Lintasan</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $activeTab === 'nilai' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $organizationValues->count() }} Nilai</span>
            </button>

            <button type="button" onclick="switchCategoryTab('banner')" id="tab-btn-banner" class="category-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold transition flex items-center gap-2 {{ $activeTab === 'banner' ? 'bg-brand-green text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fas fa-images text-sm"></i>
                <span>Foto Latar & Banner</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $activeTab === 'banner' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">3</span>
            </button>

            <button type="button" onclick="switchCategoryTab('label')" id="tab-btn-label" class="category-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold transition flex items-center gap-2 {{ $activeTab === 'label' ? 'bg-brand-green text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <i class="fas fa-language text-sm"></i>
                <span>Label & Teks Tambahan</span>
            </button>
        </div>

        <!-- Quick Filter Input -->
        <div class="relative w-full md:w-64">
            <i class="fas fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            <input type="text" id="setting-search-input" onkeyup="filterSettings(this.value)" placeholder="Cari konten pengaturan..." class="w-full pl-8 pr-3 py-2 text-xs border border-gray-200 rounded-lg focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none bg-gray-50 focus:bg-white transition">
        </div>
    </div>

    @php
        // Rich Metadata for Settings
        $settingMeta = [
            'about_profile' => [
                'label' => 'Kutipan Profil Utama (Quote Box)',
                'category' => 'profil',
                'location' => 'Halaman Tentang Kami - Kotak Kutipan di Bawah Judul',
                'help' => 'Teks kutipan profil yayasan yang tampil di dalam kotak berbingkai di bagian atas halaman Tentang Kami.',
                'icon' => 'fa-quote-left',
                'rows' => 3
            ],
            'about_visi' => [
                'label' => 'Visi Organisasi (Visi Kami)',
                'category' => 'profil',
                'location' => 'Halaman Tentang Kami - Bagian Visi Kami',
                'help' => 'Pernyataan visi jangka panjang Yayasan LINTASAN.',
                'icon' => 'fa-eye',
                'rows' => 3
            ],
            'about_misi' => [
                'label' => 'Misi Organisasi (Misi Kami)',
                'category' => 'profil',
                'location' => 'Halaman Tentang Kami - Bagian Misi Kami',
                'help' => 'Poin-poin misi yayasan. Gunakan tombol Enter (baris baru) untuk memisahkan setiap poin misi agar tampil rapi sebagai daftar berbutir.',
                'icon' => 'fa-bullseye',
                'rows' => 6
            ],
            'about_conclusion' => [
                'label' => 'Paragraf Penutup (Closing Statement)',
                'category' => 'profil',
                'location' => 'Halaman Tentang Kami - Paragraf Penutup',
                'help' => 'Paragraf ringkasan penutup komitmen yayasan yang tampil sebelum bagian Nilai Lintasan.',
                'icon' => 'fa-paragraph',
                'rows' => 4
            ],
            'about_pillar_kolaborasi' => [
                'label' => 'Nilai 1: Kolaborasi (Collaboration)',
                'category' => 'nilai',
                'location' => 'Halaman Tentang Kami - Kartu Nilai ke-1',
                'help' => 'Jelaskan nilai sinergi lintas sektor, gotong royong, dan kemitraan strategis yayasan.',
                'icon' => 'fa-handshake',
                'rows' => 3
            ],
            'about_pillar_edukasi' => [
                'label' => 'Nilai 2: Edukasi (Education & Capacity)',
                'category' => 'nilai',
                'location' => 'Halaman Tentang Kami - Kartu Nilai ke-2',
                'help' => 'Jelaskan komitmen pembekalan pengetahuan kesiapsiagaan dan peningkatan kapasitas masyarakat.',
                'icon' => 'fa-graduation-cap',
                'rows' => 3
            ],
            'about_pillar_inovasi' => [
                'label' => 'Nilai 3: Inovasi (Innovation & Technology)',
                'category' => 'nilai',
                'location' => 'Halaman Tentang Kami - Kartu Nilai ke-3',
                'help' => 'Jelaskan penerapan teknologi tepat guna ramah lingkungan seperti solar freezer energi surya.',
                'icon' => 'fa-lightbulb',
                'rows' => 3
            ],
            'about_pillar_transparansi' => [
                'label' => 'Nilai 4: Transparansi (Transparency & Accountability)',
                'category' => 'nilai',
                'location' => 'Halaman Tentang Kami - Kartu Nilai ke-4',
                'help' => 'Jelaskan komitmen keterbukaan data, tata kelola profesional, dan akuntabilitas dampak.',
                'icon' => 'fa-shield-halved',
                'rows' => 3
            ],
            'about_pillar_5_title' => [
                'label' => 'Nilai 5: Judul Nilai (Pilar ke-5)',
                'category' => 'nilai',
                'location' => 'Halaman Tentang Kami - Judul Kartu Nilai ke-5',
                'help' => 'Tuliskan nama/judul nilai ke-5 dari company profile Yayasan LINTASAN (misal: Keberlanjutan, Kemandirian, atau Integritas).',
                'icon' => 'fa-tag',
                'type' => 'text'
            ],
            'about_pillar_5_desc' => [
                'label' => 'Nilai 5: Penjelasan Deskripsi (Pilar ke-5)',
                'category' => 'nilai',
                'location' => 'Halaman Tentang Kami - Isi Deskripsi Kartu Nilai ke-5',
                'help' => 'Tuliskan penjelasan lengkap mengenai nilai ke-5 tersebut.',
                'icon' => 'fa-file-lines',
                'rows' => 3
            ],
            'title_impact' => [
                'label' => 'Judul Seksi Statistik Dampak',
                'category' => 'banner',
                'location' => 'Halaman Beranda - Judul Seksi Angka Dampak',
                'help' => 'Judul bagian statistik capaian yayasan di halaman depan (contoh: Lintasan Dalam Angka).',
                'icon' => 'fa-chart-pie',
                'type' => 'text'
            ],
            'bg_photo_impact' => [
                'label' => 'Foto Latar Seksi Statistik Dampak',
                'category' => 'banner',
                'location' => 'Halaman Beranda - Background Seksi Dampak',
                'help' => 'Upload foto latar belakang berdimensi lansekap (1920x1080px, maks 4MB) untuk bagian statistik capaian.',
                'icon' => 'fa-panorama',
                'type' => 'image'
            ],
            'bg_photo_cta' => [
                'label' => 'Foto Latar Banner Ajakan Aksi (CTA)',
                'category' => 'banner',
                'location' => 'Halaman Utama & Footer - Background Banner CTA',
                'help' => 'Upload foto latar belakang untuk banner ajakan kemitraan dan kerelawanan di atas footer.',
                'icon' => 'fa-panorama',
                'type' => 'image'
            ],
        ];
    @endphp

    <!-- TAB PANEL 1: PROFIL & VISI MISI -->
    <div id="panel-profil" class="category-panel space-y-6 {{ $activeTab === 'profil' ? '' : 'hidden' }}">
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-xs text-emerald-900 flex items-start gap-3 shadow-sm">
            <i class="fas fa-building-columns text-xl text-emerald-600 mt-0.5 shrink-0"></i>
            <div>
                <div class="font-extrabold text-sm text-emerald-950">Kategori: Profil & Visi Misi Organisasi</div>
                <div class="text-xs text-emerald-800 mt-0.5 leading-relaxed">
                    Pengaturan di bawah ini mengatur teks utama pada halaman <strong>Tentang Kami (`/tentang-kami`)</strong>: kutipan profil, visi, butir-butir misi, dan penutup.
                </div>
            </div>
        </div>

        @foreach($categories['profil']['keys'] as $key)
            @if(isset($allSettings[$key]))
                @php 
                    $setting = $allSettings[$key];
                    $meta = $settingMeta[$key] ?? [];
                @endphp
                @include('admin.settings._card_item', ['setting' => $setting, 'meta' => $meta, 'catId' => 'profil'])
            @endif
        @endforeach
    </div>

    <!-- TAB PANEL 2: NILAI LINTASAN (DINAMIS - BISA DITAMBAH & DIKURANGI) -->
    <div id="panel-nilai" class="category-panel space-y-6 {{ $activeTab === 'nilai' ? '' : 'hidden' }}">
        <!-- Header Banner with Add Action -->
        <div class="bg-gradient-to-r from-emerald-50 via-teal-50 to-amber-50 border border-emerald-200 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md">
                    <i class="fas fa-award text-lg"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-extrabold text-base text-gray-900">Nilai Lintasan (Pilar Organisasi)</h2>
                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                            {{ $organizationValues->count() }} Nilai Aktif
                        </span>
                    </div>
                    <p class="text-xs text-gray-600 mt-1 leading-relaxed max-w-2xl">
                        Kelola pilar nilai utama yayasan yang tampil pada kartu di halaman <strong>Tentang Kami (`/tentang-kami`)</strong>. Anda dapat <strong>menambah nilai baru (+)</strong>, <strong>mengubah teks & ikon</strong>, serta <strong>menghapus nilai (-)</strong> secara fleksibel. Dilengkapi Rich Text Editor untuk pemformatan teks visual.
                    </p>
                </div>
            </div>
            <button type="button" onclick="openModalAddValue()" class="self-start md:self-center shrink-0 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2 transform active:scale-95">
                <i class="fas fa-plus-circle text-sm"></i>
                <span>Tambah Nilai Baru</span>
            </button>
        </div>

        <!-- Values Cards List -->
        <div class="space-y-4" id="values-list-container">
            @forelse($organizationValues as $val)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 p-5 space-y-4 setting-item-card" data-setting-key="nilai_{{ $val->id }}">
                    <!-- Card Top Row -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-150">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600 border border-gray-200" title="Urutan Tampilan">
                                #{{ $val->order }}
                            </span>
                            <div class="w-10 h-10 rounded-xl {{ $val->bg_class ?? 'bg-emerald-50' }} {{ $val->color_class ?? 'text-emerald-700' }} border {{ $val->border_class ?? 'border-emerald-200' }} flex items-center justify-center text-base shadow-2xs">
                                <i class="fas {{ $val->icon ?: 'fa-award' }}"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-extrabold text-gray-900">{{ $val->title_id }}</h3>
                                    <span class="text-xs text-gray-400 font-medium italic">({{ $val->title_en ?: '-' }})</span>
                                </div>
                                <div class="text-[11px] text-gray-500 flex items-center gap-2 mt-0.5">
                                    <span class="inline-flex items-center gap-1 text-emerald-700 font-semibold"><i class="fas fa-circle-check text-[10px]"></i> Tampil di Publik</span>
                                    <span>•</span>
                                    <span>Ikon: <code class="font-mono text-[10px] bg-gray-100 px-1.5 py-0.2 rounded">{{ $val->icon }}</code></span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="flex items-center gap-2 self-end sm:self-center">
                            <button type="button" onclick="openEditModal({{ $val->id }})" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                                <i class="fas fa-pen-to-square"></i> Edit
                            </button>
                            <form action="{{ route('admin.organization-values.destroy', $val->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nilai &quot;{{ addslashes($val->title_id) }}&quot; ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="active_tab" value="nilai">
                                <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Bilingual Content Preview -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-[11px] font-bold text-gray-700">
                                <span class="flex items-center gap-1.5">
                                    <span class="px-1.5 py-0.2 bg-red-100 text-red-700 rounded text-[10px] font-black">ID</span>
                                    VERSI BAHASA INDONESIA
                                </span>
                            </div>
                            <div class="p-3.5 bg-gray-50/80 rounded-xl border border-gray-200 text-xs text-gray-700 leading-relaxed min-h-[70px] prose prose-xs max-w-none">
                                {!! $val->description_id !!}
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-[11px] font-bold text-gray-700">
                                <span class="flex items-center gap-1.5">
                                    <span class="px-1.5 py-0.2 bg-blue-100 text-blue-700 rounded text-[10px] font-black">EN</span>
                                    ENGLISH TRANSLATION
                                </span>
                            </div>
                            <div class="p-3.5 bg-gray-50/80 rounded-xl border border-gray-200 text-xs text-gray-700 leading-relaxed min-h-[70px] prose prose-xs max-w-none">
                                {!! $val->description_en ?: '<em class="text-gray-400">Belum ada terjemahan bahasa Inggris</em>' !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Belum Ada Nilai Lintasan</h3>
                    <p class="text-xs text-gray-500 max-w-md mx-auto mb-4">Tambahkan pilar atau nilai organisasi untuk ditampilkan pada halaman Tentang Kami.</p>
                    <button type="button" onclick="openModalAddValue()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition inline-flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i> Tambah Nilai Sekarang
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- TAB PANEL 3: FOTO LATAR & BANNER -->
    <div id="panel-banner" class="category-panel space-y-6 {{ $activeTab === 'banner' ? '' : 'hidden' }}">
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-xs text-blue-900 flex items-start gap-3 shadow-sm">
            <i class="fas fa-images text-xl text-blue-600 mt-0.5 shrink-0"></i>
            <div>
                <div class="font-extrabold text-sm text-blue-950">Kategori: Foto Latar Belakang & Banner Visual</div>
                <div class="text-xs text-blue-800 mt-0.5 leading-relaxed">
                    Kelola gambar latar belakang beresolusi tinggi untuk seksi statistik dampak pesisir dan banner ajakan aksi di atas footer.
                </div>
            </div>
        </div>

        @foreach($categories['banner']['keys'] as $key)
            @if(isset($allSettings[$key]))
                @php 
                    $setting = $allSettings[$key];
                    $meta = $settingMeta[$key] ?? [];
                @endphp
                @include('admin.settings._card_item', ['setting' => $setting, 'meta' => $meta, 'catId' => 'banner'])
            @endif
        @endforeach
    </div>

    <!-- TAB PANEL 4: LABEL & TEKS TAMBAHAN -->
    <div id="panel-label" class="category-panel space-y-6 {{ $activeTab === 'label' ? '' : 'hidden' }}">
        <div class="bg-gray-100 border border-gray-200 rounded-xl p-4 text-xs text-gray-800 flex items-start justify-between gap-3 shadow-sm">
            <div class="flex items-start gap-3">
                <i class="fas fa-language text-xl text-gray-600 mt-0.5 shrink-0"></i>
                <div>
                    <div class="font-extrabold text-sm text-gray-900">Kategori: Label & Teks Antarmuka Web Tambahan</div>
                    <div class="text-xs text-gray-600 mt-0.5 leading-relaxed">
                        Daftar teks tombol, judul navigasi, dan frasa umum lainnya di situs web. Gunakan kotak pencarian di atas untuk menyaring teks yang ingin Anda ubah secara cepat.
                    </div>
                </div>
            </div>
            <span class="text-xs font-bold bg-white text-gray-700 px-3 py-1 rounded-full border border-gray-200 shrink-0">
                Total: {{ $otherSettings->count() }} Teks
            </span>
        </div>

        <div class="space-y-4" id="other-settings-container">
            @foreach($otherSettings as $setting)
                @php
                    $cleanLabel = ucwords(str_replace(['_', '-'], ' ', $setting->key));
                    $meta = [
                        'label' => $cleanLabel,
                        'category' => 'label',
                        'location' => 'Elemen Antarmuka Web (' . $setting->key . ')',
                        'help' => 'Teks frasa publik untuk antarmuka web.',
                        'icon' => 'fa-font',
                        'type' => $setting->type
                    ];
                @endphp
                @include('admin.settings._card_item', ['setting' => $setting, 'meta' => $meta, 'catId' => 'label'])
            @endforeach
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: TAMBAH NILAI LINTASAN BARU -->
<!-- ========================================== -->
<div id="modal-add-value" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-5 overflow-y-auto hidden">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full border border-gray-200 overflow-hidden my-auto max-h-[92vh] flex flex-col">
        <!-- Modal Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-700 text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-base">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black">Tambah Nilai Lintasan Baru</h3>
                    <p class="text-[11px] text-emerald-100">Nilai akan otomatis tampil sebagai kartu di halaman Tentang Kami.</p>
                </div>
            </div>
            <button type="button" onclick="closeModalAddValue()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form action="{{ route('admin.organization-values.store') }}" method="POST" onsubmit="if(window.tinymce){tinymce.triggerSave();}" class="p-6 space-y-4 overflow-y-auto flex-1">
            @csrf
            <input type="hidden" name="active_tab" value="nilai">

            <!-- Row 1: Titles (ID & EN) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1">
                        Judul Nilai (Bahasa Indonesia) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" required placeholder="Contoh: Kolaborasi, Kemandirian, dll." class="w-full px-3.5 py-2.5 text-xs border border-gray-300 rounded-xl focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1">
                        Judul Nilai (English)
                    </label>
                    <input type="text" name="title_en" placeholder="Contoh: Collaboration, Independence, etc." class="w-full px-3.5 py-2.5 text-xs border border-gray-300 rounded-xl focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none">
                </div>
            </div>

            <!-- Row 2: Icon, Theme, Order -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1">
                        Simbol Ikon FontAwesome <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-gray-100 border border-gray-300 flex items-center justify-center text-sm text-gray-700 shrink-0" id="add-icon-preview">
                            <i class="fas fa-award"></i>
                        </div>
                        <input type="text" name="icon" id="add-icon-input" value="fa-award" required oninput="document.getElementById('add-icon-preview').innerHTML = '<i class=\'fas ' + this.value + '\'></i>'" class="w-full px-3 py-2 text-xs font-mono border border-gray-300 rounded-xl focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none">
                    </div>
                    <!-- Quick Pick Icons -->
                    <div class="flex flex-wrap gap-1 mt-1.5">
                        @php
                            $presetIcons = ['fa-handshake', 'fa-graduation-cap', 'fa-lightbulb', 'fa-shield-halved', 'fa-seedling', 'fa-circle-nodes', 'fa-users', 'fa-heart', 'fa-earth-asia', 'fa-anchor', 'fa-compass', 'fa-award'];
                        @endphp
                        @foreach($presetIcons as $ico)
                            <button type="button" onclick="setAddIcon('{{ $ico }}')" class="w-6 h-6 rounded bg-gray-100 hover:bg-emerald-50 hover:text-emerald-700 text-gray-600 text-[10px] flex items-center justify-center border border-gray-200 transition" title="{{ $ico }}">
                                <i class="fas {{ $ico }}"></i>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1">
                        Tema Warna Kartu
                    </label>
                    <select name="theme" class="w-full px-3.5 py-2.5 text-xs border border-gray-300 rounded-xl focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none bg-white">
                        <option value="emerald">Emerald (Hijau Pesisir)</option>
                        <option value="blue">Blue (Biru Samudra)</option>
                        <option value="amber">Amber (Kuning / Oranye)</option>
                        <option value="purple">Purple (Ungu Mewah)</option>
                        <option value="teal">Teal (Tosca Ekosistem)</option>
                        <option value="rose">Rose (Merah Dinamis)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1">
                        Urutan Tampilan
                    </label>
                    <input type="number" name="order" value="{{ ($organizationValues->max('order') ?? 0) + 1 }}" min="1" class="w-full px-3.5 py-2.5 text-xs border border-gray-300 rounded-xl focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 outline-none">
                </div>
            </div>

            <!-- Row 3: Deskripsi ID with Rich Text Editor -->
            <div>
                <label class="block text-xs font-bold text-gray-800 mb-1 flex items-center justify-between">
                    <span>Deskripsi Nilai (Bahasa Indonesia) <span class="text-red-500">*</span></span>
                    <span class="text-[10px] text-emerald-700 font-semibold flex items-center gap-1"><i class="fas fa-wand-magic-sparkles"></i> Rich Text Editor</span>
                </label>
                <textarea name="description" id="add_value_description" class="modal-rich-editor w-full border border-gray-300 rounded-xl p-3 text-xs" rows="4" placeholder="Jelaskan nilai ini secara mendalam..."></textarea>
            </div>

            <!-- Row 4: Deskripsi EN with Rich Text Editor -->
            <div>
                <label class="block text-xs font-bold text-gray-800 mb-1 flex items-center justify-between">
                    <span>Deskripsi Nilai (English Translation)</span>
                    <span class="text-[10px] text-blue-700 font-semibold flex items-center gap-1"><i class="fas fa-wand-magic-sparkles"></i> Rich Text Editor</span>
                </label>
                <textarea name="description_en" id="add_value_description_en" class="modal-rich-editor w-full border border-gray-300 rounded-xl p-3 text-xs" rows="4" placeholder="Explain this value in English..."></textarea>
            </div>

            <!-- Modal Actions -->
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-200">
                <button type="button" onclick="closeModalAddValue()" class="px-4 py-2.5 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-extrabold bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2">
                    <i class="fas fa-check"></i> Simpan Nilai Baru
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODALS: EDIT NILAI LINTASAN -->
<!-- ========================================== -->
@foreach($organizationValues as $val)
    <div id="modal-edit-value-{{ $val->id }}" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-5 overflow-y-auto hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full border border-gray-200 overflow-hidden my-auto max-h-[92vh] flex flex-col">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-base">
                        <i class="fas {{ $val->icon ?: 'fa-award' }}"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black">Edit Nilai: {{ $val->title_id }}</h3>
                        <p class="text-[11px] text-blue-100">Perbarui judul, ikon, tema, urutan, atau deskripsi bilingual pilar ini.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal({{ $val->id }})" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('admin.organization-values.update', $val->id) }}" method="POST" onsubmit="if(window.tinymce){tinymce.triggerSave();}" class="p-6 space-y-4 overflow-y-auto flex-1">
                @csrf
                @method('PUT')
                <input type="hidden" name="active_tab" value="nilai">

                <!-- Row 1: Titles (ID & EN) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">
                            Judul Nilai (Bahasa Indonesia) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ $val->title_id }}" required class="w-full px-3.5 py-2.5 text-xs border border-gray-300 rounded-xl focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">
                            Judul Nilai (English)
                        </label>
                        <input type="text" name="title_en" value="{{ $val->title_en }}" class="w-full px-3.5 py-2.5 text-xs border border-gray-300 rounded-xl focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                    </div>
                </div>

                <!-- Row 2: Icon, Theme, Order -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">
                            Simbol Ikon FontAwesome <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-xl bg-gray-100 border border-gray-300 flex items-center justify-center text-sm text-gray-700 shrink-0" id="edit-icon-preview-{{ $val->id }}">
                                <i class="fas {{ $val->icon ?: 'fa-award' }}"></i>
                            </div>
                            <input type="text" name="icon" id="edit-icon-input-{{ $val->id }}" value="{{ $val->icon ?: 'fa-award' }}" required oninput="document.getElementById('edit-icon-preview-{{ $val->id }}').innerHTML = '<i class=\'fas ' + this.value + '\'></i>'" class="w-full px-3 py-2 text-xs font-mono border border-gray-300 rounded-xl focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                        </div>
                        <!-- Quick Pick Icons -->
                        <div class="flex flex-wrap gap-1 mt-1.5">
                            @foreach($presetIcons as $ico)
                                <button type="button" onclick="setEditIcon({{ $val->id }}, '{{ $ico }}')" class="w-6 h-6 rounded bg-gray-100 hover:bg-blue-50 hover:text-blue-700 text-gray-600 text-[10px] flex items-center justify-center border border-gray-200 transition" title="{{ $ico }}">
                                    <i class="fas {{ $ico }}"></i>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">
                            Tema Warna Kartu
                        </label>
                        <select name="theme" class="w-full px-3.5 py-2.5 text-xs border border-gray-300 rounded-xl focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none bg-white">
                            <option value="emerald" {{ $val->theme === 'emerald' ? 'selected' : '' }}>Emerald (Hijau Pesisir)</option>
                            <option value="blue" {{ $val->theme === 'blue' ? 'selected' : '' }}>Blue (Biru Samudra)</option>
                            <option value="amber" {{ $val->theme === 'amber' ? 'selected' : '' }}>Amber (Kuning / Oranye)</option>
                            <option value="purple" {{ $val->theme === 'purple' ? 'selected' : '' }}>Purple (Ungu Mewah)</option>
                            <option value="teal" {{ $val->theme === 'teal' ? 'selected' : '' }}>Teal (Tosca Ekosistem)</option>
                            <option value="rose" {{ $val->theme === 'rose' ? 'selected' : '' }}>Rose (Merah Dinamis)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">
                            Urutan Tampilan
                        </label>
                        <input type="number" name="order" value="{{ $val->order }}" min="1" class="w-full px-3.5 py-2.5 text-xs border border-gray-300 rounded-xl focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                    </div>
                </div>

                <!-- Row 3: Deskripsi ID with Rich Text Editor -->
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1 flex items-center justify-between">
                        <span>Deskripsi Nilai (Bahasa Indonesia) <span class="text-red-500">*</span></span>
                        <span class="text-[10px] text-emerald-700 font-semibold flex items-center gap-1"><i class="fas fa-wand-magic-sparkles"></i> Rich Text Editor</span>
                    </label>
                    <textarea name="description" id="edit_val_desc_id_{{ $val->id }}" class="modal-rich-editor w-full border border-gray-300 rounded-xl p-3 text-xs" rows="4">{!! $val->description_id !!}</textarea>
                </div>

                <!-- Row 4: Deskripsi EN with Rich Text Editor -->
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1 flex items-center justify-between">
                        <span>Deskripsi Nilai (English Translation)</span>
                        <span class="text-[10px] text-blue-700 font-semibold flex items-center gap-1"><i class="fas fa-wand-magic-sparkles"></i> Rich Text Editor</span>
                    </label>
                    <textarea name="description_en" id="edit_val_desc_en_{{ $val->id }}" class="modal-rich-editor w-full border border-gray-300 rounded-xl p-3 text-xs" rows="4">{!! $val->description_en !!}</textarea>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-200">
                    <button type="button" onclick="closeEditModal({{ $val->id }})" class="px-4 py-2.5 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-xs font-extrabold bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<style>
    .tox-tinymce-aux {
        z-index: 99999 !important;
    }
</style>

<script>
    function initTinyMCEForElement(elId) {
        if (!window.tinymce) return;
        const el = document.getElementById(elId);
        if (!el || tinymce.get(elId)) return;

        tinymce.init({
            target: el,
            height: 200,
            menubar: false,
            plugins: 'advlist autolink lists link charmap preview searchreplace code wordcount',
            toolbar: 'undo redo | blocks fontfamily | bold italic underline forecolor | bullist numlist | alignleft aligncenter alignright | removeformat | code',
            content_style: 'body { font-family: "Plus Jakarta Sans", -apple-system, sans-serif; font-size: 13px; line-height: 1.6; color: #1f2937; }',
            branding: false,
            promotion: false,
            setup: function(editor) {
                editor.on('change keyup NodeChange blur', function() {
                    editor.save();
                });
            }
        });
    }

    function openModalAddValue() {
        const modal = document.getElementById('modal-add-value');
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            initTinyMCEForElement('add_value_description');
            initTinyMCEForElement('add_value_description_en');
        }, 60);
    }

    function closeModalAddValue() {
        const modal = document.getElementById('modal-add-value');
        if (modal) modal.classList.add('hidden');
    }

    function openEditModal(id) {
        const modal = document.getElementById('modal-edit-value-' + id);
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            initTinyMCEForElement('edit_val_desc_id_' + id);
            initTinyMCEForElement('edit_val_desc_en_' + id);
        }, 60);
    }

    function closeEditModal(id) {
        const modal = document.getElementById('modal-edit-value-' + id);
        if (modal) modal.classList.add('hidden');
    }

    function setAddIcon(iconClass) {
        const input = document.getElementById('add-icon-input');
        const preview = document.getElementById('add-icon-preview');
        if (input) input.value = iconClass;
        if (preview) preview.innerHTML = '<i class="fas ' + iconClass + '"></i>';
    }

    function setEditIcon(id, iconClass) {
        const input = document.getElementById('edit-icon-input-' + id);
        const preview = document.getElementById('edit-icon-preview-' + id);
        if (input) input.value = iconClass;
        if (preview) preview.innerHTML = '<i class="fas ' + iconClass + '"></i>';
    }

    function initTinyMCEForPanel(panelId) {
        if (!window.tinymce) return;

        const panel = document.getElementById(panelId);
        if (!panel) return;

        panel.querySelectorAll('textarea.setting-editor').forEach(el => {
            const editorId = el.id;
            if (!editorId) return;

            // If editor already initialized, skip
            if (tinymce.get(editorId)) return;

            tinymce.init({
                target: el,
                height: 220,
                menubar: false,
                plugins: 'advlist autolink lists link charmap preview searchreplace code wordcount',
                toolbar: 'undo redo | blocks fontfamily | bold italic underline forecolor | bullist numlist | alignleft aligncenter alignright | removeformat | code',
                content_style: 'body { font-family: "Plus Jakarta Sans", -apple-system, sans-serif; font-size: 13px; line-height: 1.6; color: #1f2937; }',
                branding: false,
                promotion: false,
                setup: function(editor) {
                    editor.on('change keyup NodeChange blur', function() {
                        editor.save();
                    });
                }
            });
        });
    }

    function switchCategoryTab(tabId) {
        // Hide all panels
        document.querySelectorAll('.category-panel').forEach(panel => {
            panel.classList.add('hidden');
        });

        // Show active panel
        const activePanel = document.getElementById('panel-' + tabId);
        if (activePanel) {
            activePanel.classList.remove('hidden');
            // Initialize TinyMCE editors for this panel if not yet initialized
            setTimeout(() => {
                initTinyMCEForPanel('panel-' + tabId);
            }, 60);
        }

        // Update tab buttons style
        document.querySelectorAll('.category-tab-btn').forEach(btn => {
            btn.className = 'category-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold transition flex items-center gap-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900';
            const badge = btn.querySelector('span:last-child');
            if (badge) {
                badge.className = 'text-[10px] px-1.5 py-0.2 rounded-full bg-gray-200 text-gray-700';
            }
        });

        const activeBtn = document.getElementById('tab-btn-' + tabId);
        if (activeBtn) {
            activeBtn.className = 'category-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold transition flex items-center gap-2 bg-brand-green text-white shadow-sm';
            const badge = activeBtn.querySelector('span:last-child');
            if (badge) {
                badge.className = 'text-[10px] px-1.5 py-0.2 rounded-full bg-white/20 text-white';
            }
        }

        // Sync URL query without reloading
        const url = new URL(window.location);
        url.searchParams.set('tab', tabId);
        window.history.replaceState({}, '', url);

        // Update hidden active_tab inputs in forms
        document.querySelectorAll('input[name="active_tab"]').forEach(input => {
            input.value = tabId;
        });
    }

    function filterSettings(keyword) {
        keyword = keyword.toLowerCase().trim();
        const cards = document.querySelectorAll('.setting-item-card');

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const key = card.getAttribute('data-setting-key') || '';
            if (keyword === '' || text.includes(keyword) || key.toLowerCase().includes(keyword)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Close modals on Escape key or backdrop click
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalAddValue();
            document.querySelectorAll('[id^="modal-edit-value-"]').forEach(m => m.classList.add('hidden'));
        }
    });

    document.querySelectorAll('#modal-add-value, [id^="modal-edit-value-"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    });
</script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initialTab = '{{ $activeTab }}';
        initTinyMCEForPanel('panel-' + initialTab);
    });
</script>
@endsection
