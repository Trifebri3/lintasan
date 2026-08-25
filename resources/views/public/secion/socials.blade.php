@php
    $activeSocialLinks = \Illuminate\Support\Facades\Cache::remember('site_social_links', 3600, function() {
        return \App\Models\SocialLink::where('is_active', true)->orderBy('sort_order')->get()->toArray();
    });
    
    $globalShowSocial = \App\Models\Setting::where('key', 'show_social_section')->first();
    $showSection = $globalShowSocial ? ($globalShowSocial->value_id ?? '1') : '1';
@endphp

@if($showSection === '1' && count($activeSocialLinks) > 0)
<section id="social-section" class="py-16 bg-gradient-to-b from-gray-50 to-white overflow-hidden text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-brand-green font-bold uppercase tracking-wider text-[10px] bg-green-50 px-3 py-1 rounded-full">
                {{ db_trans('home_socials_badge', 'Tetap Terhubung', 'Stay Connected') }}
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-3 mb-4 leading-tight">
                {{ db_trans('home_socials_title', 'Ikuti Perjalanan Kami di Media Sosial', 'Follow Our Journey on Social Media') }}
            </h2>
            <p class="text-gray-500 text-xs sm:text-sm leading-relaxed">
                {{ db_trans('home_socials_desc', 'Dapatkan informasi terbaru, dokumentasi kegiatan lapangan, dan kisah inspiratif secara langsung.', 'Get the latest updates, stories from the field, and live documentation of our programs.') }}
            </p>
        </div>

        <!-- Flexbox with automatic centering -->
        <div class="flex flex-wrap justify-center gap-6">
            
            @foreach($activeSocialLinks as $link)
                @php
                    $platform = strtolower($link['platform']);
                    $name = $link['name'];
                    $url = $link['url'];
                    $desc = session('locale') == 'en' ? ($link['description_en'] ?: $link['description_id']) : $link['description_id'];
                    
                    // Style config maps
                    $styles = [
                        'instagram' => [
                            'bg' => 'bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7]',
                            'icon' => 'fab fa-instagram',
                            'color' => 'text-[#ee2a7b]',
                            'label' => db_trans('social_instagram_label', 'Ikuti Instagram', 'Follow Instagram'),
                            'hover_bg' => 'text-[#ee2a7b]/5'
                        ],
                        'youtube' => [
                            'bg' => 'bg-red-600',
                            'icon' => 'fab fa-youtube',
                            'color' => 'text-red-600',
                            'label' => db_trans('social_youtube_label', 'Langganan Video', 'Subscribe Channel'),
                            'hover_bg' => 'text-red-600/5'
                        ],
                        'facebook' => [
                            'bg' => 'bg-blue-600',
                            'icon' => 'fab fa-facebook-f',
                            'color' => 'text-blue-600',
                            'label' => db_trans('social_facebook_label', 'Kunjungi Halaman', 'Visit Page'),
                            'hover_bg' => 'text-blue-600/5'
                        ],
                        'linkedin' => [
                            'bg' => 'bg-blue-700',
                            'icon' => 'fab fa-linkedin-in',
                            'color' => 'text-blue-700',
                            'label' => db_trans('social_linkedin_label', 'Hubungkan Relasi', 'Connect Now'),
                            'hover_bg' => 'text-blue-700/5'
                        ],
                        'twitter' => [
                            'bg' => 'bg-gray-900',
                            'icon' => 'fab fa-x-twitter',
                            'color' => 'text-gray-900',
                            'label' => db_trans('social_twitter_label', 'Ikuti X', 'Follow X'),
                            'hover_bg' => 'text-gray-900/5'
                        ],
                        'tiktok' => [
                            'bg' => 'bg-black',
                            'icon' => 'fab fa-tiktok',
                            'color' => 'text-black',
                            'label' => db_trans('social_tiktok_label', 'Ikuti TikTok', 'Follow TikTok'),
                            'hover_bg' => 'text-black/5'
                        ]
                    ];
                    
                    $cfg = $styles[$platform] ?? [
                        'bg' => 'bg-brand-green',
                        'icon' => 'fas fa-globe',
                        'color' => 'text-brand-green',
                        'label' => db_trans('social_default_label', 'Kunjungi Tautan', 'Visit Link'),
                        'hover_bg' => 'text-brand-green/5'
                    ];
                @endphp
                
                <a href="{{ $url }}" target="_blank" class="group relative bg-white rounded-2xl p-6 border border-gray-150 shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300 flex flex-col justify-between overflow-hidden w-full sm:w-[280px] shrink-0 min-h-[250px]">
                    <div class="absolute -right-6 -bottom-6 {{ $cfg['hover_bg'] }} group-hover:scale-125 transition duration-500">
                        <i class="{{ $cfg['icon'] }} text-9xl"></i>
                    </div>
                    <div>
                        <div class="w-12 h-12 rounded-xl {{ $cfg['bg'] }} text-white flex items-center justify-center text-xl shadow-md mb-4 group-hover:scale-110 transition duration-300">
                            <i class="{{ $cfg['icon'] }}"></i>
                        </div>
                        <h3 class="font-extrabold text-sm text-gray-900 group-hover:{{ $cfg['color'] }} transition capitalize">{{ $platform }}</h3>
                        <p class="text-gray-400 text-[10px] mt-1 leading-snug">{{ $name }}</p>
                        <p class="text-gray-500 mt-3 leading-relaxed text-[11px]">{{ $desc }}</p>
                    </div>
                    <div class="mt-6 flex items-center gap-1 {{ $cfg['color'] }} font-bold text-[10px] uppercase tracking-wider group-hover:gap-1.5 transition">
                        <span>{{ $cfg['label'] }}</span>
                        <i class="fas fa-arrow-right text-[9px]"></i>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
</section>
@endif
