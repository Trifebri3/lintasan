@extends('public.layout.app')

@section('title', (session('locale') == 'en' ? 'About Us' : 'Tentang Kami') . ' - Yayasan LINTASAN')
@section('meta_description', session('locale') == 'en' ? 'Learn more about Yayasan LINTASAN, our vision, mission, and the team driving sustainable coastal development.' : 'Ketahui lebih lanjut mengenai profil, visi misi, sejarah, dan pengurus Yayasan LINTASAN.')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Title Banner -->
        <div class="text-center mb-12">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                {{ session('locale') == 'en' ? 'Organization Profile' : 'Profil Organisasi' }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                {{ session('locale') == 'en' ? 'About LINTASAN Foundation' : 'Tentang Yayasan LINTASAN' }}
            </h1>
            <div class="h-1 w-12 bg-brand-orange mx-auto rounded mb-6"></div>
            
            <p class="text-gray-600 text-sm max-w-2xl mx-auto leading-relaxed italic font-medium bg-white p-6 rounded-xl border border-gray-150 shadow-sm">
                "Yayasan LINTASAN {!! strip_tags($settings['about_profile'] ?? '', ['strong', 'em', 'span', 'b', 'i']) !!}"
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-10 space-y-10">
            <!-- Visi -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 border-b pb-1 flex items-center gap-2">
                    <i class="fas fa-eye text-brand-orange text-sm"></i> {{ session('locale') == 'en' ? 'Our Vision' : 'Visi Kami' }}
                </h3>
                <div class="text-sm text-gray-600 leading-relaxed font-semibold">
                    {!! $settings['about_visi'] ?? '' !!}
                </div>
            </div>

            <!-- Misi -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 border-b pb-1 flex items-center gap-2">
                    <i class="fas fa-bullseye text-brand-green text-sm"></i> {{ session('locale') == 'en' ? 'Our Mission' : 'Misi Kami' }}
                </h3>
                @php
                    $misiText = $settings['about_misi'] ?? '';
                    $hasHtml = strip_tags($misiText) !== $misiText;
                @endphp
                @if($hasHtml)
                    <div class="text-sm text-gray-600 leading-relaxed pl-5 list-disc-parent">
                        {!! $misiText !!}
                    </div>
                @else
                    @php
                        $misiLines = array_filter(explode("\n", $misiText));
                    @endphp
                    <ul class="list-disc pl-5 text-sm text-gray-600 space-y-2.5 leading-relaxed">
                        @foreach($misiLines as $line)
                            @if(trim($line))
                                <li>{{ trim($line) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Nilai Lintasan (Dinamis dari Database) -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-1 flex items-center gap-2">
                    <i class="fas fa-cubes text-blue-600 text-sm"></i> {{ session('locale') == 'en' ? 'LINTASAN Values' : 'Nilai Lintasan' }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-xs text-gray-500 leading-relaxed">
                    @forelse($organizationValues as $val)
                        <div class="p-5 {{ $val->bg_class ?? 'bg-emerald-50/50' }} border {{ $val->border_class ?? 'border-emerald-100/50' }} rounded-xl hover:-translate-y-0.5 transition duration-200">
                            <h4 class="font-extrabold {{ $val->color_class ?? 'text-emerald-700' }} text-sm mb-2 flex items-center gap-1.5">
                                <i class="fas {{ $val->icon ?: 'fa-award' }}"></i> {{ $val->title }}
                            </h4>
                            <div class="text-xs text-gray-600 leading-relaxed font-normal">
                                {!! $val->description !!}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-info-circle mb-1 text-sm"></i>
                            <p>{{ session('locale') == 'en' ? 'No values have been added yet.' : 'Belum ada nilai lintasan yang ditambahkan.' }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Conclusion Block -->
            <div class="bg-gray-50 border border-gray-150 rounded-xl p-6 text-xs text-gray-500 leading-relaxed">
                @php
                    $conclusionText = $settings['about_conclusion'] ?? '';
                @endphp
                @if(strip_tags($conclusionText) !== $conclusionText)
                    {!! $conclusionText !!}
                @else
                    {!! nl2br(e($conclusionText)) !!}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
