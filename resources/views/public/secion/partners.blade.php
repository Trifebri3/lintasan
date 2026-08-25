<section id="partners" class="py-10 border-t border-b border-gray-100 bg-gray-50 overflow-hidden text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-xs font-bold tracking-wider text-gray-400 uppercase text-center mb-6">
            {{ db_trans('home_partners_title', 'Mitra Kolaborasi', 'Collaborative Partners') }}
        </h3>
        
        <style>
            @keyframes marquee {
                0% { transform: translateX(0%); }
                100% { transform: translateX(-50%); }
            }
            .marquee-container {
                display: flex;
                overflow: hidden;
                user-select: none;
                mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
                -webkit-mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
            }
            .marquee-content {
                display: flex;
                gap: 4rem;
                padding-right: 4rem;
                animation: marquee 35s linear infinite;
                align-items: center;
                flex-shrink: 0;
            }
            .marquee-container:hover .marquee-content {
                animation-play-state: paused;
            }
        </style>
        
        <div class="marquee-container">
            <!-- First Row of Logos -->
            <div class="marquee-content">
                @forelse($partners as $partner)
                    @if($partner->logo_path)
                        <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center shrink-0 transition duration-500 hover:scale-110 filter grayscale opacity-50 hover:grayscale-0 hover:opacity-100">
                            @if($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" title="Kunjungi {{ $partner->name }}" class="flex items-center justify-center w-full h-full">
                                    <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                                </a>
                            @else
                                <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                            @endif
                        </div>
                    @endif
                @empty
                    <!-- Fallback Partners -->
                    <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center shrink-0 filter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-500 hover:scale-110">
                        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=100&q=80" alt="BAZNAS" class="max-h-full max-w-full object-contain">
                    </div>
                    <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center shrink-0 filter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-500 hover:scale-110">
                        <img src="https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&w=100&q=80" alt="Disdik" class="max-h-full max-w-full object-contain">
                    </div>
                    <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center shrink-0 filter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-500 hover:scale-110">
                        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=100&q=80" alt="PUSKESMAS" class="max-h-full max-w-full object-contain">
                    </div>
                @endforelse
            </div>
            
            <!-- Duplicated Row of Logos for Seamless Loop -->
            <div class="marquee-content" aria-hidden="true">
                @forelse($partners as $partner)
                    @if($partner->logo_path)
                        <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center shrink-0 transition duration-500 hover:scale-110 filter grayscale opacity-50 hover:grayscale-0 hover:opacity-100">
                            @if($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" title="Kunjungi {{ $partner->name }}" class="flex items-center justify-center w-full h-full">
                                    <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                                </a>
                            @else
                                <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                            @endif
                        </div>
                    @endif
                @empty
                    <!-- Fallback Partners -->
                    <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center shrink-0 filter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-500 hover:scale-110">
                        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=100&q=80" alt="BAZNAS" class="max-h-full max-w-full object-contain">
                    </div>
                    <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center shrink-0 filter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-500 hover:scale-110">
                        <img src="https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&w=100&q=80" alt="Disdik" class="max-h-full max-w-full object-contain">
                    </div>
                    <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center shrink-0 filter grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-500 hover:scale-110">
                        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=100&q=80" alt="PUSKESMAS" class="max-h-full max-w-full object-contain">
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
