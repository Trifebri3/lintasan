<header class="bg-white border-b border-gray-150 h-16 flex items-center justify-between px-4 sm:px-6 shrink-0 relative select-none">
    <div class="flex items-center gap-3">
        <!-- Hamburger menu for mobile screen size -->
        <button id="admin-mobile-menu-btn" class="md:hidden text-gray-500 hover:text-brand-green text-lg p-2 rounded-lg focus:outline-none focus:ring-1 focus:ring-brand-green/20">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile Logo -->
        <div class="flex md:hidden flex-col">
            <div class="text-brand-green font-bold text-lg tracking-wider flex items-center leading-none">
                LINTASAN<span class="text-brand-yellow text-[8px] font-normal ml-1">ADMIN</span>
            </div>
            <span class="text-[6px] text-gray-500 font-bold tracking-widest leading-none mt-0.5">YAYASAN KETANGGUHAN PESISIR</span>
        </div>
        
        <div class="hidden sm:flex items-center gap-2">
            <h2 class="text-sm font-bold text-gray-800">Panel Kontrol Yayasan LINTASAN</h2>
            <span class="text-[10px] bg-emerald-50 text-emerald-700 font-semibold px-2 py-0.5 rounded-full border border-emerald-200">CMS Terpadu</span>
        </div>
    </div>
    
    <div class="flex items-center gap-2.5 sm:gap-3">
        <!-- Live Preview Button in Header -->
        <button type="button" onclick="openLivePreviewModal('/')" title="Buka Live Preview Website Langsung (Alt+P)" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-brand-green hover:from-emerald-500 hover:to-emerald-600 text-white text-xs font-bold px-3 sm:px-3.5 py-2 rounded-xl shadow-sm hover:shadow transition transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-200 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
            </span>
            <i class="fas fa-desktop text-xs"></i>
            <span>Live Preview</span>
        </button>

        <!-- Direct Link to Public Web -->
        <a href="{{ route('home') }}" target="_blank" title="Buka Website di Tab Baru" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-brand-green px-3 py-2 rounded-xl border border-gray-200 hover:border-brand-green/30 bg-gray-50/70 hover:bg-emerald-50/40 transition">
            <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
            <span>Web Baru</span>
        </a>

        <!-- User Profile Avatar & Role -->
        <div class="flex items-center gap-2 pl-1 border-l border-gray-200">
            <div class="w-8 h-8 rounded-full bg-brand-green text-white flex items-center justify-center font-bold text-xs shadow-sm border border-brand-green/10">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="hidden lg:flex flex-col">
                <span class="text-xs font-bold text-gray-700 leading-tight">{{ Auth::user()->name }}</span>
                <span class="text-[9px] text-gray-400 capitalize font-medium">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>

    <!-- Admin Mobile Menu Dropdown -->
    <div id="admin-mobile-menu-dropdown" class="hidden md:hidden absolute top-16 left-0 right-0 border-b border-gray-200 bg-white px-5 py-4 space-y-3 shadow-xl max-h-[85vh] overflow-y-auto z-50 text-xs">
        <!-- Live Preview Mobile Button -->
        <button type="button" onclick="openLivePreviewModal('/'); document.getElementById('admin-mobile-menu-dropdown').classList.add('hidden');" class="w-full flex items-center justify-between p-2.5 rounded-lg bg-emerald-600 text-white font-bold shadow-sm">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-desktop text-sm"></i>
                <span>Buka Live Preview Website</span>
            </div>
            <span class="text-[9px] bg-white/20 px-2 py-0.5 rounded-full">LIVE</span>
        </button>

        <!-- Menu Utama -->
        <div>
            <div class="text-[10px] uppercase font-bold tracking-wider text-gray-400 mb-1">Utama</div>
            <div class="space-y-1">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-chart-line w-4 text-center"></i> Dashboard
                    </a>
                @endif
            </div>
        </div>

        <!-- Konten Website -->
        <div>
            <div class="text-[10px] uppercase font-bold tracking-wider text-gray-400 mb-1">Konten Website</div>
            <div class="space-y-1">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.hero-images.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-images w-4 text-center"></i> Slide Hero Banner
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-file-pen w-4 text-center"></i> Konten Halaman & Nilai
                    </a>
                    <a href="{{ route('admin.programs.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-hand-holding-heart w-4 text-center"></i> Program Unggulan
                    </a>
                @endif
                <a href="{{ route('admin.stories.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                    <i class="fas fa-newspaper w-4 text-center"></i> Cerita Lapangan
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-photo-film w-4 text-center"></i> Galeri Foto & Video
                    </a>
                    <a href="{{ route('admin.statistics.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-chart-simple w-4 text-center"></i> Statistik & Capaian
                    </a>
                @endif
            </div>
        </div>

        <!-- Jaringan & Mitra -->
        <div>
            <div class="text-[10px] uppercase font-bold tracking-wider text-gray-400 mb-1">Jaringan & Mitra</div>
            <div class="space-y-1">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.villages.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-map-location-dot w-4 text-center"></i> Desa Mitra Lintasan
                    </a>
                    <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-handshake w-4 text-center"></i> Mitra & Kerjasama
                    </a>
                    <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fas fa-users-line w-4 text-center"></i> Pendaftar Relawan
                    </a>
                @endif
            </div>
        </div>

        <!-- Pengaturan -->
        @if(Auth::user()->role === 'admin')
            <div>
                <div class="text-[10px] uppercase font-bold tracking-wider text-gray-400 mb-1">Pengaturan</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.social-links.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-brand-green font-semibold">
                        <i class="fab fa-instagram w-4 text-center"></i> Media Sosial & Kontak
                    </a>
                </div>
            </div>
        @endif
        
        <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
            <a href="{{ route('home') }}" target="_blank" class="block text-center border border-gray-200 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-50">
                <i class="fas fa-arrow-up-right-from-square mr-1"></i> Buka Situs Utama di Tab Baru
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="block w-full">
                @csrf
                <button type="submit" class="w-full text-center bg-red-50 text-red-600 border border-red-100 py-2 rounded-lg font-bold hover:bg-red-100 transition">
                    <i class="fas fa-right-from-bracket mr-1"></i> Keluar (Logout)
                </button>
            </form>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('admin-mobile-menu-btn');
        const menu = document.getElementById('admin-mobile-menu-dropdown');
        if (btn && menu) {
            const icon = btn.querySelector('i');
            btn.addEventListener('click', () => {
                const isHidden = menu.classList.contains('hidden');
                if (isHidden) {
                    menu.classList.remove('hidden');
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                } else {
                    menu.classList.add('hidden');
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            });
        }
    });
</script>
