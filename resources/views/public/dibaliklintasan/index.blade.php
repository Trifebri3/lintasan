@extends('public.layout.app')

@section('title', ($settings['title_dibalik_lintasan'] ?? 'Di Balik LINTASAN') . ' - ' . ($settings['badge_dibalik_lintasan'] ?? 'Board, Leadership & Team') . ' - Yayasan LINTASAN')
@section('meta_description', $settings['subtitle_dibalik_lintasan'] ?? 'Mengenal figur pendiri, pembina, pengawas, pengurus, dan penggerak di balik langkah nyata Yayasan LINTASAN.')

@section('content')
<!-- Hero Banner -->
<div class="relative bg-cover bg-center py-20 sm:py-28 text-white overflow-hidden shadow-sm" style="background-image: linear-gradient(rgba(11, 17, 30, 0.82), rgba(11, 17, 30, 0.72)), url('{{ $settings['bg_photo_dibalik_lintasan'] ?? 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1920&q=80' }}');">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <!-- Breadcrumb -->
        <nav class="flex justify-center items-center gap-2 text-xs text-gray-300 mb-4 font-medium" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white transition">{{ db_trans('menu_home', 'Beranda', 'Home') }}</a>
            <span class="opacity-60">/</span>
            <a href="{{ route('public.pages.tentangkami') }}" class="hover:text-white transition">{{ db_trans('menu_about_us', 'Tentang Kami', 'About Us') }}</a>
            <span class="opacity-60">/</span>
            <span class="text-brand-orange font-semibold">{{ $settings['title_dibalik_lintasan'] ?? 'Di Balik LINTASAN' }}</span>
        </nav>

        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 text-brand-orange px-4 py-1.5 rounded-full text-[11px] font-extrabold uppercase tracking-widest mb-4 shadow-sm">
            <i class="fas fa-users-viewfinder text-xs"></i>
            <span>{{ $settings['badge_dibalik_lintasan'] ?? 'BOARD, LEADERSHIP & TEAM' }}</span>
        </div>

        <!-- Heading -->
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4 drop-shadow-sm">
            {{ $settings['title_dibalik_lintasan'] ?? 'Di Balik LINTASAN' }}
        </h1>
        <div class="h-1.5 w-16 bg-brand-orange mx-auto rounded-full mb-5"></div>

        <!-- Subtitle -->
        <p class="text-gray-200 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed font-light drop-shadow">
            {{ $settings['subtitle_dibalik_lintasan'] ?? (session('locale') == 'en' ? 'Get to know the founders, trustees, leadership, and dedicated team behind Yayasan LINTASAN.' : 'Mengenal figur pendiri, pembina, pengawas, pengurus, dan penggerak di balik langkah nyata Yayasan LINTASAN.') }}
        </p>
    </div>
</div>

<!-- Main Content Area -->
<div class="bg-gray-50 py-14 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Category Filter Tabs (Pills) -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12" id="people-filter-bar">
            <button type="button" onclick="filterPeople('all')" class="filter-btn active px-4 py-2 rounded-full text-xs font-bold transition-all duration-200 shadow-sm bg-brand-green text-white border border-brand-green hover:shadow-md" data-category="all">
                {{ session('locale') == 'en' ? 'All Roles' : 'Semua Struktur' }} ({{ $members->count() }})
            </button>
            @foreach($categories as $catKey => $catInfo)
                @php
                    $catCount = $members->where('category', $catKey)->count();
                @endphp
                @if($catCount > 0)
                    <button type="button" onclick="filterPeople('{{ $catKey }}')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold transition-all duration-200 bg-white text-gray-700 border border-gray-200 hover:border-brand-green hover:text-brand-green shadow-xs hover:shadow-sm" data-category="{{ $catKey }}">
                        <i class="fas {{ $catInfo['icon'] }} text-[11px] mr-1 opacity-70"></i>
                        {{ session('locale') == 'en' ? $catInfo['en'] : $catInfo['id'] }} ({{ $catCount }})
                    </button>
                @endif
            @endforeach
        </div>

        <!-- People Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="people-cards-grid">
            @forelse($members as $person)
                <div class="person-card bg-white rounded-2xl border border-gray-150 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group hover:-translate-y-1" data-category="{{ $person->category }}">
                    <!-- Photo Header -->
                    <div class="relative h-64 bg-gray-100 overflow-hidden flex items-center justify-center">
                        @if($person->photo_path)
                            <img src="{{ $person->photo_path }}" alt="{{ $person->name }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-24 h-24 rounded-full bg-emerald-100 text-brand-green flex items-center justify-center text-4xl font-extrabold shadow-inner">
                                {{ strtoupper(substr($person->name, 0, 1)) }}
                            </div>
                        @endif

                        <!-- Gradient Scrim at bottom of photo -->
                        <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>

                        <!-- Category Pill (Top-Right) -->
                        <span class="absolute top-3 right-3 text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full border shadow-xs backdrop-blur-md {{ $person->category_badge }}">
                            {{ $person->category_label }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-extrabold text-gray-900 group-hover:text-brand-green transition-colors leading-snug">
                                {{ $person->name }}
                            </h3>
                            <p class="text-xs font-semibold text-brand-orange mt-1 mb-3">
                                {{ $person->role }}
                            </p>
                            @if($person->bio)
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                    {{ $person->bio }}
                                </p>
                            @endif
                        </div>

                        <!-- Card Footer / Actions -->
                        <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between">
                            <button type="button" onclick="openBioModal({{ $person->id }})" class="text-xs font-bold text-brand-green hover:text-brand-darkgreen flex items-center gap-1.5 transition">
                                <span>{{ session('locale') == 'en' ? 'View Profile' : 'Lihat Profil' }}</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                            </button>

                            <div class="flex items-center gap-2 text-gray-400">
                                @if($person->social_linkedin)
                                    <a href="{{ $person->social_linkedin }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600 transition p-1" title="LinkedIn Profile">
                                        <i class="fab fa-linkedin text-sm"></i>
                                    </a>
                                @endif
                                @if($person->social_email)
                                    <a href="mailto:{{ $person->social_email }}" class="hover:text-brand-green transition p-1" title="Email">
                                        <i class="fas fa-envelope text-sm"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-400">
                    <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                    <p class="text-sm font-semibold">
                        {{ session('locale') == 'en' ? 'No profiles found.' : 'Belum ada data figur yang ditampilkan.' }}
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Call to Action Banner -->
        <div class="mt-16 bg-white rounded-2xl border border-gray-150 p-8 sm:p-10 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-1">
                    {{ session('locale') == 'en' ? 'Collaboration & Partnership' : 'Kolaborasi & Kemitraan' }}
                </span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900">
                    {{ session('locale') == 'en' ? 'Want to work together with our leadership team?' : 'Ingin Bergerak & Berkolaborasi Bersama Kami?' }}
                </h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-xl">
                    {{ session('locale') == 'en' ? 'Join us as an institutional partner or member of the LINTASAN network.' : 'Jadilah mitra lembaga atau bergabung dalam jejaring penggerak pesisir Yayasan LINTASAN.' }}
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('public.pages.mitra') }}" class="bg-brand-orange text-white px-5 py-2.5 rounded-lg text-xs font-bold hover:bg-orange-600 shadow-sm transition flex items-center gap-2">
                    <i class="fas fa-handshake"></i>
                    <span>{{ db_trans('cta_btn_partner', 'Menjadi Mitra', 'Become a Partner') }}</span>
                </a>
                <a href="{{ route('public.volunteer.index') }}" class="bg-brand-green text-white px-5 py-2.5 rounded-lg text-xs font-bold hover:bg-brand-darkgreen shadow-sm transition flex items-center gap-2">
                    <i class="fas fa-users-line"></i>
                    <span>{{ db_trans('volunteer_title', 'Menjadi Jejaring Lintasan', 'Join the LINTASAN Network') }}</span>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Modal Detail Profil Lengkap -->
<div id="bio-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl border border-gray-100 transform transition-all animate-fadeIn" onclick="event.stopPropagation()">
        <!-- Modal Header with Image -->
        <div class="relative h-48 bg-gradient-to-r from-emerald-800 to-teal-900 p-6 flex items-end">
            <button type="button" onclick="closeBioModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center transition focus:outline-none">
                <i class="fas fa-times text-sm"></i>
            </button>
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-full border-2 border-white overflow-hidden shadow-lg bg-white shrink-0">
                    <img id="modal-photo" src="" alt="" class="w-full h-full object-cover object-top">
                    <div id="modal-avatar-fallback" class="w-full h-full bg-emerald-100 text-brand-green flex items-center justify-center text-2xl font-extrabold hidden"></div>
                </div>
                <div class="text-white">
                    <span id="modal-badge" class="inline-block text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full mb-1"></span>
                    <h4 id="modal-name" class="text-base sm:text-lg font-extrabold leading-tight"></h4>
                    <p id="modal-role" class="text-xs text-brand-yellow font-medium mt-0.5"></p>
                </div>
            </div>
        </div>

        <!-- Modal Body: Bio -->
        <div class="p-6 space-y-4">
            <div>
                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                    {{ session('locale') == 'en' ? 'Profile & Biography' : 'Profil & Riwayat Peran' }}
                </h5>
                <div id="modal-bio" class="text-xs text-gray-700 leading-relaxed whitespace-pre-line font-medium"></div>
            </div>

            <!-- Social / Contact Links -->
            <div id="modal-socials" class="pt-4 border-t border-gray-100 flex items-center gap-3"></div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-end">
            <button type="button" onclick="closeBioModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-xs font-bold transition">
                {{ session('locale') == 'en' ? 'Close' : 'Tutup' }}
            </button>
        </div>
    </div>
</div>

<!-- Data JSON for Modal -->
<script>
    const teamMembersData = @json($members->keyBy('id'));

    function filterPeople(category) {
        // Toggle active button styling
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            if (btn.getAttribute('data-category') === category) {
                btn.classList.add('active', 'bg-brand-green', 'text-white', 'border-brand-green');
                btn.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
            } else {
                btn.classList.remove('active', 'bg-brand-green', 'text-white', 'border-brand-green');
                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
            }
        });

        // Filter cards
        const cards = document.querySelectorAll('.person-card');
        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category');
            if (category === 'all' || cardCat === category) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function openBioModal(id) {
        const person = teamMembersData[id];
        if (!person) return;

        const modal = document.getElementById('bio-modal');
        const photoEl = document.getElementById('modal-photo');
        const fallbackEl = document.getElementById('modal-avatar-fallback');
        const badgeEl = document.getElementById('modal-badge');
        const nameEl = document.getElementById('modal-name');
        const roleEl = document.getElementById('modal-role');
        const bioEl = document.getElementById('modal-bio');
        const socialsEl = document.getElementById('modal-socials');

        // Set photo or fallback
        if (person.photo_path) {
            photoEl.src = person.photo_path;
            photoEl.classList.remove('hidden');
            fallbackEl.classList.add('hidden');
        } else {
            photoEl.classList.add('hidden');
            fallbackEl.textContent = (person.name || 'L').charAt(0).toUpperCase();
            fallbackEl.classList.remove('hidden');
        }

        nameEl.textContent = person.name;
        roleEl.textContent = (document.documentElement.lang === 'en' && person.role_en) ? person.role_en : person.role_id;
        badgeEl.textContent = person.category_label || person.category;
        badgeEl.className = 'inline-block text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full mb-1 ' + (person.category_badge || 'bg-white/20 text-white');
        
        const bioText = (document.documentElement.lang === 'en' && person.bio_en) ? person.bio_en : (person.bio_id || 'Tidak ada deskripsi profil tambahan.');
        bioEl.textContent = bioText;

        // Socials
        socialsEl.innerHTML = '';
        if (person.social_linkedin) {
            socialsEl.innerHTML += `
                <a href="${person.social_linkedin}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-bold transition">
                    <i class="fab fa-linkedin text-sm"></i>
                    <span>LinkedIn</span>
                </a>
            `;
        }
        if (person.social_email) {
            socialsEl.innerHTML += `
                <a href="mailto:${person.social_email}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-brand-green hover:bg-emerald-100 rounded-lg text-xs font-bold transition">
                    <i class="fas fa-envelope text-sm"></i>
                    <span>${person.social_email}</span>
                </a>
            `;
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeBioModal() {
        const modal = document.getElementById('bio-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close on backdrop click
    document.getElementById('bio-modal')?.addEventListener('click', (e) => {
        if (e.target.id === 'bio-modal') {
            closeBioModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeBioModal();
        }
    });
</script>
@endsection

