@extends('public.layout.app')

@section('title', db_trans('meta_villages_title', 'Desa Mitra Lintasan Kami', 'Our Partner Villages') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_villages_desc', 'Lihat daftar desa dan wilayah pesisir binaan pendampingan program ketangguhan kebencanaan dan kemandirian ekonomi Yayasan LINTASAN.', 'Explore the coastal assisted villages accompanied and empowered by Yayasan LINTASAN.'))

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                {{ db_trans('villages_badge', 'Daerah Dampingan', 'Our Assisted Communities') }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                {{ db_trans('villages_title', 'Desa Mitra Lintasan LINTASAN', 'LINTASAN Partner Villages') }}
            </h1>
            <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
            <p class="text-gray-500 text-sm max-w-xl mx-auto mt-4 leading-relaxed">
                {{ db_trans('villages_desc', 'Pemberdayaan terstruktur yang tersebar di 15+ desa pesisir guna membangun komunitas tangguh, mandiri, dan siap siaga bencana.', 'Structured empowerment across 15+ coastal villages to build resilient, independent, and disaster-prepared communities.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($villages as $village)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:-translate-y-1 transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="h-48 bg-gray-200 bg-cover bg-center" style="background-image: url('{{ $village->image_path }}');"></div>
                        <div class="p-6">
                            <div class="flex items-center gap-1.5 text-xs text-brand-orange font-bold mb-2">
                                <i class="fas fa-location-dot"></i>
                                <span>{{ $village->location }}</span>
                            </div>
                            <h3 class="font-extrabold text-lg text-gray-900 mb-2 leading-tight">{{ $village->name }}</h3>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed line-clamp-3">{{ $village->description }}</p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('public.pages.village.show', $village->slug) }}" class="text-brand-green font-semibold text-xs flex items-center gap-1 hover:gap-2 transition">
                            {{ db_trans('villages_view_profile', 'Lihat Profil Desa', 'View Profile') }} <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-12">
                    Belum ada data desa mitra lintasan yang diunggah.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
