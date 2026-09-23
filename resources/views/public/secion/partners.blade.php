<section id="partners" class="py-10 border-t border-b border-gray-100 bg-gray-50 overflow-hidden text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-xs font-bold tracking-wider text-gray-400 uppercase text-center mb-6">
            {{ db_trans('home_partners_title', 'Mitra Kolaborasi', 'Collaborative Partners') }}
        </h3>
        
        <style>
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-100%); }
            }
            .marquee-container {
                display: flex;
                overflow: hidden;
                user-select: none;
                mask-image: linear-gradient(to right, transparent, white 10%, white 90%, transparent);
                -webkit-mask-image: linear-gradient(to right, transparent, white 10%, white 90%, transparent);
            }
            .marquee-content {
                display: flex;
                gap: 3.5rem;
                padding-right: 3.5rem;
                animation: marquee 30s linear infinite;
                align-items: center;
                flex-shrink: 0;
                will-change: transform;
            }
        </style>
        
        @php
            $fallbackList = collect([
                (object)['name' => 'BAZNAS', 'logo_path' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=200&q=80', 'url' => null],
                (object)['name' => 'Disdik', 'logo_path' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&w=200&q=80', 'url' => null],
                (object)['name' => 'PUSKESMAS', 'logo_path' => 'https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=200&q=80', 'url' => null],
            ]);

            $partnerList = ($partners && $partners->count() > 0) ? $partners : $fallbackList;

            // Gandakan item jika sedikit agar track selalu melingkar penuh & mulus di layar lebar
            if ($partnerList->count() < 8) {
                $partnerList = $partnerList->concat($partnerList);
            }
            if ($partnerList->count() < 8) {
                $partnerList = $partnerList->concat($partnerList);
            }
        @endphp

        <div class="marquee-container">
            <!-- First Row of Logos -->
            <div class="marquee-content">
                @foreach($partnerList as $partner)
                    @if($partner->logo_path)
                        <div class="w-32 h-14 md:w-40 md:h-16 flex items-center justify-center shrink-0 transition duration-300 hover:scale-105 filter grayscale opacity-75 hover:grayscale-0 hover:opacity-100">
                            @if(isset($partner->url) && $partner->url)
                                <a href="{{ $partner->url }}" target="_blank" title="Kunjungi {{ $partner->name }}" class="flex items-center justify-center w-full h-full p-1">
                                    <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-10 md:max-h-12 max-w-[120px] md:max-w-[150px] w-auto h-auto object-contain">
                                </a>
                            @else
                                <div class="flex items-center justify-center w-full h-full p-1">
                                    <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-10 md:max-h-12 max-w-[120px] md:max-w-[150px] w-auto h-auto object-contain">
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
            
            <!-- Duplicated Row of Logos for Seamless 100% Constant Loop -->
            <div class="marquee-content" aria-hidden="true">
                @foreach($partnerList as $partner)
                    @if($partner->logo_path)
                        <div class="w-32 h-14 md:w-40 md:h-16 flex items-center justify-center shrink-0 transition duration-300 hover:scale-105 filter grayscale opacity-75 hover:grayscale-0 hover:opacity-100">
                            @if(isset($partner->url) && $partner->url)
                                <a href="{{ $partner->url }}" target="_blank" title="Kunjungi {{ $partner->name }}" class="flex items-center justify-center w-full h-full p-1">
                                    <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-10 md:max-h-12 max-w-[120px] md:max-w-[150px] w-auto h-auto object-contain">
                                </a>
                            @else
                                <div class="flex items-center justify-center w-full h-full p-1">
                                    <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-10 md:max-h-12 max-w-[120px] md:max-w-[150px] w-auto h-auto object-contain">
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
