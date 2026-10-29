<nav class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="/images/logo-lintasan.png" alt="Yayasan LINTASAN" class="h-16 w-auto object-contain">
                </a>
            </div>
            
            <!-- Menu Links (Desktop) -->
            <div class="hidden md:flex items-center space-x-6 text-sm font-medium text-gray-600">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-brand-green border-b-2 border-brand-green pb-1 font-semibold' : 'hover:text-brand-green transition pb-1' }}">
                    {{ db_trans('menu_home', 'Beranda', 'Home') }}
                </a>

                <!-- Dropdown 1: Program & Dampak -->
                @php
                    $isProgramActive = request()->routeIs('public.programs.*') || request()->routeIs('public.pages.desabinaan') || request()->routeIs('public.pages.village.*') || request()->routeIs('public.stories.*');
                @endphp
                <div class="relative group pb-1">
                    <button class="hover:text-brand-green transition pb-1 flex items-center gap-1 {{ $isProgramActive ? 'text-brand-green border-b-2 border-brand-green font-semibold' : '' }}">
                        <span>{{ db_trans('menu_programs_impact', 'Program & Dampak', 'Programs & Impact') }}</span>
                        <i class="fas fa-chevron-down text-[10px] opacity-70 group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    <div class="absolute left-0 mt-1 w-52 bg-white border border-gray-150 rounded-xl shadow-lg py-2 hidden group-hover:block z-50 transition-all duration-300 animate-fadeIn">
                        <a href="{{ route('public.programs.index') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-green-50/55 hover:text-brand-green transition font-semibold">
                            {{ db_trans('menu_program', 'Program', 'Program') }}
                        </a>
                        <a href="{{ route('public.pages.desabinaan') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-green-50/55 hover:text-brand-green transition font-semibold">
                            {{ db_trans('menu_assisted_villages', 'Desa Mitra Lintasan', 'Partner Villages') }}
                        </a>
                        <a href="{{ route('public.stories.index') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-green-50/55 hover:text-brand-green transition font-semibold">
                            {{ db_trans('menu_impact_stories', 'Cerita Lapangan', 'Field Stories') }}
                        </a>
                    </div>
                </div>

                <!-- Dropdown 2: Tentang Kami -->
                @php
                    $isAboutActive = request()->routeIs('public.pages.tentangkami') || request()->routeIs('public.pages.dibaliklintasan') || request()->routeIs('public.pages.mitra') || request()->routeIs('public.pages.galeri') || request()->routeIs('public.documents.*');
                @endphp
                <div class="relative group pb-1">
                    <button class="hover:text-brand-green transition pb-1 flex items-center gap-1 {{ $isAboutActive ? 'text-brand-green border-b-2 border-brand-green font-semibold' : '' }}">
                        <span>{{ db_trans('menu_about_us', 'Tentang Kami', 'About Us') }}</span>
                        <i class="fas fa-chevron-down text-[10px] opacity-70 group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    <div class="absolute left-0 mt-1 w-56 bg-white border border-gray-150 rounded-xl shadow-lg py-2 hidden group-hover:block z-50 transition-all duration-300 animate-fadeIn">
                        <a href="{{ route('public.pages.tentangkami') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-green-50/55 hover:text-brand-green transition font-semibold">
                            {{ db_trans('menu_about_us_profile', 'Profil Yayasan', 'Foundation Profile') }}
                        </a>
                        <a href="{{ route('public.pages.dibaliklintasan') }}" class="block px-4 py-2.5 text-xs {{ request()->routeIs('public.pages.dibaliklintasan') ? 'text-brand-green bg-green-50/50 font-bold' : 'text-gray-700' }} hover:bg-green-50/55 hover:text-brand-green transition font-semibold">
                            <span class="flex items-center justify-between">
                                <span>{{ db_trans('menu_dibalik_lintasan', 'Di Balik LINTASAN', 'Behind LINTASAN') }}</span>
                                <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.2 bg-brand-orange/10 text-brand-orange rounded">Tim</span>
                            </span>
                        </a>
                        <a href="{{ route('public.pages.mitra') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-green-50/55 hover:text-brand-green transition font-semibold">
                            {{ db_trans('menu_partners', 'Mitra Kolaborasi', 'Collaborative Partners') }}
                        </a>
                        <a href="{{ route('public.pages.galeri') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-green-50/55 hover:text-brand-green transition font-semibold">
                            {{ db_trans('menu_gallery', 'Galeri Kegiatan', 'Activity Gallery') }}
                        </a>
                        <a href="{{ route('public.documents.index') }}" class="block px-4 py-2.5 text-xs text-gray-700 hover:bg-green-50/55 hover:text-brand-green transition font-semibold">
                            {{ db_trans('menu_documents', 'Dokumen & Publikasi', 'Documents & Publications') }}
                        </a>
                    </div>
                </div>

                <a href="{{ route('public.volunteer.index') }}" class="{{ request()->routeIs('public.volunteer.*') ? 'text-brand-green border-b-2 border-brand-green pb-1 font-semibold' : 'hover:text-brand-green transition pb-1' }}">
                    {{ db_trans('menu_volunteers', 'Relawan', 'Volunteers') }}
                </a>
                <a href="{{ route('public.donasi') }}" class="{{ request()->routeIs('public.donasi') ? 'text-brand-green border-b-2 border-brand-green pb-1 font-semibold' : 'hover:text-brand-green transition pb-1' }}">
                    {{ db_trans('menu_donation', 'Donasi', 'Donation') }}
                </a>
            </div>
            
            <!-- Right Buttons (Desktop + Mobile Switcher) -->
            <div class="flex items-center space-x-3">
                <!-- Language Switcher -->
                <div class="flex items-center gap-1 text-[9px] sm:text-[10px] font-bold uppercase bg-gray-50 border border-gray-200 px-2.5 py-1.5 rounded-full shadow-sm">
                    <a href="/lang/id" class="{{ session('locale', 'id') == 'id' ? 'text-brand-green font-extrabold' : 'text-gray-400 hover:text-brand-green' }} transition">ID</a>
                    <span class="text-gray-300">|</span>
                    <a href="/lang/en" class="{{ session('locale') == 'en' ? 'text-brand-green font-extrabold' : 'text-gray-400 hover:text-brand-green' }} transition">EN</a>
                </div>

                <a href="{{ route('public.donasi') }}" class="hidden sm:inline-block bg-brand-orange text-white px-5 py-2.5 rounded-full text-xs font-bold hover:bg-orange-600 shadow-sm transition">
                    {{ db_trans('btn_donate', 'Donasi', 'Donate') }}
                </a>

                <a href="{{ route('public.volunteer.index') }}" class="hidden md:inline-block bg-brand-green text-white px-5 py-2.5 rounded-full text-xs font-bold hover:bg-brand-darkgreen shadow-sm transition">
                    {{ db_trans('btn_join_us', 'Relawan', 'Join Us') }}
                </a>

                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-btn" aria-label="Toggle mobile menu" class="md:hidden text-gray-600 hover:text-brand-green text-xl p-2 rounded-lg focus:outline-none focus:ring-1 focus:ring-brand-green/20">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu-dropdown" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-4 space-y-1.5 shadow-md flex flex-col text-xs font-bold text-gray-700">
        
        <!-- 1. Beranda -->
        <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('home') ? 'bg-green-50 text-brand-green' : 'hover:bg-gray-50 hover:text-brand-green' }} transition">
            <i class="fas fa-home w-4 text-center mr-1.5 opacity-60"></i>
            {{ db_trans('menu_home', 'Beranda', 'Home') }}
        </a>

        <!-- 2. Accordion Parent: Program & Dampak -->
        <div class="mobile-accordion-group rounded-lg border border-gray-100 overflow-hidden bg-white">
            <div class="flex items-center justify-between px-3 py-2.5 cursor-pointer hover:bg-gray-50 transition select-none {{ $isProgramActive ? 'bg-green-50/60 text-brand-green' : '' }}" onclick="toggleMobileSubmenu('submenu-program', this)">
                <span class="flex items-center gap-2">
                    <i class="fas fa-hand-holding-heart w-4 text-center text-brand-green"></i>
                    <span>{{ db_trans('menu_programs_impact', 'Program & Dampak', 'Programs & Impact') }}</span>
                </span>
                <button type="button" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition shadow-2xs" aria-label="Buka turunan menu Program & Dampak">
                    <i class="fas fa-plus text-[11px] accordion-icon transition-transform duration-200"></i>
                </button>
            </div>

            <!-- Submenu Children (Turunannya) -->
            <div id="submenu-program" class="{{ $isProgramActive ? '' : 'hidden' }} bg-gray-50/70 border-t border-gray-100 px-3 py-2 space-y-1 pl-6">
                <a href="{{ route('public.programs.index') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('public.programs.*') ? 'text-brand-green font-extrabold bg-white shadow-2xs' : 'text-gray-600 hover:text-brand-green hover:bg-white/80' }} transition">
                    <i class="fas fa-circle text-[6px] mr-2 text-brand-green/70"></i>
                    {{ db_trans('menu_program', 'Program', 'Program') }}
                </a>
                <a href="{{ route('public.pages.desabinaan') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('public.pages.desabinaan') ? 'text-brand-green font-extrabold bg-white shadow-2xs' : 'text-gray-600 hover:text-brand-green hover:bg-white/80' }} transition">
                    <i class="fas fa-circle text-[6px] mr-2 text-brand-green/70"></i>
                    {{ db_trans('menu_assisted_villages', 'Desa Mitra Lintasan', 'Partner Villages') }}
                </a>
                <a href="{{ route('public.stories.index') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('public.stories.*') ? 'text-brand-green font-extrabold bg-white shadow-2xs' : 'text-gray-600 hover:text-brand-green hover:bg-white/80' }} transition">
                    <i class="fas fa-circle text-[6px] mr-2 text-brand-green/70"></i>
                    {{ db_trans('menu_impact_stories', 'Cerita Lapangan', 'Field Stories') }}
                </a>
            </div>
        </div>

        <!-- 3. Accordion Parent: Tentang Kami -->
        <div class="mobile-accordion-group rounded-lg border border-gray-100 overflow-hidden bg-white">
            <div class="flex items-center justify-between px-3 py-2.5 cursor-pointer hover:bg-gray-50 transition select-none {{ $isAboutActive ? 'bg-green-50/60 text-brand-green' : '' }}" onclick="toggleMobileSubmenu('submenu-about', this)">
                <span class="flex items-center gap-2">
                    <i class="fas fa-building-columns w-4 text-center text-brand-orange"></i>
                    <span>{{ db_trans('menu_about_us', 'Tentang Kami', 'About Us') }}</span>
                </span>
                <button type="button" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition shadow-2xs" aria-label="Buka turunan menu Tentang Kami">
                    <i class="fas fa-plus text-[11px] accordion-icon transition-transform duration-200"></i>
                </button>
            </div>

            <!-- Submenu Children (Turunannya) -->
            <div id="submenu-about" class="{{ $isAboutActive ? '' : 'hidden' }} bg-gray-50/70 border-t border-gray-100 px-3 py-2 space-y-1 pl-6">
                <a href="{{ route('public.pages.tentangkami') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('public.pages.tentangkami') ? 'text-brand-green font-extrabold bg-white shadow-2xs' : 'text-gray-600 hover:text-brand-green hover:bg-white/80' }} transition">
                    <i class="fas fa-circle text-[6px] mr-2 text-brand-orange/70"></i>
                    {{ db_trans('menu_about_us_profile', 'Profil Yayasan', 'Foundation Profile') }}
                </a>
                <a href="{{ route('public.pages.dibaliklintasan') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('public.pages.dibaliklintasan') ? 'text-brand-green font-extrabold bg-white shadow-2xs' : 'text-gray-600 hover:text-brand-green hover:bg-white/80' }} transition">
                    <span class="flex items-center justify-between">
                        <span>
                            <i class="fas fa-circle text-[6px] mr-2 text-brand-green"></i>
                            {{ db_trans('menu_dibalik_lintasan', 'Di Balik LINTASAN', 'Behind LINTASAN') }}
                        </span>
                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.2 bg-brand-orange/10 text-brand-orange rounded">Tim</span>
                    </span>
                </a>
                <a href="{{ route('public.pages.mitra') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('public.pages.mitra') ? 'text-brand-green font-extrabold bg-white shadow-2xs' : 'text-gray-600 hover:text-brand-green hover:bg-white/80' }} transition">
                    <i class="fas fa-circle text-[6px] mr-2 text-brand-orange/70"></i>
                    {{ db_trans('menu_partners', 'Mitra Kolaborasi', 'Collaborative Partners') }}
                </a>
                <a href="{{ route('public.pages.galeri') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('public.pages.galeri') ? 'text-brand-green font-extrabold bg-white shadow-2xs' : 'text-gray-600 hover:text-brand-green hover:bg-white/80' }} transition">
                    <i class="fas fa-circle text-[6px] mr-2 text-brand-orange/70"></i>
                    {{ db_trans('menu_gallery', 'Galeri Kegiatan', 'Activity Gallery') }}
                </a>
                <a href="{{ route('public.documents.index') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('public.documents.*') ? 'text-brand-green font-extrabold bg-white shadow-2xs' : 'text-gray-600 hover:text-brand-green hover:bg-white/80' }} transition">
                    <i class="fas fa-circle text-[6px] mr-2 text-brand-orange/70"></i>
                    {{ db_trans('menu_documents', 'Dokumen & Publikasi', 'Documents & Publications') }}
                </a>
            </div>
        </div>

        <!-- 4. Relawan -->
        <a href="{{ route('public.volunteer.index') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('public.volunteer.*') ? 'bg-green-50 text-brand-green' : 'hover:bg-gray-50 hover:text-brand-green' }} transition">
            <i class="fas fa-users-line w-4 text-center mr-1.5 text-brand-green"></i>
            {{ db_trans('menu_volunteers', 'Relawan', 'Volunteers') }}
        </a>

        <!-- 5. Donasi -->
        <a href="{{ route('public.donasi') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('public.donasi') ? 'bg-orange-50 text-brand-orange' : 'hover:bg-gray-50 hover:text-brand-orange' }} transition">
            <i class="fas fa-heart w-4 text-center mr-1.5 text-brand-orange"></i>
            {{ db_trans('menu_donation', 'Donasi', 'Donation') }}
        </a>

        <!-- Bottom Action Buttons -->
        <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-100">
            <a href="{{ route('public.donasi') }}" class="block text-center bg-brand-orange hover:bg-orange-600 text-white py-2.5 rounded-lg font-bold shadow-xs transition">
                <i class="fas fa-hand-holding-heart mr-1"></i> {{ db_trans('btn_donate', 'Donasi', 'Donate') }}
            </a>
            <a href="{{ route('public.volunteer.index') }}" class="block text-center bg-brand-green hover:bg-brand-darkgreen text-white py-2.5 rounded-lg font-bold shadow-xs transition">
                <i class="fas fa-user-plus mr-1"></i> {{ db_trans('btn_join_us', 'Relawan', 'Join Us') }}
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu-dropdown');
        const icon = btn.querySelector('i');

        // Toggle Main Mobile Drawer
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

        // Initialize accordion icon state if already open on load
        document.querySelectorAll('.mobile-accordion-group').forEach(group => {
            const submenu = group.querySelector('[id^="submenu-"]');
            const iconEl = group.querySelector('.accordion-icon');
            if (submenu && !submenu.classList.contains('hidden') && iconEl) {
                iconEl.classList.remove('fa-plus');
                iconEl.classList.add('fa-minus');
            }
        });
    });

    // Toggle Submenu Accordion (Plus / Minus)
    function toggleMobileSubmenu(submenuId, triggerEl) {
        const submenu = document.getElementById(submenuId);
        if (!submenu) return;

        const isHidden = submenu.classList.contains('hidden');
        const iconEl = triggerEl.querySelector('.accordion-icon');

        if (isHidden) {
            submenu.classList.remove('hidden');
            if (iconEl) {
                iconEl.classList.remove('fa-plus');
                iconEl.classList.add('fa-minus');
            }
        } else {
            submenu.classList.add('hidden');
            if (iconEl) {
                iconEl.classList.remove('fa-minus');
                iconEl.classList.add('fa-plus');
            }
        }
    }
</script>
