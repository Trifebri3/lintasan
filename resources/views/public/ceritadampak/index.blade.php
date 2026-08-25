@extends('public.layout.app')

@section('title', db_trans('meta_stories_title', 'Cerita Lapangan', 'Field Stories') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_stories_desc', 'Jelajahi kumpulan kisah dampak nyata dan perjuangan pemberdayaan masyarakat di daerah pesisir dampingan Yayasan LINTASAN.', 'Explore real impact stories and positive updates directly from coastal communities assisted by Yayasan LINTASAN.'))

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                {{ db_trans('stories_badge', 'Kumpulan Kisah', 'Story Collection') }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                {{ db_trans('stories_title', 'Cerita dari Lapangan', 'Stories from the Field') }}
            </h1>
            <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
            <p class="text-gray-500 text-sm max-w-xl mx-auto mt-4 leading-relaxed">
                {{ db_trans('stories_desc', 'Melihat dari dekat dampak perubahan nyata dan perjuangan ketangguhan masyarakat di daerah dampingan pesisir.', 'Looking closely at the impact of real change and the struggle of community resilience in coastal assisted areas.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($stories as $story)
                <!-- Story Card -->
                <a href="{{ route('public.stories.show', $story->slug) }}" class="bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 flex flex-col justify-between group block">
                    <div>
                        <div class="h-48 bg-gray-200 bg-cover bg-center" style="background-image: url('{{ $story->image_url }}');"></div>
                        <div class="p-6">
                            <span class="{{ $story->category_bg ?? 'bg-green-100' }} {{ $story->category_color ?? 'text-brand-green' }} text-[10px] font-extrabold px-2.5 py-1 rounded uppercase">
                                {{ $story->category }}
                            </span>
                            <h3 class="font-bold text-lg text-gray-900 mt-4 mb-2 line-clamp-2 leading-tight">{{ $story->title }}</h3>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-3 leading-relaxed">{{ strip_tags($story->description) }}</p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <span class="text-brand-green font-semibold text-xs flex items-center gap-1 group-hover:gap-2 transition">
                            {{ db_trans('stories_read_story', 'Baca Cerita', 'Read Story') }} <i class="fas fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-400 py-12">
                    {{ db_trans('stories_empty', 'Belum ada cerita yang diunggah.', 'No stories uploaded yet.') }}
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
