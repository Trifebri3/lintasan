@extends('public.layout.app')

@section('title', db_trans('meta_gallery_title', 'Galeri Kegiatan', 'Activity Gallery') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_gallery_desc', 'Dokumentasi foto dan galeri aksi nyata program pemberdayaan pesisir Yayasan LINTASAN.', 'Photos and documentation of Yayasan LINTASAN coastal empowerment activities.'))

@section('content')
<div class="bg-gray-50 py-16 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Header -->
        <div class="mb-12">
            <nav class="flex mb-4 text-xs text-gray-500 gap-2">
                <a href="/" class="hover:text-brand-green transition">{{ db_trans('breadcrumb_home', 'Beranda', 'Home') }}</a>
                <span>/</span>
                <span class="text-gray-800 font-medium">{{ db_trans('breadcrumb_gallery', 'Galeri', 'Gallery') }}</span>
            </nav>
            
            <div class="text-center md:text-left">
                <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                    {{ db_trans('gallery_badge', 'Galeri Dokumentasi', 'Documentation Gallery') }}
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">
                    {{ db_trans('gallery_title', 'Galeri Aktifitas Kami', 'Our Activity Gallery') }}
                </h1>
                <p class="text-gray-500 text-sm max-w-xl mt-3 leading-relaxed">
                    {{ db_trans('gallery_desc', 'Dokumentasi visual perubahan nyata dan inisiatif ketangguhan pesisir di seluruh daerah dampingan kami.', 'Visual documentation of positive changes and coastal resilience initiatives in our assisted areas.') }}
                </p>
            </div>
        </div>

        <!-- Filter Controls -->
        <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-8 border-b border-gray-150 pb-4">
            <button onclick="filterGallery('all')" id="filter-all" class="px-4 py-2 rounded-lg text-xs font-bold bg-brand-green text-white shadow-sm transition">
                {{ db_trans('gallery_filter_all', 'Semua', 'All') }}
            </button>
            <button onclick="filterGallery('image')" id="filter-image" class="px-4 py-2 rounded-lg text-xs font-bold bg-white border border-gray-200 text-gray-700 hover:border-brand-green hover:text-brand-green transition">
                <i class="fas fa-camera mr-1"></i> {{ db_trans('gallery_filter_photos', 'Foto', 'Photos') }}
            </button>
            <button onclick="filterGallery('video')" id="filter-video" class="px-4 py-2 rounded-lg text-xs font-bold bg-white border border-gray-200 text-gray-700 hover:border-brand-green hover:text-brand-green transition">
                <i class="fab fa-youtube mr-1 text-red-500"></i> {{ db_trans('gallery_filter_videos', 'Video', 'Videos') }}
            </button>
        </div>

        <!-- Bento Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 auto-rows-[220px] md:auto-rows-[240px]" id="gallery-grid">
            @forelse($galleryItems as $item)
                @php
                    $isFeatured = $item->layout_size === 'featured';
                    $isWide = $item->layout_size === 'wide';
                    $isTall = $item->layout_size === 'tall';
                @endphp
                <div class="gallery-item group relative rounded-2xl overflow-hidden border border-gray-200/80 bg-gray-900 shadow-sm hover:shadow-xl transition-all duration-300 transform flex flex-col justify-end {{ $item->grid_span_class }}" data-type="{{ $item->type }}">
                    
                    @if($item->type === 'image')
                        <!-- Image Element (Fills full Bento card) -->
                        <img src="{{ $item->image_path }}" alt="{{ $item->title ?: 'Gallery Photo' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-all duration-700 ease-out">
                    @else
                        <!-- Video Thumbnail -->
                        <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/hqdefault.jpg" alt="{{ $item->title ?: 'Video Thumbnail' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-all duration-700 ease-out opacity-90">
                    @endif

                    <!-- Subtle dark gradient overlay -->
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
                                <span class="bg-purple-600/90 text-white text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs flex items-center gap-1 shadow-sm">
                                    <i class="fas fa-star text-[8px]"></i> Sorotan
                                </span>
                            @elseif($isWide)
                                <span class="bg-blue-600/80 text-white text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs flex items-center gap-1">
                                    <i class="fas fa-panorama text-[8px]"></i> Panorama
                                </span>
                            @elseif($isTall)
                                <span class="bg-amber-600/80 text-white text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs flex items-center gap-1">
                                    <i class="fas fa-arrows-up-down text-[8px]"></i> Potret
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
                            <button onclick="openLightbox('image', '{{ $item->image_path }}', '{{ addslashes($item->title) }}')" class="pointer-events-auto bg-white/90 hover:bg-white text-emerald-700 hover:text-emerald-800 w-11 h-11 rounded-full shadow-lg transition-all duration-300 transform scale-75 opacity-0 group-hover:opacity-100 group-hover:scale-100 flex items-center justify-center cursor-pointer" aria-label="Lihat Foto Lebih Besar">
                                <i class="fas fa-magnifying-glass-plus text-base"></i>
                            </button>
                        @else
                            <button onclick="openLightbox('video', '{{ $item->embed_url }}', '{{ addslashes($item->title) }}')" class="pointer-events-auto bg-red-600 hover:bg-red-700 text-white w-12 h-12 rounded-full shadow-xl transition-all duration-300 transform group-hover:scale-110 flex items-center justify-center cursor-pointer" aria-label="Putar Video">
                                <i class="fas fa-play text-sm ml-0.5"></i>
                            </button>
                        @endif
                    </div>

                    <!-- Bottom Caption -->
                    <div class="relative z-10 p-4 sm:p-5 pointer-events-auto">
                        <span class="text-[9px] font-black text-brand-orange uppercase tracking-wider block mb-1">
                            {{ db_trans('gallery_card_badge', 'Dokumentasi Yayasan LINTASAN', 'Yayasan LINTASAN Documentation') }}
                        </span>
                        <h3 class="font-extrabold text-white {{ $isFeatured ? 'text-sm sm:text-base' : 'text-xs sm:text-sm' }} line-clamp-2 leading-snug drop-shadow-sm group-hover:text-emerald-200 transition-colors">
                            {{ $item->title ?: (session('locale') == 'en' ? 'Coastal Resilience Activity' : 'Aksi Dokumentasi Pesisir') }}
                        </h3>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200 shadow-sm">
                    <div class="text-gray-300 text-5xl mb-4"><i class="fas fa-images"></i></div>
                    <p class="text-gray-500 text-sm font-semibold">
                        {{ db_trans('gallery_empty_message', 'Belum ada dokumentasi galeri yang tersedia.', 'No gallery documentation available yet.') }}
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Premium Lightbox Modal -->
<div id="gallery-lightbox" class="fixed inset-0 z-50 bg-black/95 backdrop-blur-sm hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
    <!-- Close button -->
    <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white hover:text-red-500 text-2xl transition p-2 focus:outline-none" aria-label="Close dialog">
        <i class="fas fa-xmark"></i>
    </button>
    
    <div class="max-w-4xl w-full flex flex-col items-center">
        <!-- Content Container -->
        <div class="w-full aspect-video bg-black/60 rounded-xl overflow-hidden border border-gray-800 shadow-2xl relative mb-4">
            <!-- Loading indicator -->
            <div id="lightbox-loader" class="absolute inset-0 flex items-center justify-center text-white">
                <i class="fas fa-circle-notch fa-spin text-3xl text-brand-green"></i>
            </div>
            
            <img id="lightbox-img" src="" class="w-full h-full object-contain hidden" alt="Lightbox View">
            <iframe id="lightbox-video" class="w-full h-full hidden" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        
        <!-- Title caption -->
        <p id="lightbox-caption" class="text-white text-center font-bold text-xs max-w-xl"></p>
    </div>
</div>

<script>
    // Filtering logic
    function filterGallery(type) {
        // Update button states
        const filters = ['all', 'image', 'video'];
        filters.forEach(f => {
            const btn = document.getElementById('filter-' + f);
            if (f === type) {
                btn.className = "px-4 py-2 rounded-lg text-xs font-bold bg-brand-green text-white shadow-sm transition";
            } else {
                btn.className = "px-4 py-2 rounded-lg text-xs font-bold bg-white border border-gray-200 text-gray-700 hover:border-brand-green hover:text-brand-green transition";
            }
        });

        // Toggle visibility
        const items = document.querySelectorAll('.gallery-item');
        items.forEach(item => {
            const itemType = item.getAttribute('data-type');
            if (type === 'all' || itemType === type) {
                item.style.display = 'block';
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                }, 10);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 200);
            }
        });
    }

    // Lightbox handlers
    function openLightbox(type, source, caption) {
        const lightbox = document.getElementById('gallery-lightbox');
        const img = document.getElementById('lightbox-img');
        const video = document.getElementById('lightbox-video');
        const captionText = document.getElementById('lightbox-caption');
        const loader = document.getElementById('lightbox-loader');

        // Reset
        img.classList.add('hidden');
        video.classList.add('hidden');
        loader.classList.remove('hidden');
        captionText.textContent = caption;

        // Open modal
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

    function closeLightbox() {
        const lightbox = document.getElementById('gallery-lightbox');
        const img = document.getElementById('lightbox-img');
        const video = document.getElementById('lightbox-video');

        lightbox.classList.remove('opacity-100');
        setTimeout(() => {
            lightbox.classList.remove('flex');
            lightbox.classList.add('hidden');
            // Reset sources to stop playback/load
            img.src = "";
            video.src = "";
        }, 300);
    }

    // Close on clicking outside container
    document.getElementById('gallery-lightbox').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
</script>
@endsection
