<style>
    /* Scroll animations */
    .scroll-animate {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .scroll-animate.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<section id="impact-section" class="pt-10 pb-0 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 scroll-animate">
        <div class="flex justify-between items-end border-b border-gray-100 pb-3">
            <h2 class="text-xl font-extrabold text-gray-900">
                {{ $settings['title_impact'] ?? db_trans('title_impact', 'Lintasan Dalam Angka', 'Lintasan in Numbers') }}
            </h2>
            <a href="{{ route('public.stories.index') }}" class="text-[10px] text-brand-green font-semibold hover:underline flex items-center gap-1 transition">
                {{ db_trans('impact_view_details', 'Lihat Detail Dampak', 'View Impact Details') }} <i class="fas fa-arrow-right text-[8px]"></i>
            </a>
        </div>
    </div>
    
    <!-- Colored Blocks Grid (Full Width) -->
    <div class="w-full grid grid-cols-2 md:grid-cols-6 text-white text-center relative overflow-hidden">
        @php
            // Vibrant solid gradients with Gray & Yellow combination
            $gradients = [
                'bg-gradient-to-br from-[#e11d48] to-[#be123c]', // Merah / Rose Red
                'bg-gradient-to-br from-[#0284c7] to-[#0072ff]', // Biru / Ocean Blue
                'bg-gradient-to-br from-[#64748b] to-[#475569]', // Abu-abu / Slate Gray
                'bg-gradient-to-br from-[#11998e] to-[#38ef7d]', // Hijau / Emerald Green
                'bg-gradient-to-br from-[#f59e0b] to-[#d97706]', // Kuning / Amber Yellow
                'bg-gradient-to-br from-[#ff9966] to-[#ff5e62]', // Jingga / Sunset Orange
            ];
            
            $fallbackStats = [
                ['key' => 'sekolah_terjangkau', 'icon' => 'fa-school', 'value' => '40', 'label' => 'Schools Reached', 'label_id' => 'Sekolah Terjangkau'],
                ['key' => 'desa_dampingan', 'icon' => 'fa-house-chimney', 'value' => '15', 'label' => 'Assisted Villages', 'label_id' => 'Desa Dampingan'],
                ['key' => 'relawan_terlibat', 'icon' => 'fa-user-group', 'value' => '120', 'label' => 'Volunteers', 'label_id' => 'Relawan Terlibat'],
                ['key' => 'mitra_kolaborasi', 'icon' => 'fa-handshake', 'value' => '50', 'label' => 'Partners', 'label_id' => 'Mitra Kolaborasi'],
                ['key' => 'penerima_manfaat', 'icon' => 'fa-users', 'value' => '3.200', 'label' => 'Beneficiaries', 'label_id' => 'Penerima Manfaat'],
                ['key' => 'program_berjalan', 'icon' => 'fa-tasks', 'value' => '20', 'label' => 'Active Programs', 'label_id' => 'Program Berjalan'],
            ];
        @endphp

        @forelse($impactStats as $index => $stat)
            @php
                $statLabel = $stat->label;
                if ($stat->key == 'sekolah_terjangkau') $statLabel = db_trans('stat_sekolah_terjangkau', 'Sekolah Terjangkau', 'Schools Reached');
                elseif ($stat->key == 'desa_dampingan') $statLabel = db_trans('stat_desa_dampingan', 'Desa Dampingan', 'Assisted Villages');
                elseif ($stat->key == 'relawan_terlibat') $statLabel = db_trans('stat_relawan_terlibat', 'Relawan Terlibat', 'Volunteers');
                elseif ($stat->key == 'mitra_kolaborasi') $statLabel = db_trans('stat_mitra_kolaborasi', 'Mitra Kolaborasi', 'Partners');
                elseif ($stat->key == 'penerima_manfaat') $statLabel = db_trans('stat_penerima_manfaat', 'Penerima Manfaat', 'Beneficiaries');
                elseif ($stat->key == 'program_berjalan') $statLabel = db_trans('stat_program_berjalan', 'Program Berjalan', 'Active Programs');
                else $statLabel = db_trans('stat_' . $stat->key, $stat->label, $stat->label);
                
                $bg = $stat->color_class ?: $gradients[$index % count($gradients)];
                
                // Parse numbers and suffixes dynamically
                $rawValue = $stat->value;
                $cleanValue = preg_replace('/[^0-9]/', '', $rawValue);
                $suffix = preg_replace('/[0-9.]/', '', $rawValue);
                $hasDot = str_contains($rawValue, '.');
            @endphp
            <div class="{{ $bg }} px-4 py-8 flex flex-col justify-center items-center transition duration-500 hover:scale-[1.03] hover:z-10 shadow-lg min-h-[140px]">
                <div class="text-2xl mb-1.5 opacity-95 drop-shadow-sm"><i class="fas {{ $stat->icon }}"></i></div>
                <h3 class="text-xl font-extrabold leading-tight stat-counter drop-shadow-sm" 
                    data-count="{{ $cleanValue }}" 
                    data-suffix="{{ $suffix }}" 
                    data-format="{{ $hasDot ? 'true' : 'false' }}">
                    0{{ $suffix }}
                </h3>
                <p class="text-[10px] uppercase font-bold tracking-wider opacity-90 mt-1 drop-shadow-sm">{{ $statLabel }}</p>
            </div>
        @empty
            @foreach($fallbackStats as $index => $stat)
                @php
                    $bg = $gradients[$index % count($gradients)];
                    $label = db_trans('stat_' . $stat['key'], $stat['label_id'], $stat['label']);
                    $rawValue = $stat['value'];
                    $cleanValue = preg_replace('/[^0-9]/', '', $rawValue);
                    $suffix = preg_replace('/[0-9.]/', '', $rawValue);
                    $hasDot = str_contains($rawValue, '.');
                @endphp
                <div class="{{ $bg }} px-4 py-8 flex flex-col justify-center items-center transition duration-500 hover:scale-[1.03] hover:z-10 shadow-lg min-h-[140px]">
                    <div class="text-2xl mb-1.5 opacity-95 drop-shadow-sm"><i class="fas {{ $stat['icon'] }}"></i></div>
                    <h3 class="text-xl font-extrabold leading-tight stat-counter drop-shadow-sm" 
                        data-count="{{ $cleanValue }}" 
                        data-suffix="{{ $suffix }}" 
                        data-format="{{ $hasDot ? 'true' : 'false' }}">
                        0{{ $suffix }}
                    </h3>
                    <p class="text-[10px] uppercase font-bold tracking-wider opacity-90 mt-1 drop-shadow-sm">{{ $label }}</p>
                </div>
            @endforeach
        @endforelse
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Text animation intersection observer
        const animatedElements = document.querySelectorAll('.scroll-animate');
        const textObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    textObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        
        animatedElements.forEach(el => textObserver.observe(el));

        // Number count up intersection observer
        const counters = document.querySelectorAll('.stat-counter');
        const countUp = (target) => {
            const endVal = parseFloat(target.getAttribute('data-count'));
            const suffix = target.getAttribute('data-suffix') || '';
            const formatLoc = target.getAttribute('data-format') === 'true';
            const duration = 2000; // 2 seconds
            const startTime = performance.now();

            const updateCount = (currentTime) => {
                const elapsedTime = currentTime - startTime;
                if (elapsedTime >= duration) {
                    target.textContent = (formatLoc ? endVal.toLocaleString('id-ID') : endVal) + suffix;
                } else {
                    const progress = elapsedTime / duration;
                    const easeProgress = progress * (2 - progress); // Ease out quad
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
        }, { threshold: 0.15 });

        counters.forEach(counter => counterObserver.observe(counter));
    });
</script>
