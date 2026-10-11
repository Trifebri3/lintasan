@extends('admin.layout.app')

@section('title', 'Kelola Dokumen & Laporan - Admin LINTASAN')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-brand-green border border-emerald-200/60">
                    <i class="fas fa-file-pdf mr-1 text-red-500"></i> Publikasi & Laporan
                </span>
                <span class="text-gray-300">•</span>
                <span class="text-xs font-semibold text-gray-500">{{ $stats['total'] }} Dokumen Tersimpan</span>
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Kelola Dokumen & Laporan</h1>
            <p class="text-xs text-gray-500 mt-1">Unggah PDF atau Word dengan ekstraksi cover otomatis halaman 1, kelola Annual Report, modul riset, dan laporan publik.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('public.documents.index') }}" target="_blank" class="bg-white border border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 text-xs font-bold px-3.5 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-xs">
                <i class="fas fa-arrow-up-right-from-square text-gray-400"></i> Lihat di Web Publik
            </a>
            <a href="{{ route('admin.documents.create') }}" class="bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-brand-darkgreen shadow-sm hover:shadow transition flex items-center gap-1.5 transform hover:-translate-y-0.5 active:translate-y-0">
                <i class="fas fa-cloud-arrow-up text-sm"></i>
                <span>Unggah Dokumen Baru</span>
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-circle-check text-emerald-600 text-base shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- 1. Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Dokumen -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Dokumen</span>
                <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ number_format($stats['total']) }}</span>
                <span class="text-[11px] text-gray-400 mt-1 block">Arsip publik & internal</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-brand-green flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-folder-open"></i>
            </div>
        </div>

        <!-- Annual Reports -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Laporan Tahunan</span>
                <span class="text-3xl font-black text-emerald-700 block tracking-tight">{{ number_format($stats['annual_reports']) }}</span>
                <span class="text-[11px] text-emerald-600 font-bold mt-1 block">Annual Report Resmi</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-award"></i>
            </div>
        </div>

        <!-- Total Unduhan -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Unduhan</span>
                <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ number_format($stats['total_downloads']) }}</span>
                <span class="text-[11px] text-blue-600 font-bold mt-1 block">Kali diunduh pengunjung</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-download"></i>
            </div>
        </div>

        <!-- Dokumen Aktif Terbit -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Status Publikasi</span>
                <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ number_format($stats['published']) }}</span>
                <span class="text-[11px] text-gray-400 mt-1 block">Aktif tayang di situs publik</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <!-- 2. Filter & Search Controls -->
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin.documents.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 items-center">
            <!-- Search -->
            <div class="lg:col-span-5 relative">
                <i class="fas fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul dokumen, nama file, atau kata kunci..." class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand-green">
            </div>

            <!-- Category -->
            <div class="lg:col-span-3">
                <select name="category" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-700 focus:outline-none focus:border-brand-green bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Year -->
            <div class="lg:col-span-2">
                <select name="year" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-700 focus:outline-none focus:border-brand-green bg-white">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $yr)
                        <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Actions -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 bg-brand-green hover:bg-brand-darkgreen text-white text-xs font-bold py-2.5 px-3 rounded-xl transition flex items-center justify-center gap-1.5 shadow-xs">
                    <i class="fas fa-filter text-[11px]"></i> Filter
                </button>
                @if(request()->hasAny(['search', 'category', 'year', 'status']))
                    <a href="{{ route('admin.documents.index') }}" title="Reset Filter" class="p-2.5 rounded-xl border border-gray-200 text-gray-400 hover:text-red-500 hover:bg-red-50 transition">
                        <i class="fas fa-rotate-left text-xs"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- 3. Documents Table / Cards -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($documents->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-emerald-50 text-brand-green flex items-center justify-center text-2xl shadow-inner">
                    <i class="fas fa-file-circle-plus"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800">Belum Ada Dokumen yang Diunggah</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Mulai tambahkan dokumen pertama Anda seperti Annual Report, Laporan Tahunan, atau modul panduan kerja.</p>
                <div class="mt-5">
                    <a href="{{ route('admin.documents.create') }}" class="inline-flex items-center gap-2 bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-brand-darkgreen shadow-sm transition">
                        <i class="fas fa-plus"></i> Unggah Dokumen Sekarang
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-150 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-3.5 px-4 w-12 text-center">#</th>
                            <th class="py-3.5 px-4 w-24">Cover</th>
                            <th class="py-3.5 px-4">Judul Dokumen & Keterangan</th>
                            <th class="py-3.5 px-4 w-36">Kategori & Tahun</th>
                            <th class="py-3.5 px-4 w-32">Berkas & Ukuran</th>
                            <th class="py-3.5 px-4 w-24 text-center">Unduhan</th>
                            <th class="py-3.5 px-4 w-28 text-center">Status</th>
                            <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($documents as $index => $doc)
                            <tr class="hover:bg-emerald-50/20 transition-colors">
                                <!-- Index -->
                                <td class="py-4 px-4 text-center font-bold text-gray-400">
                                    {{ $documents->firstItem() + $index }}
                                </td>

                                <!-- Cover Thumbnail -->
                                <td class="py-4 px-4">
                                    <div class="relative group w-16 h-22 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 shadow-xs flex items-center justify-center shrink-0">
                                        @if($doc->cover_path)
                                            <img src="{{ $doc->cover_url }}" alt="{{ $doc->title }}" class="w-full h-full object-cover object-top transition duration-200 group-hover:scale-105">
                                        @else
                                            <div class="flex flex-col items-center justify-center p-1 text-center">
                                                <i class="fas {{ $doc->icon_class }} text-2xl mb-1"></i>
                                                <span class="text-[8px] font-bold text-gray-400 uppercase tracking-tighter">{{ strtoupper($doc->file_type) }}</span>
                                            </div>
                                        @endif
                                        <button type="button" onclick="previewDocModal('{{ $doc->title }}', '{{ $doc->cover_url }}', '{{ $doc->file_url }}', '{{ strtoupper($doc->file_type) }}')" title="Pratinjau Cover" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>

                                <!-- Title & Details -->
                                <td class="py-4 px-4">
                                    <div class="max-w-md">
                                        <h3 class="font-bold text-gray-900 text-sm leading-snug hover:text-brand-green transition">
                                            <a href="{{ route('admin.documents.edit', $doc->id) }}">{{ $doc->title }}</a>
                                        </h3>
                                        @if($doc->description)
                                            <p class="text-[11px] text-gray-500 mt-1 line-clamp-2 leading-relaxed">
                                                {{ Str::limit($doc->description, 120) }}
                                            </p>
                                        @endif
                                        <div class="flex items-center gap-2 mt-2 text-[10px] text-gray-400">
                                            <span><i class="far fa-calendar mr-1"></i> {{ $doc->published_at ? $doc->published_at->format('d M Y') : $doc->created_at->format('d M Y') }}</span>
                                            <span>•</span>
                                            <span class="font-mono text-gray-500 truncate max-w-[180px]" title="{{ $doc->file_name }}">
                                                <i class="fas fa-paperclip mr-1"></i> {{ $doc->file_name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category & Year -->
                                <td class="py-4 px-4">
                                    <div class="space-y-1.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $doc->category_badge_class }}">
                                            {{ $doc->category }}
                                        </span>
                                        @if($doc->year)
                                            <div>
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded-md">
                                                    <i class="far fa-clock text-gray-400"></i> Tahun {{ $doc->year }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- File type & size -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center shrink-0">
                                            <i class="fas {{ $doc->icon_class }} text-sm"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-800 uppercase text-[10px]">{{ strtoupper($doc->file_type) }}</span>
                                            <div class="text-[10px] text-gray-400">{{ $doc->formatted_file_size }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Downloads count -->
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-extrabold text-[11px]">
                                        <i class="fas fa-download text-[9px]"></i>
                                        <span>{{ number_format($doc->downloads_count) }}</span>
                                    </div>
                                </td>

                                <!-- Published Status Toggle -->
                                <td class="py-4 px-4 text-center">
                                    <form action="{{ route('admin.documents.toggle_publish', $doc->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" title="Klik untuk mengubah status" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition {{ $doc->is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-gray-100 text-gray-500 border border-gray-200 hover:bg-gray-200' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $doc->is_published ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                            <span>{{ $doc->is_published ? 'Terbit' : 'Draft' }}</span>
                                        </button>
                                    </form>
                                </td>

                                <!-- Action Buttons -->
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <!-- Download -->
                                        <a href="{{ route('public.documents.download', $doc->slug) }}" title="Unduh Berkas" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-600 hover:text-blue-600 border border-gray-200 flex items-center justify-center transition">
                                            <i class="fas fa-download text-xs"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.documents.edit', $doc->id) }}" title="Edit Dokumen" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-emerald-50 text-gray-600 hover:text-brand-green border border-gray-200 flex items-center justify-center transition">
                                            <i class="fas fa-pen-to-square text-xs"></i>
                                        </a>

                                        <!-- Delete -->
                                        <button type="button" onclick="confirmDeleteModal('{{ $doc->id }}', '{{ addslashes($doc->title) }}')" title="Hapus Dokumen" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-600 hover:text-red-600 border border-gray-200 flex items-center justify-center transition">
                                            <i class="fas fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($documents->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $documents->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal Preview Cover & File -->
<div id="previewDocModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-scaleUp">
        <button onclick="closeDocModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
            <i class="fas fa-times"></i>
        </button>
        <div class="text-center mb-4">
            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-50 text-brand-green mb-1" id="modalDocType">DOKUMEN</span>
            <h3 class="text-base font-black text-gray-900" id="modalDocTitle">Pratinjau Dokumen</h3>
        </div>
        <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50 mb-5 max-h-[350px] flex items-center justify-center">
            <img id="modalDocImage" src="" alt="Cover" class="max-h-[350px] w-auto object-contain mx-auto">
        </div>
        <div class="flex items-center gap-2">
            <a id="modalDocLink" href="#" target="_blank" class="flex-1 bg-brand-green hover:bg-brand-darkgreen text-white text-xs font-bold py-2.5 px-4 rounded-xl text-center shadow-xs transition">
                <i class="fas fa-arrow-up-right-from-square mr-1"></i> Buka / Baca Berkas Langsung
            </a>
            <button onclick="closeDocModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold py-2.5 px-4 rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl text-center animate-scaleUp">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl mx-auto mb-4">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <h3 class="text-base font-black text-gray-900">Hapus Dokumen?</h3>
        <p class="text-xs text-gray-500 mt-2">Dokumen "<span id="deleteDocTitle" class="font-bold text-gray-700"></span>" beserta berkas dan gambarnya akan dihapus permanen dari server.</p>
        <form id="deleteDocForm" action="" method="POST" class="mt-5 flex gap-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold py-2.5 rounded-xl transition">
                Batal
            </button>
            <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2.5 rounded-xl transition shadow-xs">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function previewDocModal(title, coverUrl, fileUrl, fileType) {
        document.getElementById('modalDocTitle').innerText = title;
        document.getElementById('modalDocType').innerText = fileType;
        const imgEl = document.getElementById('modalDocImage');
        if (coverUrl && coverUrl !== '') {
            imgEl.src = coverUrl;
            imgEl.style.display = 'block';
        } else {
            imgEl.style.display = 'none';
        }
        document.getElementById('modalDocLink').href = fileUrl;
        const modal = document.getElementById('previewDocModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDocModal() {
        const modal = document.getElementById('previewDocModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function confirmDeleteModal(id, title) {
        document.getElementById('deleteDocTitle').innerText = title;
        document.getElementById('deleteDocForm').action = '/admin/documents/' + id;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
@endsection
