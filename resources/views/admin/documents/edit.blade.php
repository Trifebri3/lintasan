@extends('admin.layout.app')

@section('title', 'Edit Dokumen: ' . $document->title . ' - Admin LINTASAN')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.documents.index') }}" class="text-xs font-bold text-brand-green hover:underline flex items-center gap-1">
                    <i class="fas fa-arrow-left text-[10px]"></i> Kembali ke Daftar
                </a>
                <span class="text-gray-300">•</span>
                <span class="text-xs font-semibold text-gray-500">Edit Dokumen</span>
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Edit Dokumen & Laporan</h1>
            <p class="text-xs text-gray-500 mt-1">Perbarui rincian informasi, ganti berkas dokumen, atau sesuaikan cover publikasi.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('public.documents.preview', $document->slug ?: $document->id) }}" target="_blank" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs font-bold px-3.5 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-xs">
                <i class="fas fa-arrow-up-right-from-square text-gray-400"></i> Lihat Berkas
            </a>
            <a href="{{ route('admin.documents.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2.5 rounded-xl transition">
                Batal
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <form id="documentEditForm" action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="auto_cover_base64" id="auto_cover_base64" value="">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column: Form Details & Replacement Upload (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- 1. Current File Status & Optional Replacement Dropzone -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-700">
                            Berkas Terpasang Saat Ini
                        </label>
                        <span class="text-[11px] text-gray-400">Unggah berkas baru hanya jika ingin menggantinya</span>
                    </div>

                    <!-- Current File Card -->
                    <div class="flex items-center justify-between bg-emerald-50/50 p-4 rounded-xl border border-emerald-200">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-white border border-emerald-200 text-brand-green flex items-center justify-center text-xl shrink-0 shadow-xs">
                                <i class="fas {{ $document->icon_class }}"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-black text-gray-900 truncate" title="{{ $document->file_name }}">
                                    {{ $document->file_name }}
                                </div>
                                <div class="flex items-center gap-2 text-[10px] text-gray-500 mt-0.5">
                                    <span class="font-bold uppercase text-emerald-800">{{ strtoupper($document->file_type) }}</span>
                                    <span>•</span>
                                    <span>{{ $document->formatted_file_size }}</span>
                                    <span>•</span>
                                    <span>{{ number_format($document->downloads_count) }} kali diunduh</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('public.documents.download', $document->slug ?: $document->id) }}" class="text-xs font-bold text-brand-green hover:underline flex items-center gap-1 shrink-0 bg-white px-3 py-1.5 rounded-lg border border-emerald-200 shadow-xs">
                            <i class="fas fa-download text-[11px]"></i> Unduh Berkas
                        </a>
                    </div>

                    <!-- Optional Replace File Dropzone -->
                    <div class="pt-2">
                        <button type="button" onclick="toggleReplaceFileZone()" class="text-xs font-bold text-gray-600 hover:text-brand-green flex items-center gap-1.5">
                            <i class="fas fa-arrows-rotate text-[11px]"></i>
                            <span>Ingin Mengganti Berkas Dokumen dengan yang Baru?</span>
                        </button>

                        <div id="replaceFileContainer" class="hidden mt-3 relative border-2 border-dashed border-gray-300 hover:border-brand-green rounded-2xl p-6 text-center transition bg-gray-50/60 hover:bg-emerald-50/30 cursor-pointer">
                            <input type="file" id="document_file" name="document_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div id="dropzoneContent" class="space-y-2">
                                <i class="fas fa-cloud-arrow-up text-2xl text-brand-green"></i>
                                <p class="text-xs font-bold text-gray-800">Klik atau Tarik Berkas Baru ke Sini</p>
                                <p class="text-[10px] text-gray-400">PDF, Word (.docx, .doc) hingga 50 MB</p>
                            </div>
                            <div id="extractionProgress" class="hidden py-2 space-y-2">
                                <div class="flex items-center justify-center gap-2 text-brand-green font-bold text-xs">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                    <span>Mengekstrak cover otomatis dari berkas baru...</span>
                                </div>
                            </div>
                            <div id="newFileBanner" class="hidden text-xs font-bold text-emerald-800 bg-emerald-100 p-2.5 rounded-xl mt-2">
                                Berkas baru dipilih: <span id="newFileName"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Form Details -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <i class="fas fa-pen-to-square text-brand-green"></i> Perbarui Rincian Dokumen
                    </h3>

                    <!-- Title -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="title" class="block text-xs font-bold text-gray-700">
                                Judul Dokumen <span class="text-red-500">*</span>
                            </label>
                            <span class="text-[10px] text-emerald-600 font-semibold">Bebas diubah kapan saja</span>
                        </div>
                        <input type="text" id="title" name="title" value="{{ old('title', $document->title) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Kategori Dokumen <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap gap-2 mb-2.5">
                            @foreach($categories as $cat)
                                <button type="button" onclick="selectCategory('{{ $cat }}')" class="cat-pill px-3 py-1.5 rounded-xl border text-xs font-bold transition flex items-center gap-1.5 {{ old('category', $document->category) === $cat ? 'bg-brand-green text-white border-brand-green' : 'bg-white text-gray-600 border-gray-200 hover:border-brand-green hover:text-brand-green' }}" data-category="{{ $cat }}">
                                    <span>{{ $cat }}</span>
                                </button>
                            @endforeach
                        </div>
                        <select id="category" name="category" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green bg-white">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $document->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year & Publish Date -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="year" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Tahun Laporan / Terbit
                            </label>
                            <input type="text" id="year" name="year" value="{{ old('year', $document->year) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green">
                        </div>

                        <div>
                            <label for="published_at" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Tanggal Publikasi
                            </label>
                            <input type="date" id="published_at" name="published_at" value="{{ old('published_at', $document->published_at ? $document->published_at->format('Y-m-d') : date('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-xs font-bold text-gray-700 mb-1.5">
                            Ringkasan / Abstrak Dokumen
                        </label>
                        <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green">{{ old('description', $document->description) }}</textarea>
                    </div>

                    <!-- Publish Toggle -->
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="block text-xs font-bold text-gray-800">Status Publikasi</span>
                            <span class="text-[11px] text-gray-500">Tayangkan dokumen ini di halaman publik yayasan.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $document->is_published) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-green"></div>
                        </label>
                    </div>
                </div>

                <!-- 3. Custom Cover Replacement -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-3">
                    <span class="block text-xs font-bold text-gray-700">Unggah Gambar Cover Baru (Opsional)</span>
                    <p class="text-xs text-gray-500">Pilih gambar JPG, PNG, atau WebP jika ingin mengganti cover yang terpasang.</p>
                    <input type="file" id="custom_cover" name="custom_cover" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-brand-green hover:file:bg-emerald-100 cursor-pointer">
                </div>
            </div>

            <!-- Right Column: Cover Preview & Update Action (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4 sticky top-6">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-400">Cover Aktif</span>
                        <span id="coverExtractionBadge" class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-brand-green">
                            Tersimpan
                        </span>
                    </div>

                    <!-- Book / Document Card Container -->
                    <div class="relative mx-auto w-full max-w-[240px] aspect-[1/1.414] rounded-2xl overflow-hidden border border-gray-200 bg-gradient-to-b from-gray-50 to-gray-100 shadow-lg flex flex-col items-center justify-center">
                        <img id="coverPreviewImg" src="{{ $document->cover_url ?: '' }}" alt="{{ $document->title }}" class="{{ $document->cover_url ? '' : 'hidden' }} w-full h-full object-cover object-top transition duration-300">
                        
                        <div id="coverPlaceholder" class="{{ $document->cover_url ? 'hidden' : '' }} p-6 text-center space-y-2">
                            <i class="fas {{ $document->icon_class }} text-4xl mb-1"></i>
                            <span class="text-xs font-bold text-gray-500 block uppercase">{{ $document->file_type }}</span>
                        </div>

                        <!-- Shiny spine effect -->
                        <div class="absolute left-0 top-0 bottom-0 w-3 bg-gradient-to-r from-black/25 via-black/10 to-transparent pointer-events-none"></div>
                    </div>

                    <!-- Dynamic Meta Preview Under Card -->
                    <div class="bg-gray-50 p-4 rounded-xl space-y-2 border border-gray-150">
                        <div class="text-[10px] font-black uppercase text-brand-green tracking-wider" id="previewCatBadge">
                            {{ $document->category }}
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 leading-snug line-clamp-2" id="previewTitleText">
                            {{ $document->title }}
                        </h4>
                        <div class="flex items-center justify-between text-[10px] text-gray-500 pt-1 border-t border-gray-200/60">
                            <span id="previewYearText">Tahun {{ $document->year ?: '-' }}</span>
                            <span class="font-bold text-emerald-700">{{ $document->formatted_file_size }}</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" id="btnSubmitForm" class="w-full bg-brand-green hover:bg-brand-darkgreen text-white text-xs font-black py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                            <i class="fas fa-check text-sm"></i>
                            <span>Simpan Perubahan Dokumen</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<canvas id="renderCanvas" class="hidden"></canvas>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    const fileInput = document.getElementById('document_file');
    const titleInput = document.getElementById('title');
    const yearInput = document.getElementById('year');
    const categorySelect = document.getElementById('category');
    const autoCoverInput = document.getElementById('auto_cover_base64');
    const coverPreviewImg = document.getElementById('coverPreviewImg');
    const coverPlaceholder = document.getElementById('coverPlaceholder');
    const coverExtractionBadge = document.getElementById('coverExtractionBadge');
    const customCoverInput = document.getElementById('custom_cover');

    const previewTitleText = document.getElementById('previewTitleText');
    const previewCatBadge = document.getElementById('previewCatBadge');
    const previewYearText = document.getElementById('previewYearText');

    titleInput.addEventListener('input', (e) => {
        previewTitleText.innerText = e.target.value.trim() || 'Judul Dokumen';
    });

    yearInput.addEventListener('input', (e) => {
        previewYearText.innerText = 'Tahun ' + (e.target.value.trim() || '-');
    });

    categorySelect.addEventListener('change', (e) => {
        selectCategory(e.target.value);
    });

    function selectCategory(cat) {
        categorySelect.value = cat;
        previewCatBadge.innerText = cat || 'Kategori Dokumen';
        document.querySelectorAll('.cat-pill').forEach(btn => {
            if (btn.getAttribute('data-category') === cat) {
                btn.classList.add('bg-brand-green', 'text-white', 'border-brand-green');
                btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
            } else {
                btn.classList.remove('bg-brand-green', 'text-white', 'border-brand-green');
                btn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
            }
        });
    }

    function toggleReplaceFileZone() {
        document.getElementById('replaceFileContainer').classList.toggle('hidden');
    }

    customCoverInput.addEventListener('change', (e) => {
        if (customCoverInput.files.length > 0) {
            const file = customCoverInput.files[0];
            const reader = new FileReader();
            reader.onload = function(evt) {
                coverPreviewImg.src = evt.target.result;
                coverPreviewImg.classList.remove('hidden');
                coverPlaceholder.classList.add('hidden');
                coverExtractionBadge.innerText = 'Cover Kustom Baru';
                coverExtractionBadge.className = 'text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-blue-100 text-blue-800';
            };
            reader.readAsDataURL(file);
        }
    });

    if (fileInput) {
        fileInput.addEventListener('change', async (e) => {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const ext = file.name.split('.').pop().toLowerCase();
                
                document.getElementById('dropzoneContent').classList.add('hidden');
                document.getElementById('extractionProgress').classList.remove('hidden');

                if (ext === 'pdf') {
                    try {
                        const arrayBuffer = await file.arrayBuffer();
                        const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
                        const page = await pdf.getPage(1);
                        const scale = 2.0;
                        const viewport = page.getViewport({ scale: scale });

                        const canvas = document.getElementById('renderCanvas');
                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        await page.render({ canvasContext: context, viewport: viewport }).promise;

                        const base64Cover = canvas.toDataURL('image/jpeg', 0.90);
                        autoCoverInput.value = base64Cover;
                        coverPreviewImg.src = base64Cover;
                        coverPreviewImg.classList.remove('hidden');
                        coverPlaceholder.classList.add('hidden');

                        coverExtractionBadge.innerText = 'Cover Baru Hal. 1';
                        coverExtractionBadge.className = 'text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800';
                    } catch (err) {
                        console.error('PDF extraction error in edit:', err);
                    }
                }

                document.getElementById('extractionProgress').classList.add('hidden');
                document.getElementById('newFileName').innerText = file.name;
                document.getElementById('newFileBanner').classList.remove('hidden');
            }
        });
    }

    document.getElementById('documentEditForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitForm');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-sm"></i> <span>Menyimpan Perubahan...</span>';
    });
</script>
@endsection
@endsection
