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
                    {{ db_trans('gallery_title', 'Galeri Aktivitas Dampak', 'Our Impact Activities') }}
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

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="gallery-grid">
            @forelse($galleryItems as $item)
                <div class="gallery-item group relative rounded-xl overflow-hidden border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all duration-300 transform" data-type="{{ $item->type }}">
                    
                    @if($item->type === 'image')
                        <!-- Image Layout -->
                        <div class="aspect-video w-full bg-gray-100 overflow-hidden relative">
                            <img src="{{ $item->image_path }}" alt="Gallery Image" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500">
                            
                            <!-- Overlay on hover -->
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                <button onclick="openLightbox('image', '{{ $item->image_path }}', '{{ $item->title }}')" class="bg-white/95 text-brand-green hover:bg-brand-green hover:text-white p-3 rounded-full shadow transition-all transform scale-95 group-hover:scale-100 duration-300" aria-label="Zoom image">
                                    <i class="fas fa-magnifying-glass-plus text-base"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Video Layout -->
                        <div class="aspect-video w-full bg-black overflow-hidden relative">
                            <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/mqdefault.jpg" alt="Video Thumbnail" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500 opacity-85">
                            
                            <!-- Red YouTube Play Button Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition duration-300">
                                <button onclick="openLightbox('video', '{{ $item->embed_url }}', '{{ $item->title }}')" class="bg-red-600 hover:bg-red-700 text-white p-3.5 rounded-full shadow-lg transition-all transform hover:scale-110 duration-300 flex items-center justify-center cursor-pointer" aria-label="Play video">
                                    <i class="fas fa-play text-sm ml-0.5"></i>
                                </button>
                            </div>
                            
                            <!-- Video label badge -->
                            <span class="absolute top-2 left-2 bg-red-600 text-white text-[9px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider flex items-center gap-1 shadow-sm">
                                <i class="fab fa-youtube"></i> Video
                            </span>
                        </div>
                    @endif

                    @if($item->title)
                        <!-- Card Footer Caption -->
                        <div class="p-4 border-t border-gray-50">
                            <span class="text-[9px] font-extrabold text-brand-green uppercase tracking-wider mb-1 block">
                                {{ db_trans('gallery_card_badge', 'Dokumentasi', 'Documentation') }}
                            </span>
                            <h4 class="font-bold text-xs text-gray-800 line-clamp-2">{{ $item->title }}</h4>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-xl border border-gray-100 shadow-sm">
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
