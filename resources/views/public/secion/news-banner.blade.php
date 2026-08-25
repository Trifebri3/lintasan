<style>
    /* Premium Ken Burns for News Banner */
    .news-slide {
        transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .news-slide-bg {
        transition: transform 6.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform: scale(1.02);
    }
    
    .news-slide.active .news-slide-bg {
        transform: scale(1.08);
    }

    /* Staggered text animations for News Banner */
    .news-animate {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.8s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .news-slide.active .news-animate {
        opacity: 1;
        transform: translateY(0);
    }

    .news-delay-100 { transition-delay: 150ms; }
    .news-delay-200 { transition-delay: 300ms; }
    .news-delay-300 { transition-delay: 450ms; }
</style>

<section id="news-banner-section" class="py-12 bg-white">
    <!-- Full-width edge-to-edge container -->
    <div class="relative w-full min-h-[550px] overflow-hidden bg-[#0f172a] group flex items-center">
        
        <!-- Slides -->
        @foreach($latestStories as $index => $story)
            <div class="news-slide absolute inset-0 {{ $index === 0 ? 'active opacity-100 z-10' : 'opacity-0 z-0' }}">
                <!-- Zooming Background -->
                <div class="news-slide-bg absolute inset-0" style="background-image: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.55)), url('{{ $story->image_url }}'); background-size: cover; background-position: center;"></div>
                
                <!-- Content Overlay aligned with max-w-7xl -->
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 h-full flex items-center w-full z-10">
                    <div class="max-w-3xl text-white">
                        <!-- Category/Type Tag -->
                        <span class="news-animate news-delay-100 inline-block bg-white/15 text-white border border-white/25 px-3 py-1 rounded-full text-[10px] uppercase font-bold tracking-widest mb-3.5">
                            {{ strtoupper($story->category) }}
                        </span>
                        
                        <!-- Article Title -->
                        <h2 class="news-animate news-delay-200 text-3xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                            {{ $story->title }}
                        </h2>
                        
                        <!-- Read More Button -->
                        <div class="news-animate news-delay-300">
                            <a href="{{ route('public.stories.show', $story->slug) }}" class="inline-block bg-[#007A48] hover:bg-[#004D2E] text-white text-[11px] font-bold px-6 py-4 rounded uppercase tracking-wider transition shadow-md">
                                {{ db_trans('news_banner_read_more', 'BACA SELENGKAPNYA', 'READ MORE') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Navigation Arrows -->
        <button onclick="prevNewsSlide()" class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-[#0f172a]/35 hover:bg-[#0f172a]/55 border border-white/10 text-white flex items-center justify-center transition z-30 focus:outline-none opacity-0 group-hover:opacity-100" aria-label="Previous Slide">
            <i class="fas fa-chevron-left text-sm"></i>
        </button>
        <button onclick="nextNewsSlide()" class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-[#0f172a]/35 hover:bg-[#0f172a]/55 border border-white/10 text-white flex items-center justify-center transition z-30 focus:outline-none opacity-0 group-hover:opacity-100" aria-label="Next Slide">
            <i class="fas fa-chevron-right text-sm"></i>
        </button>

        <!-- Navigation Dots -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex space-x-2">
            @foreach($latestStories as $index => $story)
                <button onclick="goToNewsSlide({{ $index }})" class="news-dot w-2.5 h-2.5 rounded-full {{ $index === 0 ? 'bg-[#FFB800]' : 'bg-white/40' }} transition focus:outline-none" aria-label="Go to slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

    </div>
</section>

<script>
    let currentNewsSlide = 0;
    const newsSlides = document.querySelectorAll('.news-slide');
    const newsDots = document.querySelectorAll('.news-dot');
    
    function showNewsSlide(index) {
        if (!newsSlides.length) return;
        newsSlides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('opacity-0', 'z-0');
                slide.classList.add('opacity-100', 'z-10', 'active');
                if (newsDots[i]) {
                    newsDots[i].classList.remove('bg-white/40');
                    newsDots[i].classList.add('bg-[#FFB800]');
                }
            } else {
                slide.classList.remove('opacity-100', 'z-10', 'active');
                slide.classList.add('opacity-0', 'z-0');
                if (newsDots[i]) {
                    newsDots[i].classList.remove('bg-[#FFB800]');
                    newsDots[i].classList.add('bg-white/40');
                }
            }
        });
        currentNewsSlide = index;
    }
    
    function nextNewsSlide() {
        if (!newsSlides.length) return;
        let next = (currentNewsSlide + 1) % newsSlides.length;
        showNewsSlide(next);
    }
    
    function prevNewsSlide() {
        if (!newsSlides.length) return;
        let prev = (currentNewsSlide - 1 + newsSlides.length) % newsSlides.length;
        showNewsSlide(prev);
    }
    
    function goToNewsSlide(index) {
        showNewsSlide(index);
        resetNewsInterval();
    }
    
    let newsSlideInterval = setInterval(nextNewsSlide, 6000);
    
    function resetNewsInterval() {
        clearInterval(newsSlideInterval);
        newsSlideInterval = setInterval(nextNewsSlide, 6000);
    }
</script>
