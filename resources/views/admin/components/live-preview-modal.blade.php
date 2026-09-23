<!-- Admin Live Preview Modal -->
<div id="admin-live-preview-modal" class="fixed inset-0 z-[9999] bg-gray-950/85 backdrop-blur-md hidden flex-col transition-opacity duration-300 opacity-0" role="dialog" aria-modal="true" aria-labelledby="live-preview-title">
    <!-- Top Control Bar -->
    <div class="h-14 bg-gray-900 border-b border-gray-800 px-4 sm:px-6 flex items-center justify-between shrink-0 select-none text-white shadow-lg">
        
        <!-- Left Section: Title & Page Selector -->
        <div class="flex items-center gap-3 sm:gap-4 min-w-0">
            <div class="flex items-center gap-2 shrink-0">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span id="live-preview-title" class="font-bold text-xs uppercase tracking-wider text-gray-200 hidden md:inline">Live Preview</span>
            </div>

            <div class="h-5 w-px bg-gray-700 hidden md:block"></div>

            <!-- Page Quick Switcher -->
            <div class="flex items-center gap-1.5">
                <label for="preview-page-selector" class="text-[11px] text-gray-400 hidden lg:inline">Halaman:</label>
                <div class="relative">
                    <select id="preview-page-selector" onchange="changePreviewPage(this.value)" class="bg-gray-800 hover:bg-gray-750 text-gray-200 text-xs font-medium rounded-lg pl-2.5 pr-8 py-1.5 border border-gray-700 focus:outline-none focus:border-brand-green cursor-pointer appearance-none">
                        <option value="/">🏠 Beranda (Home)</option>
                        <option value="/tentang-kami">💡 Tentang Kami & Nilai</option>
                        <option value="/program">🎯 Program Unggulan</option>
                        <option value="/desa-binaan">🗺️ Desa Binaan & Peta</option>
                        <option value="/mitra">🤝 Kemitraan & Pengajuan</option>
                        <option value="/galeri">📸 Galeri Aktifitas</option>
                        <option value="/cerita-dampak">📰 Cerita Lapangan</option>
                        <option value="/relawan">👥 Pendaftaran Relawan</option>
                        <option value="/donasi">💚 Donasi Publik</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-2.5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <!-- Center Section: Device Switcher -->
        <div class="flex items-center bg-gray-800/90 p-1 rounded-xl border border-gray-700/80 shadow-inner">
            <button type="button" id="btn-device-desktop" onclick="switchPreviewDevice('desktop')" title="Tampilan Desktop (100%)" class="preview-device-btn flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-white bg-emerald-600 shadow-sm transition">
                <i class="fas fa-desktop text-xs"></i>
                <span class="hidden sm:inline">Desktop</span>
            </button>
            <button type="button" id="btn-device-tablet" onclick="switchPreviewDevice('tablet')" title="Tampilan Tablet (768px)" class="preview-device-btn flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-gray-400 hover:text-white hover:bg-gray-700/50 transition">
                <i class="fas fa-tablet-screen-button text-xs"></i>
                <span class="hidden sm:inline">Tablet</span>
            </button>
            <button type="button" id="btn-device-mobile" onclick="switchPreviewDevice('mobile')" title="Tampilan Smartphone (390px)" class="preview-device-btn flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-gray-400 hover:text-white hover:bg-gray-700/50 transition">
                <i class="fas fa-mobile-screen-button text-xs"></i>
                <span class="hidden sm:inline">Mobile</span>
            </button>
        </div>

        <!-- Right Section: Tools (Language, Refresh, Open Tab, Close) -->
        <div class="flex items-center gap-2 sm:gap-2.5">
            <!-- Language Quick Switcher -->
            <div class="flex items-center bg-gray-800 rounded-lg p-0.5 border border-gray-700 text-[11px] font-bold">
                <button type="button" onclick="switchPreviewLanguage('id')" id="preview-lang-id" class="px-2 py-1 rounded text-white bg-brand-green font-bold">ID</button>
                <button type="button" onclick="switchPreviewLanguage('en')" id="preview-lang-en" class="px-2 py-1 rounded text-gray-400 hover:text-white font-medium">EN</button>
            </div>

            <!-- Reload Button -->
            <button type="button" onclick="reloadPreviewFrame()" title="Segarkan Halaman (Reload)" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white border border-gray-700 flex items-center justify-center text-xs transition">
                <i id="preview-reload-icon" class="fas fa-rotate-right"></i>
            </button>

            <!-- Open in New Tab -->
            <button type="button" onclick="openPreviewInNewTab()" title="Buka di Tab Baru" class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white border border-gray-700 flex items-center justify-center text-xs transition">
                <i class="fas fa-arrow-up-right-from-square"></i>
            </button>

            <!-- Close Modal -->
            <button type="button" onclick="closeLivePreviewModal()" title="Tutup Preview (ESC)" class="w-8 h-8 rounded-lg bg-red-950/40 hover:bg-red-900/80 text-red-300 hover:text-white border border-red-800/40 flex items-center justify-center text-sm font-bold transition ml-1">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    </div>

    <!-- Viewport Area -->
    <div class="flex-1 overflow-hidden p-2 sm:p-4 flex items-center justify-center bg-gradient-to-b from-gray-950 via-gray-900 to-gray-950 relative">
        <!-- Device Wrapper Container -->
        <div id="preview-device-wrapper" class="w-full h-full max-w-full flex flex-col items-center justify-center transition-all duration-300 ease-out relative">
            
            <!-- Mobile/Tablet Notch & Top Bar Mockup (Shown on mobile) -->
            <div id="preview-device-topbar" class="hidden w-full bg-gray-800 h-5 rounded-t-3xl shrink-0 flex items-center justify-center border-b border-gray-700">
                <div class="w-16 h-1.5 bg-gray-700 rounded-full"></div>
            </div>

            <!-- Frame Container -->
            <div id="preview-frame-container" class="w-full h-full relative overflow-hidden bg-white shadow-2xl transition-all duration-300 ease-out rounded-xl">
                <!-- Loading State Indicator -->
                <div id="preview-loading-overlay" class="absolute inset-0 bg-white/90 z-20 flex flex-col items-center justify-center gap-3 transition-opacity duration-200">
                    <div class="w-10 h-10 border-4 border-emerald-500/20 border-t-emerald-600 rounded-full animate-spin"></div>
                    <div class="text-xs font-bold text-gray-700">Memuat Live Preview Website...</div>
                </div>

                <!-- Live Iframe -->
                <iframe id="admin-preview-iframe" src="about:blank" class="w-full h-full border-0 block" onload="onPreviewFrameLoaded()"></iframe>
            </div>

            <!-- Mobile Bottom Bar Mockup (Shown on mobile) -->
            <div id="preview-device-bottombar" class="hidden w-full bg-gray-800 h-4 rounded-b-3xl shrink-0 flex items-center justify-center border-t border-gray-700">
                <div class="w-24 h-1 bg-gray-700 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Bottom Status Bar -->
    <div class="h-8 bg-gray-950 border-t border-gray-800 px-4 flex items-center justify-between text-[11px] text-gray-400 select-none">
        <div class="flex items-center gap-3">
            <span id="preview-url-display" class="truncate max-w-xs sm:max-w-md text-gray-400 font-mono text-[10px]">
                URL: /
            </span>
        </div>
        <div class="flex items-center gap-3 text-[10px]">
            <span id="preview-resolution-display" class="font-mono text-emerald-400 font-semibold">Desktop: 100% (Responsif)</span>
            <span class="hidden md:inline text-gray-600">|</span>
            <span class="hidden md:inline text-gray-500">Tekan <kbd class="px-1.5 py-0.5 bg-gray-800 text-gray-300 rounded border border-gray-700 text-[9px]">ESC</kbd> untuk keluar</span>
        </div>
    </div>
</div>

<script>
    let currentPreviewDevice = 'desktop';
    let currentPreviewUrl = '/';
    let currentPreviewLang = 'id';

    function openLivePreviewModal(targetPath = '/') {
        const modal = document.getElementById('admin-live-preview-modal');
        const iframe = document.getElementById('admin-preview-iframe');
        const pageSelector = document.getElementById('preview-page-selector');
        const urlDisplay = document.getElementById('preview-url-display');
        const overlay = document.getElementById('preview-loading-overlay');

        if (!modal || !iframe) return;

        currentPreviewUrl = targetPath;
        if (pageSelector) {
            pageSelector.value = targetPath;
        }

        // Show modal with animation
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
        document.body.style.overflow = 'hidden';

        if (overlay) overlay.style.display = 'flex';

        // Load URL into iframe
        iframe.src = targetPath;
        if (urlDisplay) urlDisplay.textContent = 'URL: ' + targetPath;
    }

    function closeLivePreviewModal() {
        const modal = document.getElementById('admin-live-preview-modal');
        if (!modal) return;

        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    }

    function onPreviewFrameLoaded() {
        const overlay = document.getElementById('preview-loading-overlay');
        const iframe = document.getElementById('admin-preview-iframe');
        const urlDisplay = document.getElementById('preview-url-display');
        const reloadIcon = document.getElementById('preview-reload-icon');

        if (overlay) {
            overlay.style.display = 'none';
        }

        if (reloadIcon) {
            reloadIcon.classList.remove('fa-spin');
        }

        try {
            if (iframe && iframe.contentWindow) {
                const path = iframe.contentWindow.location.pathname;
                if (path && urlDisplay) {
                    urlDisplay.textContent = 'URL: ' + path;
                    // Sync selector if match found
                    const pageSelector = document.getElementById('preview-page-selector');
                    if (pageSelector) {
                        for (let opt of pageSelector.options) {
                            if (opt.value === path) {
                                pageSelector.value = path;
                                break;
                            }
                        }
                    }
                }
            }
        } catch (e) {
            // cross-origin security fallback
        }
    }

    function changePreviewPage(path) {
        const iframe = document.getElementById('admin-preview-iframe');
        const overlay = document.getElementById('preview-loading-overlay');
        const urlDisplay = document.getElementById('preview-url-display');

        if (!iframe) return;
        currentPreviewUrl = path;
        if (overlay) overlay.style.display = 'flex';
        iframe.src = path;
        if (urlDisplay) urlDisplay.textContent = 'URL: ' + path;
    }

    function switchPreviewDevice(device) {
        currentPreviewDevice = device;
        const wrapper = document.getElementById('preview-device-wrapper');
        const frameContainer = document.getElementById('preview-frame-container');
        const topBar = document.getElementById('preview-device-topbar');
        const bottomBar = document.getElementById('preview-device-bottombar');
        const resDisplay = document.getElementById('preview-resolution-display');

        const btnDesktop = document.getElementById('btn-device-desktop');
        const btnTablet = document.getElementById('btn-device-tablet');
        const btnMobile = document.getElementById('btn-device-mobile');

        const allBtns = [btnDesktop, btnTablet, btnMobile];
        allBtns.forEach(btn => {
            if (btn) {
                btn.className = 'preview-device-btn flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-gray-400 hover:text-white hover:bg-gray-700/50 transition';
            }
        });

        const activeClass = 'preview-device-btn flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-white bg-emerald-600 shadow-sm transition';

        if (device === 'desktop') {
            if (btnDesktop) btnDesktop.className = activeClass;
            wrapper.style.width = '100%';
            wrapper.style.maxWidth = '100%';
            wrapper.style.height = '100%';
            frameContainer.className = 'w-full h-full relative overflow-hidden bg-white shadow-2xl transition-all duration-300 ease-out rounded-xl border border-gray-800';
            if (topBar) topBar.classList.add('hidden');
            if (bottomBar) bottomBar.classList.add('hidden');
            if (resDisplay) resDisplay.textContent = 'Desktop: 100% (Layar Penuh)';
        } else if (device === 'tablet') {
            if (btnTablet) btnTablet.className = activeClass;
            wrapper.style.width = '768px';
            wrapper.style.maxWidth = '92vw';
            wrapper.style.height = '94%';
            frameContainer.className = 'w-full h-full relative overflow-hidden bg-white shadow-2xl transition-all duration-300 ease-out rounded-2xl border-4 border-gray-700';
            if (topBar) topBar.classList.add('hidden');
            if (bottomBar) bottomBar.classList.add('hidden');
            if (resDisplay) resDisplay.textContent = 'Tablet: 768px (iPad)';
        } else if (device === 'mobile') {
            if (btnMobile) btnMobile.className = activeClass;
            wrapper.style.width = '390px';
            wrapper.style.maxWidth = '90vw';
            wrapper.style.height = '92%';
            frameContainer.className = 'w-full h-full relative overflow-hidden bg-white shadow-2xl transition-all duration-300 ease-out rounded-b-2xl border-x-8 border-b-8 border-gray-800';
            if (topBar) topBar.classList.remove('hidden');
            if (bottomBar) bottomBar.classList.remove('hidden');
            if (resDisplay) resDisplay.textContent = 'Mobile: 390px (Smartphone)';
        }
    }

    function switchPreviewLanguage(lang) {
        currentPreviewLang = lang;
        const btnId = document.getElementById('preview-lang-id');
        const btnEn = document.getElementById('preview-lang-en');
        const iframe = document.getElementById('admin-preview-iframe');
        const overlay = document.getElementById('preview-loading-overlay');

        if (btnId && btnEn) {
            if (lang === 'id') {
                btnId.className = 'px-2 py-1 rounded text-white bg-brand-green font-bold';
                btnEn.className = 'px-2 py-1 rounded text-gray-400 hover:text-white font-medium';
            } else {
                btnEn.className = 'px-2 py-1 rounded text-white bg-brand-green font-bold';
                btnId.className = 'px-2 py-1 rounded text-gray-400 hover:text-white font-medium';
            }
        }

        // Fetch locale switch via fetch or iframe
        if (overlay) overlay.style.display = 'flex';
        fetch('/lang/' + lang)
            .then(() => {
                if (iframe) {
                    iframe.contentWindow.location.reload();
                }
            })
            .catch(() => {
                if (iframe) {
                    iframe.src = '/lang/' + lang;
                }
            });
    }

    function reloadPreviewFrame() {
        const iframe = document.getElementById('admin-preview-iframe');
        const reloadIcon = document.getElementById('preview-reload-icon');
        const overlay = document.getElementById('preview-loading-overlay');

        if (reloadIcon) reloadIcon.classList.add('fa-spin');
        if (overlay) overlay.style.display = 'flex';

        if (iframe && iframe.contentWindow) {
            iframe.contentWindow.location.reload();
        }
    }

    function openPreviewInNewTab() {
        const iframe = document.getElementById('admin-preview-iframe');
        let target = currentPreviewUrl;
        try {
            if (iframe && iframe.contentWindow && iframe.contentWindow.location.href) {
                target = iframe.contentWindow.location.href;
            }
        } catch (e) {
            target = currentPreviewUrl;
        }
        window.open(target, '_blank');
    }

    // Keyboard shortcut handlers: ESC closes preview, Alt+P opens preview
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('admin-live-preview-modal');
            if (modal && !modal.classList.contains('hidden')) {
                closeLivePreviewModal();
            }
        } else if (e.altKey && (e.key === 'p' || e.key === 'P')) {
            e.preventDefault();
            const modal = document.getElementById('admin-live-preview-modal');
            if (modal && modal.classList.contains('hidden')) {
                openLivePreviewModal();
            } else {
                closeLivePreviewModal();
            }
        }
    });
</script>
