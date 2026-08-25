<header class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-6 shrink-0 relative">
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
        
        <h2 class="text-sm font-bold text-gray-700 hidden sm:block">Panel Kontrol Yayasan LINTASAN</h2>
    </div>
    
    <div class="flex items-center gap-4">
        <span class="text-xs text-gray-500 font-medium capitalize">{{ Auth::user()->role }}</span>
        <div class="w-8 h-8 rounded-full bg-brand-green text-white flex items-center justify-center font-bold text-xs shadow-sm border border-brand-green/10">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    </div>

    <!-- Admin Mobile Menu Dropdown -->
    <div id="admin-mobile-menu-dropdown" class="hidden md:hidden absolute top-16 left-0 right-0 border-b border-gray-200 bg-white px-6 py-4 space-y-2.5 shadow-md flex flex-col text-xs font-bold text-gray-600 z-50">
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-chart-line w-4"></i> Dashboard
            </a>
            <a href="{{ route('admin.hero-images.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-images w-4"></i> Slide Hero
            </a>
            <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-file-lines w-4"></i> Konten Halaman
            </a>
            <a href="{{ route('admin.statistics.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-calculator w-4"></i> Statistik & Angka
            </a>
            <a href="{{ route('admin.programs.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-tasks w-4"></i> Program
            </a>
            <a href="{{ route('admin.villages.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-map-location-dot w-4"></i> Desa Mitra Lintasan
            </a>
        @endif
        <a href="{{ route('admin.stories.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
            <i class="fas fa-book-open w-4"></i> Cerita Lapangan
        </a>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.partners.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-handshake w-4"></i> Mitra
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-images w-4"></i> Galeri
            </a>
            <a href="{{ route('admin.volunteers.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fas fa-user-group w-4"></i> Pendaftar Relawan
            </a>
            <a href="{{ route('admin.social-links.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-brand-green transition flex items-center gap-2">
                <i class="fab fa-instagram w-4"></i> Media Sosial
            </a>
        @endif
        
        <div class="pt-2.5 border-t border-gray-100 flex flex-col gap-2">
            <a href="{{ route('home') }}" class="block text-center border border-gray-200 text-gray-600 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-1"></i> Situs Utama
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="block w-full">
                @csrf
                <button type="submit" class="w-full text-center bg-red-50 text-red-600 border border-red-100 py-2 rounded-lg">
                    <i class="fas fa-right-from-bracket mr-1"></i> Keluar
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
