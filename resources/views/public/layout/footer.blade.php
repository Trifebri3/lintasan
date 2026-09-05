<footer id="footer" class="bg-[#0b111e] text-gray-400 pt-16 pb-8 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
        <!-- Column 1: Brand Info -->
        <div>
            <div class="flex items-center gap-2 mb-4">
                <img src="/images/logo-lintasan.png" alt="Yayasan LINTASAN" class="h-14 w-auto object-contain brightness-0 invert">
            </div>
            <p class="text-xs leading-relaxed mb-6 text-gray-400">
                {!! db_trans('footer_desc', 'Yayasan LINTASAN berkomitmen membangun ketangguhan masyarakat melalui kolaborasi, pendampingan, dan program berkelanjutan.', 'Yayasan LINTASAN is committed to building community resilience through collaboration, mentorship, and sustainable programs.') !!}
            </p>
            @php
                $activeSocialLinks = \Illuminate\Support\Facades\Cache::remember('site_social_links', 3600, function() {
                    return \App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get()->toArray();
                });
            @endphp
            <div class="flex space-x-4 text-base mb-6">
                @foreach($activeSocialLinks as $link)
                    @php
                        $platform = strtolower($link['platform']);
                        $icons = [
                            'instagram' => 'fab fa-instagram',
                            'youtube' => 'fab fa-youtube',
                            'facebook' => 'fab fa-facebook',
                            'linkedin' => 'fab fa-linkedin-in',
                            'twitter' => 'fab fa-x-twitter',
                            'tiktok' => 'fab fa-tiktok',
                        ];
                        $iconClass = $icons[$platform] ?? 'fas fa-globe';
                    @endphp
                    <a href="{{ $link['url'] }}" target="_blank" class="hover:text-white transition" title="{{ $link['name'] }}">
                        <i class="{{ $iconClass }}"></i>
                    </a>
                @endforeach
            </div>

            <!-- Powered By Section -->
            <div class="pt-4 border-t border-white/10">
                <span class="text-[10px] font-semibold tracking-widest text-gray-400/90 uppercase block mb-2">POWERED BY</span>
                <div class="flex items-center gap-2.5 mb-2">
                    <a href="https://community.siyota.org" target="_blank" rel="noopener noreferrer" class="inline-block hover:opacity-100 transition" title="The Community Space by YOTA">
                        <img src="https://community.siyota.org/csyota.webp" onerror="this.onerror=null; this.src='/images/csyota.webp';" alt="The Community Space by YOTA" class="h-5 w-auto object-contain brightness-0 invert opacity-80 hover:opacity-100 transition">
                    </a>
                    <div class="h-4 w-px bg-white/20"></div>
                    <a href="https://siyota.org" target="_blank" rel="noopener noreferrer" class="inline-block hover:opacity-100 transition" title="Yayasan Yota Wujudkan Asa">
                        <img src="https://siyota.org/image/logo.png" onerror="this.onerror=null; this.src='/images/siyota-logo.png';" alt="Yayasan Yota Wujudkan Asa" class="h-5 w-auto object-contain brightness-0 invert opacity-80 hover:opacity-100 transition">
                    </a>
                </div>
                <p class="text-[11px] leading-relaxed text-gray-400/80">
                    {!! db_trans('footer_powered_by_desc', 'Inisiatif sosial Yayasan Yota Wujudkan Asa dalam bidang teknologi & kearifan lokal.', 'Social initiative of Yayasan Yota Wujudkan Asa in technology & local wisdom.') !!}
                </p>
            </div>
        </div>
        
        <!-- Column 2: Tautan Cepat -->
        <div>
            <h4 class="text-white font-bold text-sm mb-4">
                {{ db_trans('footer_quick_links', 'Tautan Cepat', 'Quick Links') }}
            </h4>
            <ul class="space-y-2 text-xs">
                <li><a href="{{ route('public.programs.index') }}" class="hover:text-white transition">{{ db_trans('menu_program', 'Program', 'Program') }}</a></li>
                <li><a href="{{ route('public.pages.desabinaan') }}" class="hover:text-white transition">{{ db_trans('menu_assisted_villages', 'Desa Mitra Lintasan', 'Partner Villages') }}</a></li>
                <li><a href="{{ route('public.stories.index') }}" class="hover:text-white transition">{{ db_trans('menu_impact_stories', 'Cerita Lapangan', 'Field Stories') }}</a></li>
                <li><a href="{{ route('public.pages.mitra') }}" class="hover:text-white transition">{{ db_trans('menu_partners', 'Mitra', 'Partners') }}</a></li>
                <li><a href="{{ route('public.pages.galeri') }}" class="hover:text-white transition">{{ db_trans('menu_gallery', 'Galeri', 'Gallery') }}</a></li>
                <li><a href="{{ route('public.volunteer.index') }}" class="hover:text-white transition">{{ db_trans('menu_volunteers', 'Relawan', 'Volunteers') }}</a></li>
            </ul>
        </div>
        
        <!-- Column 3: Tentang Kami -->
        <div>
            <h4 class="text-white font-bold text-sm mb-4">
                {{ db_trans('menu_about_us', 'Tentang Kami', 'About Us') }}
            </h4>
            <ul class="space-y-2 text-xs">
                <li><a href="{{ route('public.pages.tentangkami') }}" class="hover:text-white transition">{{ db_trans('footer_org_profile', 'Profil Organisasi', 'Organization Profile') }}</a></li>
                <li><a href="{{ route('public.pages.tentangkami') }}" class="hover:text-white transition">{{ db_trans('footer_vision_mission', 'Visi & Misi', 'Vision & Mission') }}</a></li>
                <li><a href="{{ route('public.pages.tentangkami') }}" class="hover:text-white transition">{{ db_trans('footer_our_values', 'Nilai-Nilai', 'Our Values') }}</a></li>
            </ul>
        </div>
        
        <!-- Column 4: Contact -->
        <div>
            <h4 class="text-white font-bold text-sm mb-4">
                {{ db_trans('footer_contact_us', 'Hubungi Kami', 'Contact Us') }}
            </h4>
            <ul class="space-y-3 text-xs">
                <li class="flex items-start gap-2">
                    <i class="fas fa-map-marker-alt text-brand-orange mt-0.5 shrink-0"></i>
                    <span>{!! db_trans('footer_address', 'Jl. Burangrang Dalam No. 106/38B<br>Kel. Burangrang, Kec. Lengkong<br>Kota Bandung 40262', 'Jl. Burangrang Dalam No. 106/38B<br>Kel. Burangrang, Kec. Lengkong<br>Bandung City 40262') !!}</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-phone text-brand-orange mt-0.5 shrink-0"></i>
                    <div class="flex flex-col">
                        <span>+62 82116108483</span>
                        <span>+62 81324451423</span>
                        <span>+62 85860423496</span>
                    </div>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-envelope text-brand-orange shrink-0"></i>
                    <span>{!! db_trans('footer_email', 'official@lintasan.or.id', 'official@lintasan.or.id') !!}</span>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Copyright -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-white/5 pt-6 text-center text-[11px] text-gray-500">
        <p>{!! db_trans('footer_copyright', '&copy; 2026 Yayasan LINTASAN. Hak cipta dilindungi undang-undang.', '&copy; 2026 Yayasan LINTASAN. All rights reserved.') !!}</p>
    </div>
</footer>
