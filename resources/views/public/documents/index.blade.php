@extends('public.layout.app')

@section('title', db_trans('meta_doc_title', 'Dokumen & Publikasi', 'Documents & Publications') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_doc_desc', 'Akses laporan tahunan (Annual Report), dokumen kebijakan, laporan keuangan, dan riset ketangguhan pesisir Yayasan LINTASAN secara transparan.', 'Access annual reports, policy documents, financial reports, and coastal resilience research published by Yayasan LINTASAN.'))

@section('content')
<div class="bg-gray-50/70 py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <!-- Page Header -->
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 text-brand-green border border-emerald-200/60 mb-3">
                <i class="fas fa-file-shield text-xs"></i>
                <span>{{ db_trans('doc_badge', 'Transparansi & Akuntabilitas', 'Transparency & Accountability') }}</span>
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight leading-tight">
                {{ db_trans('doc_title', 'Dokumen & Publikasi Resmi', 'Official Documents & Publications') }}
            </h1>
            <div class="h-1.5 w-14 bg-brand-yellow mx-auto rounded-full mt-3.5 mb-4"></div>
            <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                {{ db_trans('doc_desc', 'Unduh laporan tahunan (Annual Report), laporan pertanggungjawaban program, serta modul pembelajaran ketangguhan ekosistem pesisir kami secara terbuka.', 'Download annual reports, program accountability documents, and coastal ecosystem resilience learning modules openly.') }}
            </p>
        </div>

        <!-- Featured Spotlight Card (If Latest Annual Report exists) -->
        @if($featuredReport && !request()->hasAny(['search', 'category', 'year']))
            <div class="bg-gradient-to-br from-[#0a2016] via-[#004D2E] to-brand-green rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
                <div class="absolute right-10 top-10 opacity-10 text-8xl pointer-events-none">
                    <i class="fas fa-book-bookmark"></i>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center relative z-10">
                    <!-- Featured Book Cover -->
                    <div class="md:col-span-4 flex justify-center">
                        <div class="relative w-44 sm:w-52 aspect-[1/1.414] rounded-2xl overflow-hidden shadow-2xl border-2 border-white/20 bg-gray-900 transform md:-rotate-2 hover:rotate-0 transition-transform duration-300 group">
                            @if($featuredReport->cover_path)
                                <img src="{{ $featuredReport->cover_url }}" alt="{{ $featuredReport->title }}" class="w-full h-full object-cover object-top">
                            @else
                                <div class="w-full h-full bg-emerald-900 flex flex-col items-center justify-center p-4 text-center">
                                    <i class="fas {{ $featuredReport->icon_class }} text-4xl text-brand-yellow mb-2"></i>
                                    <span class="text-xs font-black uppercase text-white">{{ $featuredReport->category }}</span>
                                </div>
                            @endif
                            <div class="absolute left-0 top-0 bottom-0 w-3 bg-gradient-to-r from-black/40 via-black/15 to-transparent pointer-events-none"></div>
                            <span class="absolute top-2 right-2 px-2 py-0.5 rounded text-[9px] font-black uppercase bg-brand-yellow text-gray-950 shadow">
                                TERBARU
                            </span>
                        </div>
                    </div>

                    <!-- Featured Info -->
                    <div class="md:col-span-8 space-y-4">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-white/15 text-emerald-200 border border-white/10">
                                {{ $featuredReport->category }}
                            </span>
                            @if($featuredReport->year)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-brand-yellow/20 text-brand-yellow border border-brand-yellow/30">
                                    <i class="far fa-clock mr-1"></i> Edisi {{ $featuredReport->year }}
                                </span>
                            @endif
                            <span class="text-xs text-gray-300">
                                <i class="fas fa-download mr-1"></i> {{ number_format($featuredReport->downloads_count) }} kali diunduh
                            </span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-black text-white leading-tight">
                            {{ $featuredReport->title }}
                        </h2>

                        @if($featuredReport->description)
                            <p class="text-emerald-100/90 text-xs sm:text-sm leading-relaxed max-w-2xl">
                                {{ Str::limit($featuredReport->description, 220) }}
                            </p>
                        @endif

                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="{{ route('public.documents.download', $featuredReport->slug) }}" class="inline-flex items-center gap-2 bg-brand-yellow hover:bg-yellow-400 text-gray-950 text-xs sm:text-sm font-black px-6 py-3 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0">
                                <i class="fas fa-file-arrow-down text-sm"></i>
                                <span>{{ db_trans('doc_btn_download', 'Unduh Berkas Lengkap', 'Download Full Report') }} ({{ $featuredReport->formatted_file_size }})</span>
                            </a>
                            <button type="button" onclick="openPublicViewer('{{ $featuredReport->title }}', '{{ route('public.documents.preview', $featuredReport->slug) }}', '{{ $featuredReport->file_type }}')" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-bold px-5 py-3 rounded-xl border border-white/20 transition">
                                <i class="fas fa-eye text-sm"></i>
                                <span>{{ db_trans('doc_btn_read', 'Baca Pratinjau', 'Read Preview') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filter, Category Pills & Search Bar -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-gray-150 shadow-sm space-y-4">
            <!-- Category Pills Scrollable -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                <a href="{{ route('public.documents.index', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition {{ $activeCategory === 'all' ? 'bg-brand-green text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ db_trans('doc_filter_all', 'Semua Dokumen', 'All Documents') }} ({{ $totalDocuments }})
                </a>
                @foreach($categories as $cat => $count)
                    <a href="{{ route('public.documents.index', array_merge(request()->except('category', 'page'), ['category' => $cat])) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition {{ $activeCategory === $cat ? 'bg-brand-green text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $cat }} <span class="opacity-75">({{ $count }})</span>
                    </a>
                @endforeach
            </div>

            <!-- Search & Year Filter Form -->
            <form method="GET" action="{{ route('public.documents.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-3 border-t border-gray-100 items-center">
                @if($activeCategory !== 'all')
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif

                <!-- Search Input -->
                <div class="sm:col-span-8 relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ db_trans('doc_search_ph', 'Cari judul laporan, topik riset, atau kata kunci...', 'Search report title, research topic, or keywords...') }}" class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-900 focus:outline-none focus:border-brand-green">
                </div>

                <!-- Year Dropdown -->
                <div class="sm:col-span-3">
                    <select name="year" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-700 focus:outline-none focus:border-brand-green bg-white">
                        <option value="all">{{ db_trans('doc_all_years', 'Semua Tahun', 'All Years') }}</option>
                        @foreach($years as $yr)
                            <option value="{{ $yr }}" {{ $activeYear == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit / Reset -->
                <div class="sm:col-span-1 flex items-center gap-1">
                    <button type="submit" title="Terapkan" class="w-full bg-brand-green hover:bg-brand-darkgreen text-white text-xs font-bold py-2.5 px-3 rounded-xl transition flex items-center justify-center shadow-xs">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    @if(request()->hasAny(['search', 'year', 'category']))
                        <a href="{{ route('public.documents.index') }}" title="Reset" class="p-2.5 rounded-xl border border-gray-200 text-gray-400 hover:text-red-500 hover:bg-red-50 transition">
                            <i class="fas fa-rotate-left text-xs"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Document Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($documents as $doc)
                <!-- Document Card -->
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-150 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Cover Display with 3D Book Spine Effect -->
                        <div class="relative bg-gradient-to-b from-gray-100 to-gray-200 p-6 flex items-center justify-center overflow-hidden border-b border-gray-100">
                            <!-- Background Blurred Glow -->
                            @if($doc->cover_path)
                                <div class="absolute inset-0 bg-cover bg-center blur-xl opacity-20 scale-125" style="background-image: url('{{ $doc->cover_url }}');"></div>
                            @endif

                            <!-- Book Cover -->
                            <div class="relative w-36 sm:w-40 aspect-[1/1.414] rounded-xl overflow-hidden shadow-xl border border-gray-200/80 bg-white group-hover:scale-105 transition-transform duration-300">
                                @if($doc->cover_path)
                                    <img src="{{ $doc->cover_url }}" alt="{{ $doc->title }}" class="w-full h-full object-cover object-top">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-900 to-[#0a2016] text-white flex flex-col items-center justify-center p-3 text-center">
                                        <i class="fas {{ $doc->icon_class }} text-3xl mb-2 text-brand-yellow"></i>
                                        <span class="text-[9px] font-black uppercase tracking-wider text-emerald-200 leading-tight">{{ $doc->category }}</span>
                                        @if($doc->year)
                                            <span class="text-[11px] font-bold text-white mt-1">{{ $doc->year }}</span>
                                        @endif
                                    </div>
                                @endif
                                <!-- Spine Shadow -->
                                <div class="absolute left-0 top-0 bottom-0 w-2.5 bg-gradient-to-r from-black/30 via-black/10 to-transparent pointer-events-none"></div>
                            </div>

                            <!-- File Type Badge -->
                            <span class="absolute top-3.5 right-3.5 px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-white/90 backdrop-blur-xs text-gray-800 border border-gray-200 shadow-xs flex items-center gap-1">
                                <i class="fas {{ $doc->icon_class }}"></i>
                                <span>{{ strtoupper($doc->file_type) }}</span>
                            </span>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 sm:p-6 space-y-3">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $doc->category_badge_class }}">
                                    {{ $doc->category }}
                                </span>
                                @if($doc->year)
                                    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">
                                        {{ $doc->year }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-extrabold text-base text-gray-900 group-hover:text-brand-green transition-colors leading-snug line-clamp-2" title="{{ $doc->title }}">
                                {{ $doc->title }}
                            </h3>

                            @if($doc->description)
                                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                    {{ $doc->description }}
                                </p>
                            @endif

                            <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                                <span><i class="fas fa-hard-drive mr-1"></i> {{ $doc->formatted_file_size }}</span>
                                <span><i class="fas fa-download mr-1"></i> {{ number_format($doc->downloads_count) }} unduhan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="p-5 sm:p-6 pt-0 grid grid-cols-2 gap-2">
                        <!-- Read / Preview -->
                        <button type="button" onclick="openPublicViewer('{{ addslashes($doc->title) }}', '{{ route('public.documents.preview', $doc->slug) }}', '{{ $doc->file_type }}')" class="w-full bg-gray-50 hover:bg-emerald-50 text-gray-700 hover:text-brand-green border border-gray-200 hover:border-emerald-300 text-xs font-bold py-2.5 px-3 rounded-xl transition flex items-center justify-center gap-1.5">
                            <i class="fas fa-eye text-xs"></i>
                            <span>{{ db_trans('doc_btn_view', 'Baca', 'View') }}</span>
                        </button>

                        <!-- Download -->
                        <a href="{{ route('public.documents.download', $doc->slug) }}" class="w-full bg-brand-green hover:bg-brand-darkgreen text-white text-xs font-bold py-2.5 px-3 rounded-xl shadow-xs transition flex items-center justify-center gap-1.5">
                            <i class="fas fa-download text-xs"></i>
                            <span>{{ db_trans('doc_btn_download_short', 'Unduh', 'Download') }}</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-gray-150 p-8">
                    <div class="w-16 h-16 rounded-2xl bg-gray-50 text-gray-300 flex items-center justify-center text-3xl mx-auto mb-4 border border-gray-100">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">
                        {{ db_trans('doc_empty_title', 'Tidak Ada Dokumen yang Ditemukan', 'No Documents Found') }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                        {{ db_trans('doc_empty_desc', 'Coba ubah kata kunci pencarian atau pilih kategori lain.', 'Try changing the search keywords or selecting another category.') }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('public.documents.index') }}" class="text-xs font-bold text-brand-green hover:underline">
                            {{ db_trans('doc_reset_all', 'Tampilkan Semua Dokumen', 'Show All Documents') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($documents->hasPages())
            <div class="pt-4 flex justify-center">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Public PDF / Doc Viewer -->
<div id="publicDocViewerModal" class="fixed inset-0 z-50 bg-black/75 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-6">
    <div class="bg-white rounded-2xl w-full max-w-4xl h-[90vh] flex flex-col shadow-2xl overflow-hidden relative animate-scaleUp">
        <!-- Modal Header -->
        <div class="p-4 sm:px-6 bg-gray-900 text-white flex items-center justify-between shrink-0">
            <div class="min-w-0 pr-4">
                <span class="text-[10px] font-black uppercase text-brand-yellow tracking-wider" id="viewerBadge">DOKUMEN</span>
                <h3 class="text-sm sm:text-base font-bold text-white truncate" id="viewerDocTitle">Judul Dokumen</h3>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a id="viewerDownloadBtn" href="#" class="bg-brand-green hover:bg-brand-darkgreen text-white text-xs font-bold px-3 py-1.5 rounded-lg transition flex items-center gap-1 shadow-xs">
                    <i class="fas fa-download text-[10px]"></i>
                    <span class="hidden sm:inline">Unduh</span>
                </a>
                <button type="button" onclick="closePublicViewer()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-gray-300 hover:text-white flex items-center justify-center transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Modal Iframe / Viewer Body -->
        <div class="flex-1 bg-gray-100 relative">
            <iframe id="viewerFrame" src="" class="w-full h-full border-0"></iframe>
            <div id="viewerDocFallback" class="hidden absolute inset-0 bg-white flex-col items-center justify-center p-6 text-center space-y-3">
                <i class="fas fa-file-word text-5xl text-blue-600 mb-2"></i>
                <h4 class="text-sm font-bold text-gray-900">Pratinjau Langsung Berkas Word / Non-PDF</h4>
                <p class="text-xs text-gray-500 max-w-md">Format berkas ini dapat dibuka secara optimal melalui aplikasi Microsoft Word atau diunduh langsung ke perangkat Anda.</p>
                <a id="viewerFallbackDownload" href="#" class="inline-flex items-center gap-2 bg-brand-green text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm hover:bg-brand-darkgreen transition">
                    <i class="fas fa-download"></i> Unduh Berkas Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function openPublicViewer(title, previewUrl, fileType) {
        document.getElementById('viewerDocTitle').innerText = title;
        document.getElementById('viewerBadge').innerText = (fileType || 'PDF').toUpperCase();
        document.getElementById('viewerDownloadBtn').href = previewUrl.replace('/lihat/', '/unduh/');

        const iframe = document.getElementById('viewerFrame');
        const fallback = document.getElementById('viewerDocFallback');

        if (fileType && fileType.toLowerCase() === 'pdf') {
            iframe.src = previewUrl;
            iframe.classList.remove('hidden');
            fallback.classList.add('hidden');
            fallback.classList.remove('flex');
        } else {
            iframe.classList.add('hidden');
            fallback.classList.remove('hidden');
            fallback.classList.add('flex');
            document.getElementById('viewerFallbackDownload').href = previewUrl.replace('/lihat/', '/unduh/');
        }

        const modal = document.getElementById('publicDocViewerModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePublicViewer() {
        const modal = document.getElementById('publicDocViewerModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('viewerFrame').src = '';
    }
</script>
@endsection
@endsection
