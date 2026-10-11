@extends('admin.layout.app')

@section('title', 'Unggah Dokumen Baru - Admin LINTASAN')

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
                <span class="text-xs font-semibold text-gray-500">Form Unggah Cerdas</span>
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Unggah Dokumen & Laporan</h1>
            <p class="text-xs text-gray-500 mt-1">Sistem akan mengekstrak cover otomatis dari halaman pertama (PDF/Word). Judul dan kategori dapat disesuaikan bebas.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.documents.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2.5 rounded-xl transition">
                Batal
            </a>
        </div>
    </div>

    <!-- Main Upload Form -->
    <form id="documentUploadForm" action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Hidden input to store auto-extracted cover base64 -->
        <input type="hidden" name="auto_cover_base64" id="auto_cover_base64" value="">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column: File Dropzone & Form Details (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- 1. Drag & Drop Upload Zone -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-700">
                            Berkas Dokumen <span class="text-red-500">*</span>
                        </label>
                        <span class="text-[11px] text-gray-400">PDF, Word (.docx, .doc) hingga 50 MB</span>
                    </div>

                    <!-- Dropzone Box -->
                    <div id="dropzone" class="relative border-2 border-dashed border-gray-300 hover:border-brand-green rounded-2xl p-6 sm:p-8 text-center transition-all duration-200 bg-gray-50/60 hover:bg-emerald-50/30 cursor-pointer group">
                        <input type="file" id="document_file" name="document_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                        
                        <div id="dropzoneContent" class="space-y-3">
                            <div class="w-16 h-16 rounded-2xl bg-white text-brand-green flex items-center justify-center text-3xl mx-auto shadow-sm group-hover:scale-110 group-hover:text-brand-darkgreen transition-all duration-200 border border-gray-100">
                                <i class="fas fa-cloud-arrow-up"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">
                                    Tarik & Lepas berkas di sini, atau <span class="text-brand-green underline underline-offset-2">Pilih Berkas</span>
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">Mendukung dokumen PDF, Word (.docx, .doc), Excel, PowerPoint</p>
                            </div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100/60 text-brand-green text-[11px] font-bold">
                                <i class="fas fa-wand-magic-sparkles text-[10px]"></i>
                                <span>Cover halaman pertama akan diekstrak otomatis seketika!</span>
                            </div>
                        </div>

                        <!-- Extraction Status Bar (Hidden until file selected) -->
                        <div id="extractionProgress" class="hidden py-4 space-y-3">
                            <div class="flex items-center justify-center gap-2 text-brand-green font-bold text-xs">
                                <i class="fas fa-circle-notch fa-spin text-base"></i>
                                <span id="extractionStatusText">Sedang membaca berkas & mengekstrak cover...</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 max-w-xs mx-auto overflow-hidden">
                                <div id="extractionProgressBar" class="bg-brand-green h-2 rounded-full transition-all duration-300 w-1/3"></div>
                            </div>
                        </div>

                        <!-- Selected File Info Banner (Hidden until loaded) -->
                        <div id="fileSelectedBanner" class="hidden pt-3 border-t border-gray-200/80 mt-4 text-left">
                            <div class="flex items-center justify-between bg-white p-3.5 rounded-xl border border-emerald-200 shadow-xs">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div id="fileTypeIconWrapper" class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl shrink-0">
                                        <i id="fileTypeIcon" class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div id="selectedFileName" class="text-xs font-black text-gray-900 truncate">Nama_Berkas.pdf</div>
                                        <div class="flex items-center gap-2 text-[10px] text-gray-500 mt-0.5">
                                            <span id="selectedFileSize" class="font-semibold text-emerald-700">0 MB</span>
                                            <span>•</span>
                                            <span id="selectedPageCount" class="font-semibold text-gray-600">Menganalisis...</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="btnChangeFile" class="text-xs font-bold text-gray-500 hover:text-brand-green px-3 py-1.5 rounded-lg hover:bg-gray-100 transition shrink-0">
                                    <i class="fas fa-arrows-rotate mr-1"></i> Ganti
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Document Details Form -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <i class="fas fa-circle-info text-brand-green"></i> Rincian Informasi Dokumen
                    </h3>

                    <!-- Title (Bebas Judul) -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="title" class="block text-xs font-bold text-gray-700">
                                Judul Dokumen <span class="text-red-500">*</span>
                            </label>
                            <span class="text-[10px] text-emerald-600 font-semibold">Bebas diisi (misal: Annual Report 2024, Laporan Keuangan, Panduan Riset)</span>
                        </div>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: Annual Report 2024 - Ketangguhan Pesisir & Masa Depan Bahari" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green">
                    </div>

                    <!-- Category Pills & Select -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">
                            Kategori Dokumen <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Quick Category Selector Pills -->
                        <div class="flex flex-wrap gap-2 mb-2.5">
                            @foreach($categories as $cat)
                                <button type="button" onclick="selectCategory('{{ $cat }}')" class="cat-pill px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:border-brand-green hover:text-brand-green bg-white transition flex items-center gap-1.5" data-category="{{ $cat }}">
                                    <span>{{ $cat }}</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- Real Select Input -->
                        <div class="relative">
                            <select id="category" name="category" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green bg-white">
                                <option value="">-- Pilih atau Tentukan Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Grid: Year & Publish Date -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Year -->
                        <div>
                            <label for="year" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Tahun Laporan / Terbit
                            </label>
                            <input type="text" id="year" name="year" value="{{ old('year', $currentYear) }}" placeholder="Contoh: {{ $currentYear }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green">
                        </div>

                        <!-- Published Date -->
                        <div>
                            <label for="published_at" class="block text-xs font-bold text-gray-700 mb-1.5">
                                Tanggal Publikasi
                            </label>
                            <input type="date" id="published_at" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-xs font-bold text-gray-700 mb-1.5">
                            Ringkasan / Abstrak Dokumen
                        </label>
                        <textarea id="description" name="description" rows="4" placeholder="Tuliskan ringkasan singkat isi laporan, topik utama capaian yayasan, atau pesan pembuka..." class="w-full px-4 py-3 rounded-xl border border-gray-200 text-xs text-gray-900 font-medium focus:outline-none focus:border-brand-green">{{ old('description') }}</textarea>
                    </div>

                    <!-- Publication Status Toggle -->
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="block text-xs font-bold text-gray-800">Publikasikan Langsung ke Publik</span>
                            <span class="text-[11px] text-gray-500">Jika aktif, dokumen akan langsung dapat dilihat dan diunduh di website publik.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-green"></div>
                        </label>
                    </div>
                </div>

                <!-- 3. Optional Custom Cover Override (Collapsible) -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <button type="button" onclick="toggleCustomCoverAccordion()" class="w-full flex items-center justify-between text-left text-xs font-bold text-gray-700 hover:text-brand-green transition">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-image text-gray-400"></i>
                            <span>Ingin Menggunakan Gambar Cover Kustom Sendiri? (Opsional)</span>
                        </div>
                        <i id="customCoverAccordionIcon" class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"></i>
                    </button>
                    <div id="customCoverAccordion" class="hidden mt-4 pt-4 border-t border-gray-100 space-y-3">
                        <p class="text-xs text-gray-500">Secara default, sistem sudah mengekstrak cover otomatis dari halaman pertama dokumen. Gunakan opsi ini jika Anda ingin mengunggah foto cover khusus (JPG, PNG, WebP).</p>
                        <input type="file" id="custom_cover" name="custom_cover" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-brand-green hover:file:bg-emerald-100 cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Right Column: Live Cover Card & Submission (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Live Preview Card (What visitors will see) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4 sticky top-6">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-400">Live Preview Cover</span>
                        <span id="coverExtractionBadge" class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">
                            Menunggu Berkas
                        </span>
                    </div>

                    <!-- Book / Document Card Container -->
                    <div class="relative mx-auto w-full max-w-[240px] aspect-[1/1.414] rounded-2xl overflow-hidden border border-gray-200 bg-gradient-to-b from-gray-50 to-gray-100 shadow-lg flex flex-col items-center justify-center group">
                        <!-- Rendered Image -->
                        <img id="coverPreviewImg" src="" alt="Pratinjau Cover" class="hidden w-full h-full object-cover object-top transition duration-300">
                        
                        <!-- Placeholder when no file -->
                        <div id="coverPlaceholder" class="p-6 text-center space-y-3">
                            <div class="w-14 h-14 rounded-2xl bg-white border border-gray-200 text-gray-300 flex items-center justify-center text-2xl mx-auto shadow-inner">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-400 block">Cover Halaman 1</span>
                                <span class="text-[10px] text-gray-400 block mt-0.5">Akan muncul otomatis saat berkas dipilih</span>
                            </div>
                        </div>

                        <!-- Shiny spine effect for book look -->
                        <div class="absolute left-0 top-0 bottom-0 w-3 bg-gradient-to-r from-black/25 via-black/10 to-transparent pointer-events-none"></div>
                    </div>

                    <!-- Dynamic Meta Preview Under Card -->
                    <div class="bg-gray-50 p-4 rounded-xl space-y-2 border border-gray-150">
                        <div class="text-[10px] font-black uppercase text-brand-green tracking-wider" id="previewCatBadge">
                            Annual Report
                        </div>
                        <h4 class="text-xs font-bold text-gray-900 leading-snug line-clamp-2" id="previewTitleText">
                            Judul Dokumen Akan Ditampilkan di Sini
                        </h4>
                        <div class="flex items-center justify-between text-[10px] text-gray-500 pt-1 border-t border-gray-200/60">
                            <span id="previewYearText">Tahun {{ $currentYear }}</span>
                            <span class="font-bold text-emerald-700" id="previewFileSizeText">0 KB</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" id="btnSubmitForm" class="w-full bg-brand-green hover:bg-brand-darkgreen text-white text-xs font-black py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                            <i class="fas fa-cloud-arrow-up text-sm"></i>
                            <span>Simpan & Terbitkan Dokumen</span>
                        </button>
                        <p class="text-[10px] text-gray-400 text-center mt-2.5">
                            <i class="fas fa-shield-halved mr-1"></i> Data aman & tersimpan otomatis di server.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Off-screen Canvas for PDF & Word cover rendering -->
<canvas id="renderCanvas" class="hidden"></canvas>

@section('scripts')
<!-- PDF.js library for 100% client-side instant PDF rendering -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<!-- JSZip library for reading DOCX zip structures client-side -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
    // Initialize PDF.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    const fileInput = document.getElementById('document_file');
    const dropzone = document.getElementById('dropzone');
    const titleInput = document.getElementById('title');
    const yearInput = document.getElementById('year');
    const categorySelect = document.getElementById('category');
    const autoCoverInput = document.getElementById('auto_cover_base64');
    const coverPreviewImg = document.getElementById('coverPreviewImg');
    const coverPlaceholder = document.getElementById('coverPlaceholder');
    const coverExtractionBadge = document.getElementById('coverExtractionBadge');
    const customCoverInput = document.getElementById('custom_cover');

    // Preview elements
    const previewTitleText = document.getElementById('previewTitleText');
    const previewCatBadge = document.getElementById('previewCatBadge');
    const previewYearText = document.getElementById('previewYearText');
    const previewFileSizeText = document.getElementById('previewFileSizeText');

    // Progress elements
    const dropzoneContent = document.getElementById('dropzoneContent');
    const extractionProgress = document.getElementById('extractionProgress');
    const extractionProgressBar = document.getElementById('extractionProgressBar');
    const extractionStatusText = document.getElementById('extractionStatusText');
    const fileSelectedBanner = document.getElementById('fileSelectedBanner');
    const selectedFileName = document.getElementById('selectedFileName');
    const selectedFileSize = document.getElementById('selectedFileSize');
    const selectedPageCount = document.getElementById('selectedPageCount');
    const fileTypeIcon = document.getElementById('fileTypeIcon');
    const fileTypeIconWrapper = document.getElementById('fileTypeIconWrapper');

    // Drag and drop event listeners
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('border-brand-green', 'bg-emerald-50/50');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('border-brand-green', 'bg-emerald-50/50');
        }, false);
    });

    dropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelection(files[0]);
        }
    });

    fileInput.addEventListener('change', (e) => {
        if (fileInput.files.length > 0) {
            handleFileSelection(fileInput.files[0]);
        }
    });

    document.getElementById('btnChangeFile').addEventListener('click', (e) => {
        e.stopPropagation();
        fileInput.click();
    });

    // Real-time title & category preview sync
    titleInput.addEventListener('input', (e) => {
        previewTitleText.innerText = e.target.value.trim() || 'Judul Dokumen Akan Ditampilkan di Sini';
    });

    yearInput.addEventListener('input', (e) => {
        previewYearText.innerText = 'Tahun ' + (e.target.value.trim() || '{{ $currentYear }}');
    });

    categorySelect.addEventListener('change', (e) => {
        updateCategoryPills(e.target.value);
    });

    function selectCategory(cat) {
        categorySelect.value = cat;
        updateCategoryPills(cat);
    }

    function updateCategoryPills(cat) {
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

    function toggleCustomCoverAccordion() {
        const acc = document.getElementById('customCoverAccordion');
        const icon = document.getElementById('customCoverAccordionIcon');
        acc.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    // Custom Cover override event
    customCoverInput.addEventListener('change', (e) => {
        if (customCoverInput.files.length > 0) {
            const file = customCoverInput.files[0];
            const reader = new FileReader();
            reader.onload = function(evt) {
                coverPreviewImg.src = evt.target.result;
                coverPreviewImg.classList.remove('hidden');
                coverPlaceholder.classList.add('hidden');
                coverExtractionBadge.innerText = 'Cover Kustom Aktif';
                coverExtractionBadge.className = 'text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-blue-100 text-blue-800';
            };
            reader.readAsDataURL(file);
        }
    });

    // Format file size
    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    // MAIN FILE SELECTION HANDLER
    async function handleFileSelection(file) {
        if (!file) return;

        // UI Reset & Progress
        dropzoneContent.classList.add('hidden');
        extractionProgress.classList.remove('hidden');
        extractionProgressBar.style.width = '30%';
        extractionStatusText.innerText = 'Membaca berkas: ' + file.name + '...';

        const ext = file.name.split('.').pop().toLowerCase();
        const formattedSize = formatBytes(file.size);

        // Update meta in UI
        selectedFileName.innerText = file.name;
        selectedFileSize.innerText = formattedSize;
        previewFileSizeText.innerText = formattedSize;

        // Auto-clean Title if empty or unchanged
        if (!titleInput.value || titleInput.dataset.autofilled === 'true') {
            let cleanTitle = file.name.substring(0, file.name.lastIndexOf('.')) || file.name;
            // Clean underscores, hyphens, pluses
            cleanTitle = cleanTitle.replace(/[-_+]/g, ' ')
                                   .replace(/\s+/g, ' ')
                                   .trim();
            // Capitalize words
            cleanTitle = cleanTitle.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
            titleInput.value = cleanTitle;
            titleInput.dataset.autofilled = 'true';
            previewTitleText.innerText = cleanTitle;
        }

        // Auto-detect Year in filename
        const yearMatch = file.name.match(/\b(20[1-3][0-9])\b/);
        if (yearMatch) {
            yearInput.value = yearMatch[1];
            previewYearText.innerText = 'Tahun ' + yearMatch[1];
        }

        // Auto-detect Category in filename
        const lowerName = file.name.toLowerCase();
        let detectedCat = '';
        if (lowerName.includes('annual') || lowerName.includes('annual report')) {
            detectedCat = 'Annual Report';
        } else if (lowerName.includes('tahunan') || lowerName.includes('laporan tahunan')) {
            detectedCat = 'Laporan Tahunan';
        } else if (lowerName.includes('keuangan') || lowerName.includes('financial')) {
            detectedCat = 'Laporan Keuangan';
        } else if (lowerName.includes('panduan') || lowerName.includes('modul')) {
            detectedCat = 'Panduan & Modul';
        } else if (lowerName.includes('riset') || lowerName.includes('penelitian')) {
            detectedCat = 'Riset & Publikasi';
        } else if (lowerName.includes('kebijakan') || lowerName.includes('policy')) {
            detectedCat = 'Dokumen Kebijakan';
        }

        if (detectedCat) {
            selectCategory(detectedCat);
        }

        // Update File Icon
        if (ext === 'pdf') {
            fileTypeIcon.className = 'fas fa-file-pdf';
            fileTypeIconWrapper.className = 'w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl shrink-0';
        } else if (['doc', 'docx'].includes(ext)) {
            fileTypeIcon.className = 'fas fa-file-word';
            fileTypeIconWrapper.className = 'w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0';
        } else if (['xls', 'xlsx'].includes(ext)) {
            fileTypeIcon.className = 'fas fa-file-excel';
            fileTypeIconWrapper.className = 'w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0';
        }

        // Cover Extraction Dispatcher
        if (ext === 'pdf') {
            await extractPdfCover(file);
        } else if (ext === 'docx') {
            await extractDocxCover(file);
        } else {
            // Fallback generated canvas cover
            generateCanvasStyledCover(titleInput.value || file.name, ext.toUpperCase(), yearInput.value);
            selectedPageCount.innerText = 'Format ' + ext.toUpperCase();
            finishExtraction();
        }
    }

    // 1. EXTRACT COVER FROM PDF PAGE 1 (USING PDF.JS)
    async function extractPdfCover(file) {
        extractionProgressBar.style.width = '60%';
        extractionStatusText.innerText = 'Mengekstrak halaman 1 PDF ke cover berkualitas tinggi...';

        try {
            const arrayBuffer = await file.arrayBuffer();
            const loadingTask = pdfjsLib.getDocument({ data: arrayBuffer });
            const pdf = await loadingTask.promise;

            selectedPageCount.innerText = pdf.numPages + ' Halaman PDF';

            // Get First Page
            const page = await pdf.getPage(1);
            const scale = 2.0; // Sharp high-res rendering
            const viewport = page.getViewport({ scale: scale });

            const canvas = document.getElementById('renderCanvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };

            await page.render(renderContext).promise;

            // Convert to high quality JPEG
            const base64Cover = canvas.toDataURL('image/jpeg', 0.90);
            
            // Set Hidden Input and Preview
            autoCoverInput.value = base64Cover;
            coverPreviewImg.src = base64Cover;
            coverPreviewImg.classList.remove('hidden');
            coverPlaceholder.classList.add('hidden');

            coverExtractionBadge.innerText = '✅ Auto Halaman 1';
            coverExtractionBadge.className = 'text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300';

            finishExtraction();
        } catch (error) {
            console.error('PDF Cover extraction error:', error);
            // Fallback: Generate stylized cover
            generateCanvasStyledCover(titleInput.value || file.name, 'PDF', yearInput.value);
            finishExtraction();
        }
    }

    // 2. EXTRACT COVER FROM DOCX (JSZIP / CANVAS FALLBACK)
    async function extractDocxCover(file) {
        extractionProgressBar.style.width = '60%';
        extractionStatusText.innerText = 'Memeriksa ilustrasi halaman depan Word...';

        try {
            const zip = await JSZip.loadAsync(file);
            let extractedImgData = null;

            // Search word/media for first image (usually document cover illustration)
            const mediaFolder = zip.folder("word/media");
            if (mediaFolder) {
                const imageFiles = Object.keys(zip.files).filter(f => f.match(/^word\/media\/image1\.(png|jpe?g)$/i));
                if (imageFiles.length > 0) {
                    const imgBlob = await zip.file(imageFiles[0]).async("blob");
                    extractedImgData = await new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onloadend = () => resolve(reader.result);
                        reader.readAsDataURL(imgBlob);
                    });
                }
            }

            if (extractedImgData) {
                autoCoverInput.value = extractedImgData;
                coverPreviewImg.src = extractedImgData;
                coverPreviewImg.classList.remove('hidden');
                coverPlaceholder.classList.add('hidden');
                coverExtractionBadge.innerText = '✅ Gambar Utama Word';
                coverExtractionBadge.className = 'text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-300';
            } else {
                // Generate sleek branded book cover
                generateCanvasStyledCover(titleInput.value || file.name, 'DOCX', yearInput.value);
            }

            selectedPageCount.innerText = 'Dokumen Microsoft Word';
            finishExtraction();
        } catch (error) {
            console.warn('DOCX extraction fallback:', error);
            generateCanvasStyledCover(titleInput.value || file.name, 'DOCX', yearInput.value);
            selectedPageCount.innerText = 'Dokumen Microsoft Word';
            finishExtraction();
        }
    }

    // 3. GENERATE STYLISH HIGH-RES CARD COVER VIA CANVAS (FALLBACK)
    function generateCanvasStyledCover(title, docType, year) {
        const canvas = document.getElementById('renderCanvas');
        const ctx = canvas.getContext('2d');
        const width = 800;
        const height = 1131; // A4 aspect ratio
        canvas.width = width;
        canvas.height = height;

        // Elegant Gradient Background
        const grad = ctx.createLinearGradient(0, 0, width, height);
        grad.addColorStop(0, '#004D2E');
        grad.addColorStop(0.5, '#007A48');
        grad.addColorStop(1, '#0a2016');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, width, height);

        // Decorative Borders
        ctx.strokeStyle = 'rgba(255, 184, 0, 0.4)';
        ctx.lineWidth = 6;
        ctx.strokeRect(40, 40, width - 80, height - 80);

        // Header Pill
        ctx.fillStyle = 'rgba(255, 255, 255, 0.12)';
        ctx.beginPath();
        ctx.roundRect(width / 2 - 160, 90, 320, 50, 25);
        ctx.fill();

        ctx.fillStyle = '#FFB800';
        ctx.font = 'bold 20px "Plus Jakarta Sans", sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('YAYASAN LINTASAN', width / 2, 122);

        // Subtitle
        ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
        ctx.font = '600 14px "Plus Jakarta Sans", sans-serif';
        ctx.fillText('KETANGGUHAN PESISIR INDONESIA', width / 2, 165);

        // Big Icon Emblem
        ctx.fillStyle = 'rgba(255, 255, 255, 0.15)';
        ctx.beginPath();
        ctx.arc(width / 2, 330, 80, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 50px "Plus Jakarta Sans", sans-serif';
        ctx.fillText(docType, width / 2, 348);

        // Title text wrapping
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 36px "Plus Jakarta Sans", sans-serif';
        const words = (title || 'DOKUMEN RESMI').split(' ');
        let line = '';
        let y = 520;
        const lineHeight = 48;
        const maxWidth = width - 160;

        for (let n = 0; n < words.length; n++) {
            const testLine = line + words[n] + ' ';
            const metrics = ctx.measureText(testLine);
            if (metrics.width > maxWidth && n > 0) {
                ctx.fillText(line.trim(), width / 2, y);
                line = words[n] + ' ';
                y += lineHeight;
            } else {
                line = testLine;
            }
        }
        ctx.fillText(line.trim(), width / 2, y);

        // Year Badge
        if (year) {
            ctx.fillStyle = '#FFB800';
            ctx.beginPath();
            ctx.roundRect(width / 2 - 80, y + 40, 160, 44, 22);
            ctx.fill();

            ctx.fillStyle = '#004D2E';
            ctx.font = 'bold 22px "Plus Jakarta Sans", sans-serif';
            ctx.fillText(year, width / 2, y + 70);
        }

        // Footer Bar
        ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
        ctx.font = '500 16px "Plus Jakarta Sans", sans-serif';
        ctx.fillText('PUBLIKASI RESMI YAYASAN', width / 2, height - 90);

        const base64Cover = canvas.toDataURL('image/jpeg', 0.88);
        autoCoverInput.value = base64Cover;
        coverPreviewImg.src = base64Cover;
        coverPreviewImg.classList.remove('hidden');
        coverPlaceholder.classList.add('hidden');

        coverExtractionBadge.innerText = '✅ Cover Standar Terbitan';
        coverExtractionBadge.className = 'text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300';
    }

    function finishExtraction() {
        extractionProgressBar.style.width = '100%';
        setTimeout(() => {
            extractionProgress.classList.add('hidden');
            fileSelectedBanner.classList.remove('hidden');
        }, 300);
    }

    // Submit handler with spinner
    document.getElementById('documentUploadForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitForm');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-sm"></i> <span>Menyimpan & Memproses Berkas...</span>';
    });

    // Initialize initial category selection
    const initCat = "{{ old('category', 'Annual Report') }}";
    selectCategory(initCat);
</script>
@endsection
@endsection
