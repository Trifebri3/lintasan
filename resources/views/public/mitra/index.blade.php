@extends('public.layout.app')

@section('title', db_trans('meta_mitra_title', 'Mitra Kerja Sama', 'Our Collaboration Partners') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_mitra_desc', 'Daftar lembaga, korporasi, dan organisasi mitra kolaborasi dalam mendukung program Yayasan LINTASAN.', 'Collaborative partners supporting Yayasan LINTASAN coastal empowerment programs.'))

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                {{ db_trans('mitra_badge', 'Bergerak Bersama', 'Collaborate Together') }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                {{ db_trans('mitra_title', 'Mitra Kolaborasi LINTASAN', 'LINTASAN Collaboration Partners') }}
            </h1>
            <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
            <p class="text-gray-500 text-sm max-w-xl mx-auto mt-4 leading-relaxed font-medium">
                {{ db_trans('mitra_desc', 'Menghubungkan lembaga pemerintah, sektor swasta, sekolah, dan organisasi masyarakat sipil untuk bersinergi mewujudkan ketangguhan bangsa.', 'Connecting government agencies, private sectors, schools, and civil society organizations to synergize in building national resilience.') }}
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @forelse($partners as $partner)
                @if($partner->logo_path)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition">
                        <div class="w-16 h-16 rounded bg-gray-50 flex items-center justify-center border border-gray-100 p-2 mb-4 shadow-sm">
                            <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm leading-snug">{{ $partner->name }}</h3>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase font-semibold tracking-wider">
                            {{ db_trans('mitra_official_label', 'Mitra Resmi', 'Official Partner') }}
                        </p>
                    </div>
                @endif
            @empty
                <div class="col-span-full text-center text-gray-500 py-12">
                    {{ db_trans('mitra_empty', 'Belum ada mitra kolaborasi yang terdaftar.', 'No partners registered.') }}
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
