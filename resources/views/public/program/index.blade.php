@extends('public.layout.app')

@section('title', db_trans('meta_programs_title', 'Program Kerja Kami', 'Our Programs') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_programs_desc', 'Ketahui program kerja unggulan Yayasan LINTASAN: Sekolah Aman Bencana (SPAB), Tabur Laut untuk nelayan, Vokasi SMK, dan Penanaman Mangrove.', 'Learn about LINTASAN featured empowerment programs: SPAB disaster resilience, Tabur Laut fisheries, SMK competency, and Mangrove reforestation.'))

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                {{ db_trans('programs_badge', 'Aksi Nyata', 'Real Actions') }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                {{ db_trans('programs_title', 'Program Unggulan Kami', 'Our Featured Programs') }}
            </h1>
            <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
            <p class="text-gray-500 text-sm max-w-xl mx-auto mt-4 leading-relaxed">
                {{ db_trans('programs_desc', 'Berbagai inisiatif berkelanjutan dalam membangun kemandirian, pendidikan, serta ketangguhan ekonomi dan kebencanaan.', 'Various sustainable initiatives in building independence, education, economic and disaster resilience.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($programs as $program)
                <!-- Program Card -->
                <a href="{{ route('public.programs.show', $program->code) }}" class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition duration-300 flex flex-col justify-between group block">
                    <div>
                        <div class="h-48 bg-gray-200 bg-cover bg-center relative" style="background-image: url('{{ $program->image_url }}');">
                            <div class="absolute -bottom-4 left-4 w-8 h-8 {{ $program->color_class }} text-white rounded-full flex items-center justify-center text-xs shadow-md border-2 border-white">
                                <i class="fas {{ $program->icon }}"></i>
                            </div>
                        </div>
                        <div class="p-6 pt-8">
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
                            <h3 class="font-bold text-lg text-gray-900 mb-2 leading-tight">{{ $progTitle }}</h3>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed line-clamp-3">{{ strip_tags($progDesc) }}</p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <span class="text-brand-green font-semibold text-xs flex items-center gap-1 group-hover:gap-2 transition">
                            {{ db_trans('program_read_more', 'Selengkapnya', 'Read More') }} <i class="fas fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-500 py-12">
                    {{ db_trans('program_empty', 'Belum ada program yang diunggah.', 'No programs uploaded yet.') }}
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
