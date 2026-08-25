@extends('public.layout.app')

@section('title', $story->title . ' - Yayasan LINTASAN')
@section('meta_description', Str::limit(strip_tags($story->description), 150))
@section('og_image', asset($story->image_url))

@section('content')
<div class="bg-gray-50 py-12 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-xs text-gray-500 gap-2">
            <a href="/" class="hover:text-brand-green transition">{{ db_trans('breadcrumb_home', 'Beranda', 'Home') }}</a>
            <span>/</span>
            <a href="{{ route('public.stories.index') }}" class="hover:text-brand-green transition">{{ db_trans('breadcrumb_stories', 'Cerita Lapangan', 'Field Stories') }}</a>
            <span>/</span>
            <span class="text-gray-800 font-medium line-clamp-1">{{ $story->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Article Content -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8 flex flex-col justify-between">
                <div>
                    <!-- Category & Views Counter -->
                    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="{{ $story->category_bg ?? 'bg-green-100' }} {{ $story->category_color ?? 'text-brand-green' }} text-[10px] font-extrabold px-3 py-1 rounded uppercase">
                                {{ $story->category }}
                            </span>
                            @if($story->program)
                                <a href="{{ route('public.programs.show', $story->program->code) }}" class="bg-brand-green/10 text-brand-green border border-brand-green/20 hover:bg-brand-green hover:text-white text-[10px] font-extrabold px-3 py-1 rounded uppercase flex items-center gap-1 transition">
                                    <i class="fas fa-circle-nodes text-[9px]"></i> Program: {{ $story->program->title }}
                                </a>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400 font-bold flex items-center gap-1">
                            <i class="fas fa-eye text-xs"></i> <span>{{ number_format($story->views) }}</span> {{ db_trans('story_views', 'dilihat', 'views') }}
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-6 leading-tight">{{ $story->title }}</h1>
                    
                    <!-- Main Image -->
                    <div class="h-64 sm:h-[400px] w-full rounded-lg bg-gray-200 bg-cover bg-center mb-8 shadow-sm" style="background-image: url('{{ $story->image_url }}');"></div>

                    <!-- Article Body -->
                    <style>
                        .prose img {
                            max-width: 100% !important;
                            height: auto !important;
                            border-radius: 12px;
                            margin: 1.5rem auto;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
                        }
                    </style>
                    <div class="rich-text-content prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-base space-y-4 mb-8">
                        @if(strip_tags($story->content) == $story->content)
                            {!! nl2br(e($story->content)) !!}
                        @else
                            {!! $story->content !!}
                        @endif
                    </div>

                    <!-- Photo & Video Gallery Section -->
                    @if($story->gallery && count($story->gallery) > 0)
                        <div class="border-t border-gray-100 pt-8 mb-8">
                            <h3 class="text-sm font-extrabold text-gray-900 mb-4 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fas fa-images text-brand-green text-base"></i> {{ db_trans('story_gallery_title', 'Galeri & Dokumentasi', 'Gallery & Documentation') }}
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($story->gallery as $item)
                                    @php
                                        $type = is_array($item) ? ($item['type'] ?? 'image') : 'image';
                                        $path = is_array($item) ? ($item['path'] ?? '') : $item;
                                    @endphp
                                    @if($type === 'image')
                                        <a href="{{ $path }}" target="_blank" class="block aspect-video rounded-xl overflow-hidden border border-gray-150 shadow-sm hover:scale-[1.02] hover:shadow transition duration-200">
                                            <img src="{{ $path }}" alt="Gallery photo" class="w-full h-full object-cover">
                                        </a>
                                    @elseif($type === 'video')
                                        @php
                                            $embedUrl = is_array($item) ? ($item['embed_url'] ?? '') : '';
                                        @endphp
                                        <div class="aspect-video rounded-xl overflow-hidden border border-gray-150 shadow-sm relative bg-black">
                                            <iframe class="w-full h-full" src="{{ $embedUrl }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Sharing Widget -->
                    <div class="border-t border-gray-100 pt-6">
                        <span class="block text-gray-400 font-extrabold uppercase text-[10px] tracking-wider mb-3">
                            {{ db_trans('story_share_article', 'Bagikan Artikel Ini', 'Share this article') }}
                        </span>
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($story->title . ' - ' . url()->current()) }}" target="_blank" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-4 py-2 rounded-lg text-xs flex items-center gap-1.5 transition shadow-sm">
                                <i class="fab fa-whatsapp text-sm"></i> WhatsApp
                            </a>
                            <!-- Twitter / X -->
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($story->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="bg-gray-900 hover:bg-black text-white font-bold px-4 py-2 rounded-lg text-xs flex items-center gap-1.5 transition shadow-sm">
                                <i class="fab fa-x-twitter text-sm"></i> X (Twitter)
                            </a>
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg text-xs flex items-center gap-1.5 transition shadow-sm">
                                <i class="fab fa-facebook-f text-sm"></i> Facebook
                            </a>
                            <!-- Copy Link -->
                            <button onclick="copyArticleLink()" id="share-copy-btn" class="bg-white border border-gray-200 text-brand-green hover:border-brand-green font-bold px-4 py-2 rounded-lg text-xs flex items-center gap-1.5 transition shadow-sm">
                                <i class="fas fa-link text-sm"></i> <span>{{ db_trans('story_copy_link', 'Salin Tautan', 'Copy Link') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Back Button -->
                <div class="mt-12 border-t border-gray-100 pt-6">
                    <a href="{{ route('public.stories.index') }}" class="text-brand-green font-semibold text-sm flex items-center gap-2 hover:gap-3 transition">
                        <i class="fas fa-arrow-left"></i> {{ db_trans('story_back_to_list', 'Kembali ke Cerita Lapangan', 'Back to Field Stories') }}
                    </a>
                </div>
            </div>

            <!-- Right Side: Sidebar (Impact Metric & Other Stories) -->
            <div class="space-y-6">
                
                <!-- Optional Stats / Impact Card -->
                @if($story->impact_number)
                    <div class="bg-brand-darkgreen text-white rounded-xl shadow-sm border border-brand-green/20 p-6 relative overflow-hidden bg-cover bg-center" style="background-image: linear-gradient(rgba(0, 77, 46, 0.96), rgba(0, 77, 46, 0.92));">
                        <div class="relative z-10 text-center">
                            <span class="text-brand-yellow font-bold text-xs uppercase tracking-wider block mb-2">
                                {{ db_trans('story_impact_badge', 'Dampak Nyata', 'Real Impact') }}
                            </span>
                            <div class="text-5xl font-extrabold text-brand-yellow mb-2">{{ $story->impact_number }}</div>
                            <p class="text-sm text-gray-200 font-semibold mb-4 leading-snug">{{ session('locale') == 'en' ? ($story->impact_label_en ?: $story->impact_label_id) : $story->impact_label_id }}</p>
                            <div class="h-0.5 w-12 bg-brand-orange mx-auto rounded mb-4"></div>
                            <p class="text-[11px] text-gray-300 leading-relaxed">
                                {{ db_trans('story_impact_desc', 'Berkat kontribusi para mitra dan relawan, perubahan ini terwujud secara nyata berkelanjutan.', 'Thanks to the support from our partners and active volunteers, this positive change has become a reality.') }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Other Stories Widget -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 border-b border-gray-100 pb-2">
                        {{ db_trans('story_other_stories', 'Cerita Lainnya', 'Other Stories') }}
                    </h3>
                    <div class="space-y-4">
                        @forelse($otherStories as $other)
                            <a href="{{ route('public.stories.show', $other->slug) }}" class="flex gap-3 group">
                                <div class="w-16 h-16 rounded bg-gray-200 bg-cover bg-center shrink-0 shadow-sm" style="background-image: url('{{ $other->image_url }}');"></div>
                                <div>
                                    <span class="text-[9px] font-bold text-brand-green block mb-0.5 uppercase">{{ $other->category }}</span>
                                    <h4 class="font-bold text-xs text-gray-900 group-hover:text-brand-green transition line-clamp-2 leading-tight">{{ $other->title }}</h4>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-gray-500">
                                {{ db_trans('story_no_other_stories', 'Tidak ada cerita lain.', 'No other stories.') }}
                            </p>
                        @endforelse
                    </div>
                </div>

                <!-- Call to Action Widget -->
                <div class="bg-orange-50 rounded-xl shadow-sm border border-orange-100 p-6 text-center">
                    <h4 class="font-bold text-gray-900 text-sm mb-2">
                        {{ db_trans('story_sidebar_cta_title', 'Ingin Ikut Berkontribusi?', 'Want to Contribute?') }}
                    </h4>
                    <p class="text-gray-500 text-[11px] leading-relaxed mb-4">
                        {{ db_trans('story_sidebar_cta_desc', 'Bergabunglah menjadi relawan atau bermitra dengan kami untuk mendukung ketangguhan pesisir.', 'Join us as a volunteer or work with us as a partner to support coastal resilience.') }}
                    </p>
                    <a href="{{ route('public.volunteer.index') }}" class="inline-block w-full bg-brand-orange text-white text-xs font-bold py-2 rounded-lg hover:bg-brand-orange/90 transition shadow-sm">
                        {{ db_trans('story_sidebar_cta_btn', 'Bergabung Sekarang', 'Join Now') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyArticleLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            const btn = document.getElementById('share-copy-btn');
            const span = btn.querySelector('span');
            const icon = btn.querySelector('i');
            
            span.textContent = "{{ db_trans('story_link_copied', 'Tautan Tersalin!', 'Link Copied!') }}";
            icon.className = "fas fa-check text-emerald-500 text-sm";
            
            setTimeout(() => {
                span.textContent = "{{ db_trans('story_copy_link', 'Salin Tautan', 'Copy Link') }}";
                icon.className = "fas fa-link text-sm";
            }, 2000);
        });
    }
</script>
@endsection
