@extends('public.layout.app')

@section('title', (str_contains($program->title, 'SPAB') ? db_trans('program_spab_title', 'SPAB (Sekolah Aman Bencana)', 'Disaster Preparedness School (SPAB)') : (str_contains($program->title, 'Tabur Laut') ? db_trans('program_tabur_title', 'Tabur Laut', 'Tabur Laut Program') : (str_contains($program->title, 'SMK') ? db_trans('program_smk_title', 'SMK Bisa! SMK Jago!', 'SMK Success Program') : (str_contains($program->title, 'Hutan') ? db_trans('program_forest_title', 'Hutan Anak Negeri', 'National Forest Program') : (str_contains($program->title, 'Kesehatan') ? db_trans('program_health_title', 'Kesehatan Masyarakat', 'Public Health Initiative') : $program->title))))) . ' - Yayasan LINTASAN')
@section('meta_description', Str::limit(strip_tags(str_contains($program->title, 'SPAB') ? db_trans('program_spab_desc', 'Membangun budaya sadar bencana di sekolah dan masyarakat.', 'Building a culture of disaster awareness in schools and communities.') : (str_contains($program->title, 'Tabur Laut') ? db_trans('program_tabur_desc', 'Penguatan ekonomi nelayan melalui pendampingan usaha dan inovasi.', 'Strengthening fishermen economics through business guidance and innovation.') : (str_contains($program->title, 'SMK') ? db_trans('program_smk_desc', 'Meningkatkan kompetensi siswa SMK agar siap kerja dan berdaya saing.', 'Enhancing vocational student competency to be ready-to-work and competitive.') : (str_contains($program->title, 'Hutan') ? db_trans('program_forest_desc', 'Gerakan menanam dan merawat hutan untuk masa depan bumi yang lebih baik.', 'Reforesting and caring for forests for a better future of our planet.') : (str_contains($program->title, 'Kesehatan') ? db_trans('program_health_desc', 'Pemeriksaan kesehatan dan edukasi hidup sehat bagi komunitas.', 'Providing health checkups and healthy lifestyle education for communities.') : $program->description))))), 150))
@section('og_image', asset($program->image_url))

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @php
            $progTitle = $program->title;
            $progDesc = $program->description;
            if (str_contains($program->title, 'SPAB')) {
                $progTitle = db_trans('program_spab_title', 'SPAB (Sekolah Aman Bencana)', 'Disaster Preparedness School (SPAB)');
                $progDesc = db_trans('program_spab_desc', 'Membangun budaya sadar bencana di sekolah dan masyarakat.', 'Building a culture of disaster awareness in schools and communities.');
            } elseif (str_contains($program->title, 'Tabur Laut')) {
                $progTitle = db_trans('program_tabur_title', 'Tabur Laut', 'Tabur Laut Program');
                $progDesc = db_trans('program_tabur_desc', 'Penguatan ekonomi nelayan melalui pendampingan usaha dan inovasi.', 'Strengthening fishermen economics through business guidance and innovation.');
            } elseif (str_contains($program->title, 'SMK Bisa')) {
                $progTitle = db_trans('program_smk_title', 'SMK Bisa! SMK Jago!', 'SMK Success Program');
                $progDesc = db_trans('program_smk_desc', 'Meningkatkan kompetensi siswa SMK agar siap kerja dan berdaya saing.', 'Enhancing vocational student competency to be ready-to-work and competitive.');
            } elseif (str_contains($program->title, 'Hutan')) {
                $progTitle = db_trans('program_forest_title', 'Hutan Anak Negeri', 'National Forest Program');
                $progDesc = db_trans('program_forest_desc', 'Gerakan menanam dan merawat hutan untuk masa depan bumi yang lebih baik.', 'Reforesting and caring for forests for a better future of our planet.');
            } elseif (str_contains($program->title, 'Kesehatan')) {
                $progTitle = db_trans('program_health_title', 'Kesehatan Masyarakat', 'Public Health Initiative');
                $progDesc = db_trans('program_health_desc', 'Pemeriksaan kesehatan dan edukasi hidup sehat bagi komunitas.', 'Providing health checkups and healthy lifestyle education for communities.');
            }
        @endphp

        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-xs text-gray-500 gap-2">
            <a href="/" class="hover:text-brand-green transition">{{ db_trans('breadcrumb_home', 'Beranda', 'Home') }}</a>
            <span>/</span>
            <a href="{{ route('public.programs.index') }}" class="hover:text-brand-green transition">{{ db_trans('breadcrumb_programs', 'Program', 'Program') }}</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">{{ $progTitle }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Details -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 {{ $program->color_class }} text-white rounded-full flex items-center justify-center text-xl shadow-sm">
                        <i class="fas {{ $program->icon }}"></i>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">{{ $progTitle }}</h1>
                </div>

                <div class="h-64 sm:h-[350px] w-full rounded-lg bg-gray-200 bg-cover bg-center mb-8" style="background-image: url('{{ $program->image_url }}');"></div>

                <div class="rich-text-content prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-base">
                    <p class="mb-4">{!! db_trans('program_detail_intro', 'Program <strong>' . e($progTitle) . '</strong> merupakan salah satu inisiatif utama Yayasan LINTASAN dalam pemberdayaan berkelanjutan masyarakat pesisir di Indonesia.', 'The <strong>' . e($progTitle) . '</strong> program is one of the main initiatives of LINTASAN Foundation in fostering sustainable empowerment in coastal communities across Indonesia.') !!}</p>
                    <div class="mb-4">{!! $progDesc !!}</div>
                    <p class="mb-4">{!! db_trans('program_detail_collab', 'Kami bekerjasama dengan para ahli, mitra kolaborasi lokal, dan sukarelawan untuk memastikan implementasi program berjalan efisien dan berdampak positif jangka panjang.', 'We cooperate with experts, local collaborative partners, and volunteers to ensure efficient program implementation and long-term positive impact.') !!}</p>
                    <p>{!! db_trans('program_detail_focus', 'Fokus utama program ini mencakup pendampingan intensif, penyediaan sumber daya teknologi tepat guna, kurikulum edukatif kebencanaan/keterampilan, serta pemantauan berkelanjutan demi mendukung kemandirian lokal.', 'Our core focus includes intensive mentoring, provision of appropriate technology resources, educational training curriculum for disaster/vocational skills, and constant progress monitoring to support local self-reliance.') !!}</p>
                </div>
            </div>

            <!-- Right Column: Other Programs -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 border-b border-gray-100 pb-2">
                        {{ db_trans('program_other_programs', 'Program Lainnya', 'Other Programs') }}
                    </h3>
                    <div class="space-y-4">
                        @forelse($otherPrograms as $other)
                            @php
                                $otherTitle = $other->title;
                                $otherDesc = $other->description;
                                if (str_contains($other->title, 'SPAB')) {
                                    $otherTitle = db_trans('program_spab_title', 'SPAB (Sekolah Aman Bencana)', 'Disaster Preparedness School (SPAB)');
                                    $otherDesc = db_trans('program_spab_desc', 'Membangun budaya sadar bencana di sekolah dan masyarakat.', 'Building a culture of disaster awareness in schools and communities.');
                                } elseif (str_contains($other->title, 'Tabur Laut')) {
                                    $otherTitle = db_trans('program_tabur_title', 'Tabur Laut', 'Tabur Laut Program');
                                    $otherDesc = db_trans('program_tabur_desc', 'Penguatan ekonomi nelayan melalui pendampingan usaha dan inovasi.', 'Strengthening fishermen economics through business guidance and innovation.');
                                } elseif (str_contains($other->title, 'SMK Bisa')) {
                                    $otherTitle = db_trans('program_smk_title', 'SMK Bisa! SMK Jago!', 'SMK Success Program');
                                    $otherDesc = db_trans('program_smk_desc', 'Meningkatkan kompetensi siswa SMK agar siap kerja dan berdaya saing.', 'Enhancing vocational student competency to be ready-to-work and competitive.');
                                } elseif (str_contains($other->title, 'Hutan')) {
                                    $otherTitle = db_trans('program_forest_title', 'Hutan Anak Negeri', 'National Forest Program');
                                    $otherDesc = db_trans('program_forest_desc', 'Gerakan menanam dan merawat hutan untuk masa depan bumi yang lebih baik.', 'Reforesting and caring for forests for a better future of our planet.');
                                } elseif (str_contains($other->title, 'Kesehatan')) {
                                    $otherTitle = db_trans('program_health_title', 'Kesehatan Masyarakat', 'Public Health Initiative');
                                    $otherDesc = db_trans('program_health_desc', 'Pemeriksaan kesehatan dan edukasi hidup sehat bagi komunitas.', 'Providing health checkups and healthy lifestyle education for communities.');
                                }
                            @endphp
                            <a href="{{ route('public.programs.show', $other->code) }}" class="flex gap-3 group">
                                <div class="w-12 h-12 rounded {{ $other->color_class }} text-white flex items-center justify-center shrink-0 shadow-sm text-sm">
                                    <i class="fas {{ $other->icon }}"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-xs text-gray-900 group-hover:text-brand-green transition leading-tight">{{ $otherTitle }}</h4>
                                    <p class="text-[10px] text-gray-500 line-clamp-2 mt-0.5">{{ $otherDesc }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-gray-500">
                                {{ db_trans('program_no_other_programs', 'Tidak ada program lain.', 'No other programs.') }}
                            </p>
                        @endforelse
                    </div>
                </div>

                @if($relatedStories && $relatedStories->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 text-sm mb-4 border-b border-gray-100 pb-2 flex items-center gap-1.5">
                            <i class="fas fa-newspaper text-brand-green"></i>
                            {{ db_trans('program_related_news', 'Artikel & Dampak Terkait', 'Related Articles / Impact') }}
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedStories->take(3) as $story)
                                <a href="{{ route('public.stories.show', $story->slug) }}" class="flex gap-3 group">
                                    <div class="w-14 h-10 rounded bg-gray-150 bg-cover bg-center shrink-0 shadow-sm border border-gray-100" style="background-image: url('{{ $story->image_url }}');"></div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-bold text-[11px] text-gray-900 group-hover:text-brand-green transition leading-tight line-clamp-2">{{ $story->title }}</h4>
                                        <p class="text-[9px] text-gray-400 mt-0.5">{{ $story->created_at->format('d M Y') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-brand-darkgreen text-white rounded-xl shadow-sm border border-brand-green/20 p-6 text-center">
                    <h4 class="font-bold text-sm mb-2 text-brand-yellow">
                        {{ db_trans('program_sidebar_cta_title', 'Mari Berkolaborasi!', 'Let\'s Collaborate!') }}
                    </h4>
                    <p class="text-xs text-gray-200 mb-4 leading-relaxed">
                        {{ db_trans('program_sidebar_cta_desc', 'Dukung program ini untuk memperluas sebaran manfaat di pesisir Indonesia.', 'Support this program to expand the spread of benefits on the coasts of Indonesia.') }}
                    </p>
                    <a href="{{ route('public.volunteer.index') }}" class="inline-block bg-brand-orange text-white text-xs font-semibold px-4 py-2.5 rounded hover:bg-orange-600 shadow transition">
                        {{ db_trans('program_sidebar_cta_btn', 'Gabung Relawan / Mitra', 'Join as Volunteer / Partner') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Related Stories Grid -->
        @if($relatedStories && $relatedStories->count() > 0)
            <div class="mt-12 border-t border-gray-200 pt-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-brand-green rounded-full"></span>
                        {{ db_trans('program_field_stories_title', 'Cerita Langsung dari Lapangan', 'Stories from the Field') }}
                    </h2>
                    @if($relatedStories->count() > 3)
                        <a href="{{ route('public.stories.index') }}" class="text-xs font-bold text-brand-green hover:underline flex items-center gap-1">
                            {{ db_trans('program_view_all_stories', 'Lihat Semua Cerita', 'View All Stories') }} <i class="fas fa-chevron-right text-[10px]"></i>
                        </a>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
                    @foreach($relatedStories as $story)
                        <a href="{{ route('public.stories.show', $story->slug) }}" class="bg-white rounded-xl overflow-hidden border border-gray-150 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-300 flex flex-col justify-between group block">
                            <div>
                                <div class="h-40 bg-gray-200 bg-cover bg-center" style="background-image: url('{{ $story->image_url }}');"></div>
                                <div class="p-5">
                                    <span class="inline-block bg-brand-green/10 text-brand-green text-[9px] font-extrabold px-2 py-0.5 rounded uppercase">
                                        {{ $story->category }}
                                    </span>
                                    <h3 class="font-bold text-sm text-gray-900 mt-3 mb-2 line-clamp-2 leading-tight">{{ $story->title }}</h3>
                                    <p class="text-[11px] text-gray-500 line-clamp-3 leading-relaxed mb-4">{{ strip_tags($story->description) }}</p>
                                </div>
                            </div>
                            <div class="p-5 pt-0">
                                <span class="text-brand-green font-semibold text-[11px] flex items-center gap-1 group-hover:gap-1.5 transition">
                                    {{ db_trans('program_read_story', 'Baca Cerita', 'Read Story') }} <i class="fas fa-arrow-right text-[9px]"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
