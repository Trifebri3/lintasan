<section id="program" class="py-16 bg-brand-lightbg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">
                    {{ db_trans('home_programs_title', 'Program Unggulan Kami', 'Our Featured Programs') }}
                </h2>
            </div>
            @if($programs->count() > 4)
            <a href="{{ route('public.programs.index') }}" class="text-brand-green text-sm font-semibold flex items-center gap-1 hover:underline">
                {{ db_trans('home_programs_view_all', 'Lihat Semua Program', 'See All Programs') }} <i class="fas fa-arrow-right text-xs"></i>
            </a>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @forelse($programs as $program)
                <!-- Program Card -->
                <a href="{{ route('public.programs.show', $program->code) }}" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition duration-300 flex flex-col justify-between group border border-gray-150 block">
                    <div>
                        @php
                            $progColorMap = [
                                'bg-brand-orange' => 'from-[#ff9966] to-[#ff5e62]',
                                'bg-brand-green' => 'from-[#11998e] to-[#38ef7d]',
                                'bg-green-650' => 'from-[#11998e] to-[#38ef7d]',
                                'bg-green-600' => 'from-[#11998e] to-[#38ef7d]',
                            ];
                            $cardAccent = $progColorMap[$program->color_class] ?? 'from-[#00c6ff] to-[#0072ff]';
                        @endphp
                        <div class="h-[3px] w-full bg-gradient-to-r {{ $cardAccent }}"></div>
                        
                        <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $program->image_url }}');"></div>
                        <div class="p-4">
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
                            <h3 class="font-bold text-sm text-gray-900 mb-2 min-h-[40px] leading-tight">{{ $progTitle }}</h3>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-3 leading-relaxed">{{ strip_tags($progDesc) }}</p>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        <span class="text-brand-green font-semibold text-xs flex items-center gap-1 group-hover:gap-2 transition">
                            {{ db_trans('program_read_more', 'Selengkapnya', 'Read More') }} <i class="fas fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </a>
            @empty
                <!-- Fallback Programs -->
                <div class="col-span-full text-center text-gray-500 text-sm py-8">
                    Belum ada program unggulan.
                </div>
            @endforelse
        </div>
    </div>
</section>
