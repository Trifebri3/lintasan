@if(count($galleryItems) > 0)
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

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($galleryItems as $item)
                <div class="group relative rounded-xl overflow-hidden border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all duration-300 transform">
                    
                    @if($item->type === 'image')
                        <!-- Image item -->
                        <div class="aspect-video w-full bg-gray-100 overflow-hidden relative">
                            <img src="{{ $item->image_path }}" alt="Gallery Image" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500">
                            
                            <!-- Lightbox trigger overlay -->
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                <button onclick="openHomeLightbox('image', '{{ $item->image_path }}', '{{ $item->title }}')" class="bg-white/95 text-brand-green hover:bg-brand-green hover:text-white p-3 rounded-full shadow transition transform scale-95 group-hover:scale-100 duration-300" aria-label="Zoom image">
                                    <i class="fas fa-magnifying-glass-plus text-base"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Video item -->
                        <div class="aspect-video w-full bg-black overflow-hidden relative">
                            <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/mqdefault.jpg" alt="Video Thumbnail" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500 opacity-85">
                            
                            <!-- YouTube play trigger overlay -->
                            <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition duration-300">
                                <button onclick="openHomeLightbox('video', '{{ $item->embed_url }}', '{{ $item->title }}')" class="bg-red-600 hover:bg-red-700 text-white p-3.5 rounded-full shadow-lg transition transform hover:scale-110 duration-300 flex items-center justify-center cursor-pointer" aria-label="Play video">
                                    <i class="fas fa-play text-sm ml-0.5"></i>
                                </button>
                            </div>
                            
                            <span class="absolute top-2 left-2 bg-red-600 text-white text-[9px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider flex items-center gap-1 shadow-sm">
                                <i class="fab fa-youtube"></i> Video
                            </span>
                        </div>
                    @endif

                    @if($item->title)
                        <!-- Caption -->
                        <div class="p-4 border-t border-gray-50">
                            <h4 class="font-bold text-xs text-gray-800 line-clamp-1">{{ $item->title }}</h4>
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
