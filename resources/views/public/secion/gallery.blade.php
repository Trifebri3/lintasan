@if(!empty($galleryItems) && count($galleryItems) > 0)
<section id="home-gallery" class="py-16 bg-white border-b border-gray-50 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 text-center md:text-left">
            <div>
                <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                    {{ db_trans('home_gallery_badge', 'Galeri Kegiatan', 'Activity Gallery') }}
                </span>
                <h2 class="text-3xl font-extrabold text-gray-900">
                    {{ db_trans('home_gallery_title', 'Dokumentasi & Galeri Terbaru', 'Documentation & Highlights') }}
                </h2>
                <div class="h-1 w-12 bg-brand-green mt-3 mx-auto md:mx-0 rounded"></div>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('public.pages.galeri') }}" class="inline-flex items-center gap-1.5 text-brand-green font-bold text-xs hover:text-brand-darkgreen transition">
                    {{ db_trans('home_gallery_view_all', 'Lihat Semua Galeri', 'View All Gallery') }} <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Bento Grid for Homepage -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 auto-rows-[220px]">
            @foreach($galleryItems as $item)
                @php
                    $isFeatured = $item->layout_size === 'featured';
                    $isWide = $item->layout_size === 'wide';
                    $isTall = $item->layout_size === 'tall';
                @endphp
                <div class="group relative rounded-2xl overflow-hidden border border-gray-200/80 bg-gray-900 shadow-sm hover:shadow-xl transition-all duration-300 transform flex flex-col justify-end {{ $item->grid_span_class }}">
                    
                    @if($item->type === 'image')
                        <img src="{{ $item->image_path }}" alt="{{ $item->title ?: 'Gallery Photo' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-all duration-700 ease-out">
                    @else
                        <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/hqdefault.jpg" alt="{{ $item->title ?: 'Video Thumbnail' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-all duration-700 ease-out opacity-90">
                    @endif

                    <!-- Dark gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-950/30 to-black/20 group-hover:from-gray-950/95 group-hover:via-gray-950/45 transition-all duration-300"></div>

                    <!-- Top Bar Badges -->
                    <div class="absolute top-3 left-3 right-3 flex items-center justify-between z-10 pointer-events-none">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            @if($item->type === 'video')
                                <span class="bg-red-600/90 text-white text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs flex items-center gap-1 shadow-sm">
                                    <i class="fab fa-youtube"></i> Video
                                </span>
                            @else
                                <span class="bg-black/40 text-white/90 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs flex items-center gap-1 border border-white/20">
                                    <i class="fas fa-camera text-[8px]"></i> Foto
                                </span>
                            @endif

                            @if($isFeatured)
                                <span class="bg-purple-600/90 text-white text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs flex items-center gap-1 shadow-sm">
                                    <i class="fas fa-star text-[8px]"></i> Sorotan
                                </span>
                            @endif
                        </div>

                        <!-- Order badge -->
                        <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-white/20 text-white/90 backdrop-blur-xs border border-white/20">
                            #{{ $item->sort_order }}
                        </span>
                    </div>

                    <!-- Center Trigger Button -->
                    <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
                        @if($item->type === 'image')
                            <button onclick="openHomeLightbox('image', '{{ $item->image_path }}', '{{ addslashes($item->title) }}')" class="pointer-events-auto bg-white/90 hover:bg-white text-emerald-700 hover:text-emerald-800 w-11 h-11 rounded-full shadow-lg transition-all duration-300 transform scale-75 opacity-0 group-hover:opacity-100 group-hover:scale-100 flex items-center justify-center cursor-pointer" aria-label="Zoom image">
                                <i class="fas fa-magnifying-glass-plus text-base"></i>
                            </button>
                        @else
                            <button onclick="openHomeLightbox('video', '{{ $item->embed_url }}', '{{ addslashes($item->title) }}')" class="pointer-events-auto bg-red-600 hover:bg-red-700 text-white w-12 h-12 rounded-full shadow-xl transition-all duration-300 transform group-hover:scale-110 flex items-center justify-center cursor-pointer" aria-label="Play video">
                                <i class="fas fa-play text-sm ml-0.5"></i>
                            </button>
                        @endif
                    </div>

                    <!-- Bottom Caption -->
                    @if($item->title)
                        <div class="relative z-10 p-4 sm:p-5 pointer-events-auto">
                            <span class="text-[9px] font-black text-brand-orange uppercase tracking-wider block mb-1">
                                {{ db_trans('gallery_card_badge', 'Dokumentasi', 'Documentation') }}
                            </span>
                            <h4 class="font-bold text-white {{ $isFeatured ? 'text-sm sm:text-base' : 'text-xs sm:text-sm' }} line-clamp-2 leading-snug drop-shadow-sm group-hover:text-emerald-200 transition-colors">
                                {{ $item->title }}
                            </h4>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Lightbox Modal for Homepage -->
<div id="home-gallery-lightbox" class="fixed inset-0 z-50 bg-black/95 backdrop-blur-sm hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
    <button onclick="closeHomeLightbox()" class="absolute top-6 right-6 text-white hover:text-red-500 text-2xl transition p-2 focus:outline-none" aria-label="Close dialog">
        <i class="fas fa-xmark"></i>
    </button>
    
    <div class="max-w-4xl w-full flex flex-col items-center">
        <div class="w-full aspect-video bg-black/60 rounded-xl overflow-hidden border border-gray-800 shadow-2xl relative mb-4">
            <div id="home-lightbox-loader" class="absolute inset-0 flex items-center justify-center text-white">
                <i class="fas fa-circle-notch fa-spin text-3xl text-brand-green"></i>
            </div>
            
            <img id="home-lightbox-img" src="" class="w-full h-full object-contain hidden" alt="Lightbox View">
            <iframe id="home-lightbox-video" class="w-full h-full hidden" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <p id="home-lightbox-caption" class="text-white text-center font-bold text-xs max-w-xl"></p>
    </div>
</div>

<script>
    function openHomeLightbox(type, source, caption) {
        const lightbox = document.getElementById('home-gallery-lightbox');
        const img = document.getElementById('home-lightbox-img');
        const video = document.getElementById('home-lightbox-video');
        const captionText = document.getElementById('home-lightbox-caption');
        const loader = document.getElementById('home-lightbox-loader');

        img.classList.add('hidden');
        video.classList.add('hidden');
        loader.classList.remove('hidden');
        captionText.textContent = caption;

        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        setTimeout(() => {
            lightbox.classList.add('opacity-100');
        }, 10);

        if (type === 'image') {
            img.src = source;
            img.onload = function() {
                loader.classList.add('hidden');
                img.classList.remove('hidden');
            };
        } else if (type === 'video') {
            video.src = source + "?autoplay=1";
            loader.classList.add('hidden');
            video.classList.remove('hidden');
        }
    }

    function closeHomeLightbox() {
        const lightbox = document.getElementById('home-gallery-lightbox');
        const img = document.getElementById('home-lightbox-img');
        const video = document.getElementById('home-lightbox-video');

        lightbox.classList.remove('opacity-100');
        setTimeout(() => {
            lightbox.classList.remove('flex');
            lightbox.classList.add('hidden');
            img.src = "";
            video.src = "";
        }, 300);
    }

    document.getElementById('home-gallery-lightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeHomeLightbox();
        }
    });
</script>
@endif
