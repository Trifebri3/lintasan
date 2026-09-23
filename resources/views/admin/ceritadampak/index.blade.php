@extends('admin.layout.app')

@section('title', 'Kelola Cerita Lapangan - Admin LINTASAN')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-orange-50 text-brand-orange border border-orange-200/60">
                    <i class="fas fa-newspaper mr-1"></i> Publikasi & Berita
                </span>
                <span class="text-gray-300">•</span>
                <span class="text-xs font-semibold text-gray-500">{{ $stories->count() }} Cerita</span>
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Kelola Cerita Lapangan</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola artikel dampak, pantau grafik pembaca, serta bagikan tautan ke media sosial secara instan.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.stories.template') }}" class="bg-white border border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1 shadow-xs">
                <i class="fas fa-download text-gray-400"></i> Template
            </a>
            <a href="{{ route('admin.stories.export') }}" class="bg-white border border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1 shadow-xs">
                <i class="fas fa-file-export text-gray-400"></i> Ekspor
            </a>
            <button onclick="toggleImportModal(true)" class="bg-white border border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1 shadow-xs">
                <i class="fas fa-file-import text-gray-400"></i> Impor
            </button>
            <a href="{{ route('admin.stories.create') }}" class="bg-brand-green text-white text-xs font-bold px-4 py-2 rounded-xl hover:bg-brand-darkgreen shadow-sm transition flex items-center gap-1.5">
                <i class="fas fa-plus"></i> Tambah Cerita
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green rounded-xl p-4 text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-circle-check text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- 1. Performance Overview Cards (Grafik & Kunjungan Summary) -->
    @php
        $totalStoryViews = $stories->sum('views');
        $topStory = $stories->sortByDesc('views')->first();
        $maxStoryViews = max(1, $topStory ? $topStory->views : 1);
        $avgViews = $stories->count() > 0 ? round($totalStoryViews / $stories->count()) : 0;
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Cerita -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Artikel</span>
                <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ $stories->count() }}</span>
                <span class="text-[11px] text-gray-400 mt-1 block">Semua Cerita Lapangan</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-brand-orange flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-book-open"></i>
            </div>
        </div>

        <!-- Total Pembaca (Views) -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Pembaca (Views)</span>
                <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ number_format($totalStoryViews) }}</span>
                <span class="text-[11px] text-brand-green font-bold mt-1 flex items-center gap-1">
                    <i class="fas fa-arrow-trend-up text-[10px]"></i> Total Tayangan Artikel
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-brand-green flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-eye"></i>
            </div>
        </div>

        <!-- Artikel Terpopuler -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div class="min-w-0 pr-2">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Artikel Terpopuler</span>
                <h4 class="text-xs font-bold text-gray-900 truncate max-w-[170px]" title="{{ $topStory ? $topStory->title : '-' }}">
                    {{ $topStory ? $topStory->title : '-' }}
                </h4>
                <span class="text-[11px] font-extrabold text-brand-orange mt-1 block">
                    {{ $topStory ? number_format($topStory->views) : 0 }} kali dibaca
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-xs shrink-0">
                <i class="fas fa-fire"></i>
            </div>
        </div>

        <!-- Rata-rata Pembaca -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Rata-Rata Tayangan</span>
                <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ number_format($avgViews) }}</span>
                <span class="text-[11px] text-gray-400 mt-1 block">Tayangan per cerita</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-chart-simple"></i>
            </div>
        </div>
    </div>

    <!-- 2. Table Stories with Views & Share Actions -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-extrabold text-gray-900 text-sm">Daftar Publikasi Cerita</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Pantau jumlah pembaca, salin tautan artikel untuk promosi, atau bagikan langsung ke media sosial.</p>
            </div>
            <span class="text-xs font-bold text-gray-500 bg-gray-50 px-3 py-1 rounded-lg border border-gray-200">
                {{ $stories->count() }} Cerita Terdaftar
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-gray-400 font-bold uppercase text-[10px]">
                        <th class="p-4 w-16">Foto</th>
                        <th class="p-4">Judul & Ringkasan</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Grafik Pembaca</th>
                        <th class="p-4">Salin & Bagikan</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($stories as $story)
                        @php
                            $viewsCount = $story->views ?? 0;
                            $pct = round(($viewsCount / $maxStoryViews) * 100);
                            $cleanDesc = trim(strip_tags($story->description));
                            $storyUrl = url('/cerita-dampak/' . $story->slug);
                        @endphp
                        <tr class="hover:bg-gray-50/70 transition">
                            <!-- Foto -->
                            <td class="p-4">
                                <div class="w-14 h-14 rounded-xl bg-gray-200 bg-cover bg-center shadow-xs border border-gray-100" style="background-image: url('{{ $story->image_url }}');"></div>
                            </td>

                            <!-- Judul & Ringkasan (Bebas dari tag HTML bocor) -->
                            <td class="p-4">
                                <div class="max-w-[320px]">
                                    <h4 class="font-bold text-gray-900 text-xs hover:text-brand-green transition leading-snug line-clamp-1">
                                        {{ $story->title }}
                                    </h4>
                                    <p class="text-[11px] text-gray-500 font-normal line-clamp-2 mt-1 leading-relaxed">
                                        {{ $cleanDesc }}
                                    </p>
                                    @if($story->slug)
                                        <span class="text-[9px] text-gray-400 font-mono mt-1 block truncate">/cerita-dampak/{{ $story->slug }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="p-4">
                                <span class="{{ $story->category_bg }} {{ $story->category_color }} text-[9px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider inline-block">
                                    {{ $story->category }}
                                </span>
                                @if($story->impact_number)
                                    <div class="mt-1.5 text-[10px] text-gray-500">
                                        <strong class="text-brand-green">{{ $story->impact_number }}</strong> {{ $story->impact_label }}
                                    </div>
                                @endif
                            </td>

                            <!-- Grafik Pembaca (Views Visual) -->
                            <td class="p-4">
                                <div class="w-36">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="inline-flex items-center gap-1 font-black text-gray-900 text-xs">
                                            <i class="fas fa-eye text-brand-green text-[10px]"></i> {{ number_format($viewsCount) }}
                                        </span>
                                        <span class="text-[10px] text-gray-400 font-semibold">dibaca</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-brand-green to-emerald-400 h-1.5 rounded-full transition-all duration-500" style="width: {{ max(6, $pct) }}%"></div>
                                    </div>
                                    <span class="text-[9px] text-gray-400 mt-1 block">
                                        @if($pct >= 80)
                                            <span class="text-emerald-600 font-bold"><i class="fas fa-fire text-amber-500"></i> Sangat Populer</span>
                                        @elseif($pct >= 40)
                                            <span class="text-blue-600 font-semibold">Trafik Stabil</span>
                                        @else
                                            <span class="text-gray-400">Aktif</span>
                                        @endif
                                    </span>
                                </div>
                            </td>

                            <!-- Salin & Bagikan (Share) -->
                            <td class="p-4">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <!-- Tombol Salin Tautan -->
                                    <button type="button" 
                                            onclick="copyStoryLink('{{ $storyUrl }}', '{{ addslashes($story->title) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-gray-50 hover:bg-emerald-50 text-gray-700 hover:text-brand-green border border-gray-200 hover:border-emerald-200 text-[11px] font-bold transition shadow-xs group"
                                            title="Salin Tautan Artikel">
                                        <i class="fas fa-link text-[10px] text-gray-400 group-hover:text-brand-green"></i>
                                        <span>Salin</span>
                                    </button>

                                    <!-- Tombol Bagikan (Share) -->
                                    <button type="button" 
                                            onclick="openShareModal('{{ $storyUrl }}', '{{ addslashes($story->title) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-700 hover:text-blue-600 border border-gray-200 hover:border-blue-200 text-[11px] font-bold transition shadow-xs group"
                                            title="Bagikan ke WhatsApp, Medsos, dll">
                                        <i class="fas fa-share-nodes text-[10px] text-gray-400 group-hover:text-blue-600"></i>
                                        <span>Share</span>
                                    </button>

                                    <!-- Tombol Lihat di Web -->
                                    <a href="{{ route('public.stories.show', $story->slug) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-500 hover:text-gray-900 border border-gray-200 text-[10px] transition"
                                       title="Buka Halaman Artikel di Tab Baru">
                                        <i class="fas fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </td>

                            <!-- Aksi (Edit & Hapus) -->
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.stories.edit', $story->id) }}" class="text-blue-600 hover:text-blue-800 font-bold bg-blue-50 hover:bg-blue-100 px-2.5 py-1.5 rounded-lg transition text-[11px] inline-flex items-center gap-1">
                                        <i class="fas fa-edit text-[10px]"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg transition text-[11px] inline-flex items-center gap-1">
                                            <i class="fas fa-trash-can text-[10px]"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">Belum ada cerita lapangan yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Share Cerita Lapangan -->
<div id="share-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity" onclick="closeShareModal()"></div>

        <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md sm:w-full p-6 border border-gray-100">
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fas fa-share-nodes"></i>
                    </div>
                    <h3 class="text-sm font-extrabold text-gray-900">Bagikan Cerita Lapangan</h3>
                </div>
                <button type="button" onclick="closeShareModal()" class="text-gray-400 hover:text-gray-700 text-lg transition">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <div class="mt-4">
                <p id="share-modal-title" class="text-xs font-bold text-gray-800 line-clamp-2 mb-4 bg-gray-50 p-3 rounded-xl border border-gray-100"></p>

                <!-- Tombol Media Sosial -->
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-2.5">Pilih Saluran Bagikan</span>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 mb-5">
                    <!-- WhatsApp -->
                    <a id="share-wa" href="#" target="_blank" class="flex flex-col items-center justify-center p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition group">
                        <i class="fab fa-whatsapp text-2xl text-emerald-600 group-hover:scale-110 transition-transform mb-1"></i>
                        <span class="text-[10px] font-bold">WhatsApp</span>
                    </a>

                    <!-- Facebook -->
                    <a id="share-fb" href="#" target="_blank" class="flex flex-col items-center justify-center p-3 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 transition group">
                        <i class="fab fa-facebook text-2xl text-blue-600 group-hover:scale-110 transition-transform mb-1"></i>
                        <span class="text-[10px] font-bold">Facebook</span>
                    </a>

                    <!-- Twitter / X -->
                    <a id="share-tw" href="#" target="_blank" class="flex flex-col items-center justify-center p-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 border border-gray-300 transition group">
                        <i class="fab fa-x-twitter text-2xl text-gray-800 group-hover:scale-110 transition-transform mb-1"></i>
                        <span class="text-[10px] font-bold">Twitter / X</span>
                    </a>

                    <!-- LinkedIn -->
                    <a id="share-li" href="#" target="_blank" class="flex flex-col items-center justify-center p-3 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 transition group">
                        <i class="fab fa-linkedin text-2xl text-sky-600 group-hover:scale-110 transition-transform mb-1"></i>
                        <span class="text-[10px] font-bold">LinkedIn</span>
                    </a>
                </div>

                <!-- Input Salin Tautan Langsung -->
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Tautan Langsung</span>
                <div class="flex items-center gap-2">
                    <input type="text" id="share-modal-url" readonly class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-xs font-mono text-gray-700 outline-none select-all">
                    <button type="button" onclick="copyFromModal()" class="bg-brand-green hover:bg-brand-darkgreen text-white px-4 py-2 rounded-xl text-xs font-bold transition shrink-0 flex items-center gap-1 shadow-xs">
                        <i class="fas fa-copy"></i>
                        <span>Salin</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Toast Notification -->
<div id="copy-toast" class="fixed bottom-6 right-6 z-50 bg-gray-900/95 backdrop-blur-sm text-white text-xs font-bold px-4 py-3 rounded-xl shadow-2xl flex items-center gap-2.5 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none border border-gray-750">
    <i class="fas fa-circle-check text-brand-green text-sm"></i>
    <span id="toast-message">Tautan cerita berhasil disalin ke clipboard!</span>
</div>

<!-- Import Excel Modal -->
<div id="import-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity" aria-hidden="true" onclick="toggleImportModal(false)"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 p-6">
            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                <h3 class="text-base font-extrabold text-gray-900" id="modal-title">Impor Cerita Lapangan via Excel/CSV</h3>
                <button onclick="toggleImportModal(false)" class="text-gray-400 hover:text-gray-600 text-lg transition"><i class="fas fa-xmark"></i></button>
            </div>
            
            <form action="{{ route('admin.stories.import') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih File Spreadsheet (CSV)</label>
                    <input type="file" name="file" required accept=".csv,.txt" class="w-full border border-gray-200 rounded-lg p-2.5 outline-none focus:border-brand-green text-xs file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                    <p class="text-[10px] text-gray-400 mt-2 leading-relaxed">Pastikan file menggunakan format/template yang sudah diunduh. Kolom 'title_id' wajib diisi.</p>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-2 text-xs font-bold">
                    <button type="button" onclick="toggleImportModal(false)" class="border border-gray-200 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg transition">Batal</button>
                    <button type="submit" class="bg-brand-green text-white hover:bg-brand-darkgreen px-5 py-2 rounded-lg shadow transition">Mulai Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Copy Link & Toast Notification
    function copyStoryLink(url, title) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(showToast).catch(() => fallbackCopy(url));
        } else {
            fallbackCopy(url);
        }
    }

    function fallbackCopy(text) {
        const tempInput = document.createElement("input");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        showToast();
    }

    function showToast(message) {
        const toast = document.getElementById('copy-toast');
        const toastMsg = document.getElementById('toast-message');
        if (message) toastMsg.innerText = message;
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 2500);
    }

    // Share Modal Handlers
    let currentShareUrl = '';
    function openShareModal(url, title) {
        currentShareUrl = url;
        document.getElementById('share-modal-title').innerText = title;
        document.getElementById('share-modal-url').value = url;

        const encodedUrl = encodeURIComponent(url);
        const encodedTitle = encodeURIComponent(title + " — Yayasan LINTASAN");

        // WhatsApp
        document.getElementById('share-wa').href = `https://api.whatsapp.com/send?text=${encodedTitle}%0A${encodedUrl}`;
        // Facebook
        document.getElementById('share-fb').href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
        // Twitter / X
        document.getElementById('share-tw').href = `https://twitter.com/intent/tweet?text=${encodedTitle}&url=${encodedUrl}`;
        // LinkedIn
        document.getElementById('share-li').href = `https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`;

        document.getElementById('share-modal').classList.remove('hidden');
    }

    function closeShareModal() {
        document.getElementById('share-modal').classList.add('hidden');
    }

    function copyFromModal() {
        const input = document.getElementById('share-modal-url');
        input.select();
        copyStoryLink(input.value);
    }

    // Import Modal Handlers
    function toggleImportModal(show) {
        const modal = document.getElementById('import-modal');
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>
@endsection
