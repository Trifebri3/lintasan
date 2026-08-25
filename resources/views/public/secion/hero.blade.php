<style>
    /* Elegant zoom effect (Ken Burns) */
    .hero-slide {
        transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hero-slide-bg {
        transition: transform 6.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform: scale(1.03);
    }
    
    .hero-slide.active .hero-slide-bg {
        transform: scale(1.1);
    }

    /* Staggered text animations */
    .hero-animate {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.8s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .hero-slide.active .hero-animate {
        opacity: 1;
        transform: translateY(0);
    }

    .delay-100 { transition-delay: 150ms; }
    .delay-200 { transition-delay: 300ms; }
    .delay-300 { transition-delay: 450ms; }
    .delay-400 { transition-delay: 600ms; }
</style>

<div id="hero-slider-container" class="relative w-full min-h-[600px] overflow-hidden bg-[#0f172a] flex items-center">
    
    <!-- Slides -->
    @foreach($heroImages as $index => $slide)
        <div class="hero-slide absolute inset-0 {{ $index === 0 ? 'active opacity-100 z-10' : 'opacity-0 z-0' }}">
            <!-- Background Image with Zoom animation -->
            <div class="hero-slide-bg absolute inset-0" style="background-image: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.45)), url('{{ $slide->image_path }}'); background-size: cover; background-position: center;"></div>
            
            <!-- Content -->
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 h-full flex items-center w-full z-10">
                <div class="hero-content-wrapper max-w-2xl text-white hidden md:block">
                    <h1 class="hero-animate delay-200 text-4xl sm:text-5xl font-extrabold leading-tight mb-4">
                        {{ session('locale') == 'en' ? $slide->title_en : $slide->title_id }}
                    </h1>
                    <div class="hero-animate delay-300 text-gray-200 text-base mb-8 leading-relaxed">
                        {!! session('locale') == 'en' ? $slide->subtitle_en : $slide->subtitle_id !!}
                    </div>
                    <div class="hero-animate delay-400 flex flex-wrap gap-4">
                        <a href="{{ route('public.programs.index') }}" class="bg-brand-green text-white px-6 py-3.5 rounded-md font-semibold flex items-center gap-2 hover:bg-brand-darkgreen shadow-md transition">
                            {{ session('locale') == 'en' ? 'Explore Programs' : 'Jelajahi Program' }} <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ $slide->button_link ?: route('public.stories.index') }}" class="border border-white/80 text-white px-6 py-3.5 rounded-md font-semibold flex items-center gap-2 hover:bg-white/10 transition">
                            <i class="fas fa-play-circle text-lg"></i> {{ session('locale') == 'en' ? 'View Impact' : 'Lihat Dampak' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
    <!-- Navigation Dots -->
    <div class="absolute bottom-16 sm:bottom-12 left-1/2 -translate-x-1/2 z-30 hidden md:flex space-x-2">
        @foreach($heroImages as $index => $slide)
            <button onclick="goToSlide({{ $index }})" class="hero-dot w-3 h-3 rounded-full {{ $index === 0 ? 'bg-brand-yellow' : 'bg-white/50' }} transition focus:outline-none" aria-label="Go to slide {{ $index + 1 }}"></button>
        @endforeach
    </div>

    <!-- MOBILE VIEW (Slide Content Card - Absolute inside slider) -->
    <div id="mobile-stats-view" class="absolute bottom-4 left-4 right-4 z-30 bg-white/45 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-4 sm:p-5 text-gray-800 md:hidden block transition-all duration-300">
        @foreach($heroImages as $slideIndex => $slide)
            <div class="mobile-slide-content {{ $slideIndex === 0 ? 'block' : 'hidden' }}" id="mobile-slide-content-{{ $slideIndex }}">
                <h3 class="text-sm min-[380px]:text-base min-[400px]:text-lg font-black text-slate-950 leading-snug mb-1 min-[380px]:mb-1.5">
                    {{ session('locale') == 'en' ? $slide->title_en : $slide->title_id }}
                </h3>
                <div class="text-[10px] min-[380px]:text-xs text-slate-900 font-semibold mb-2.5 min-[380px]:mb-3.5 leading-relaxed">
                    {!! session('locale') == 'en' ? $slide->subtitle_en : $slide->subtitle_id !!}
                </div>
                <div class="flex flex-wrap gap-2 min-[380px]:gap-2.5">
                    <a href="{{ route('public.programs.index') }}" class="bg-brand-green text-white text-[10px] min-[380px]:text-xs font-bold py-2 min-[380px]:py-2.5 px-3 min-[380px]:px-4 rounded-lg shadow-sm hover:bg-brand-darkgreen transition inline-block">
                        {{ session('locale') == 'en' ? 'Explore Programs' : 'Jelajahi Program' }}
                    </a>
                    <a href="{{ $slide->button_link ?: route('public.stories.index') }}" class="border border-slate-350 text-slate-700 text-[10px] min-[380px]:text-xs font-bold py-2 min-[380px]:py-2.5 px-3 min-[380px]:px-4 rounded-lg hover:bg-slate-50 transition inline-block">
                        <i class="fas fa-play-circle text-[9px] min-[380px]:text-[10px] text-slate-500 mr-0.5 min-[380px]:mr-1"></i> {{ session('locale') == 'en' ? 'View Impact' : 'Lihat Dampak' }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    
    function showSlide(index) {
        if (!slides.length) return;
        slides.forEach((slide, i) => {
            const mobileContent = document.getElementById(`mobile-slide-content-${i}`);
            if (i === index) {
                slide.classList.remove('opacity-0', 'z-0');
                slide.classList.add('opacity-100', 'z-10', 'active');
                dots[i].classList.remove('bg-white/50');
                dots[i].classList.add('bg-brand-yellow');
                if (mobileContent) {
                    mobileContent.classList.remove('hidden');
                    mobileContent.classList.add('block');
                }
            } else {
                slide.classList.remove('opacity-100', 'z-10', 'active');
                slide.classList.add('opacity-0', 'z-0');
                dots[i].classList.remove('bg-brand-yellow');
                dots[i].classList.add('bg-white/50');
                if (mobileContent) {
                    mobileContent.classList.remove('block');
                    mobileContent.classList.add('hidden');
                }
            }
        });
        currentSlide = index;
    }
    
    function nextSlide() {
        if (!slides.length) return;
        let next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }
    
    function goToSlide(index) {
        showSlide(index);
        resetInterval();
    }
    
    let slideInterval = setInterval(nextSlide, 5000);
    
    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
    }

    // Number count up intersection observer for hero floating stats
    document.addEventListener('DOMContentLoaded', () => {
        const heroCounters = document.querySelectorAll('.stat-counter');
        const countUp = (target) => {
            const endVal = parseFloat(target.getAttribute('data-count'));
            const suffix = target.getAttribute('data-suffix') || '';
            const formatLoc = target.getAttribute('data-format') === 'true';
            const duration = 2000;
            const startTime = performance.now();

            const updateCount = (currentTime) => {
                const elapsedTime = currentTime - startTime;
                if (elapsedTime >= duration) {
                    target.textContent = (formatLoc ? endVal.toLocaleString('id-ID') : endVal) + suffix;
                } else {
                    const progress = elapsedTime / duration;
                    const easeProgress = progress * (2 - progress); // Ease out
                    const currentVal = Math.floor(easeProgress * endVal);
                    target.textContent = (formatLoc ? currentVal.toLocaleString('id-ID') : currentVal) + suffix;
                    requestAnimationFrame(updateCount);
                }
            };
            requestAnimationFrame(updateCount);
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    countUp(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        heroCounters.forEach(counter => counterObserver.observe(counter));
    });
</script>

