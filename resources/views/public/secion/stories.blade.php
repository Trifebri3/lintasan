<section id="stories" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">
                    {{ db_trans('home_stories_title', 'Cerita dari Lapangan', 'Stories from the Field') }}
                </h2>
            </div>
            <!-- Slider Controls -->
            <div class="flex items-center space-x-2">
                <button aria-label="Previous slide" class="w-10 h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-500 hover:border-brand-green hover:text-brand-green shadow-sm transition">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
                <button aria-label="Next slide" class="w-10 h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-500 hover:border-brand-green hover:text-brand-green shadow-sm transition">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @forelse($stories as $story)
                <!-- Story Card -->
                <a href="{{ route('public.stories.show', $story->slug) }}" class="bg-white rounded-xl overflow-hidden border border-gray-150 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition duration-300 flex flex-col justify-between group block">
                    <div>
                        @php
                            $storyColorMap = [
                                'SPAB' => 'from-[#ff5858] to-[#f857a6]',
                                'Tabur Laut' => 'from-[#00c6ff] to-[#0072ff]',
                                'SMK' => 'from-[#ff9966] to-[#ff5e62]',
                                'Hutan' => 'from-[#11998e] to-[#38ef7d]',
                            ];
                            $badgeAccent = 'from-[#11998e] to-[#38ef7d]';
                            foreach ($storyColorMap as $key => $grad) {
                                if (str_contains($story->category, $key)) {
                                    $badgeAccent = $grad;
                                    break;
                                }
                            }
                        @endphp
                        <div class="h-[3px] w-full bg-gradient-to-r {{ $badgeAccent }}"></div>
                        
                        <div class="h-44 bg-cover bg-center" style="background-image: url('{{ $story->image_url }}');"></div>
                        <div class="p-4">
                            <span class="inline-block bg-gradient-to-r {{ $badgeAccent }} text-white text-[9px] font-bold px-2.5 py-1 rounded uppercase tracking-wider shadow-sm">
                                {{ $story->category }}
                            </span>
                            <h3 class="font-bold text-base text-gray-900 mt-3 mb-2 line-clamp-2 leading-tight">{{ $story->title }}</h3>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-3 leading-relaxed">{{ strip_tags($story->description) }}</p>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        <span class="text-brand-green font-semibold text-xs flex items-center gap-1 group-hover:gap-2 transition">
                            {{ db_trans('home_stories_read_story', 'Baca Cerita', 'Read Story') }} <i class="fas fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </a>
            @empty
                <!-- Fallback Story Cards -->
                <div class="col-span-full text-center text-gray-500 text-sm py-8">
                    {{ db_trans('home_stories_empty', 'Belum ada cerita dari lapangan.', 'No stories from the field yet.') }}
                </div>
            @endforelse
        </div>
    </div>
</section>
