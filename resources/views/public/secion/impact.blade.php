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
    
    <!-- Colored Blocks Grid (Full Width) with Background Image silhouette and translucent blocks -->
    <div class="w-full grid grid-cols-2 md:grid-cols-6 text-white text-center bg-cover bg-center relative" style="background-image: url('{{ $settings['bg_photo_impact'] ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80' }}');">
        @php
            // Social-media inspired colorful gradients with thinner opacity (70% / 0.7) for clear silhouette exposure
            $gradients = [
                'bg-gradient-to-br from-[#833ab4]/70 via-[#fd1d1d]/70 to-[#fcb045]/70', // Instagram Gradient
                'bg-gradient-to-br from-[#00c6ff]/70 to-[#0072ff]/70',                // Royal Blue/Teal
                'bg-gradient-to-br from-[#f857a6]/70 to-[#ff5858]/70',                // Rose/Orange
                'bg-gradient-to-br from-[#11998e]/70 to-[#38ef7d]/70',                // Aurora Green/Teal
                'bg-gradient-to-br from-[#ff9966]/70 to-[#ff5e62]/70',                // Sunset Orange/Red
                'bg-gradient-to-br from-[#da1b60]/70 to-[#ff8a00]/70',                // Pink/Gold
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
            <div class="{{ $bg }} px-4 py-8 flex flex-col justify-center items-center transition duration-500 hover:scale-[1.03] hover:z-10 shadow-lg min-h-[140px] backdrop-blur-[1.5px]">
                <div class="text-2xl mb-1.5 opacity-90"><i class="fas {{ $stat->icon }}"></i></div>
                <h3 class="text-xl font-extrabold leading-tight stat-counter" 
                    data-count="{{ $cleanValue }}" 
                    data-suffix="{{ $suffix }}" 
                    data-format="{{ $hasDot ? 'true' : 'false' }}">
                    0{{ $suffix }}
                </h3>
                <p class="text-[10px] uppercase font-bold tracking-wider opacity-85 mt-1">{{ $statLabel }}</p>
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
                <div class="{{ $bg }} px-4 py-8 flex flex-col justify-center items-center transition duration-500 hover:scale-[1.03] hover:z-10 shadow-lg min-h-[140px] backdrop-blur-[1.5px]">
                    <div class="text-2xl mb-1.5 opacity-90"><i class="fas {{ $stat['icon'] }}"></i></div>
                    <h3 class="text-xl font-extrabold leading-tight stat-counter" 
                        data-count="{{ $cleanValue }}" 
                        data-suffix="{{ $suffix }}" 
                        data-format="{{ $hasDot ? 'true' : 'false' }}">
                        0{{ $suffix }}
                    </h3>
                    <p class="text-[10px] uppercase font-bold tracking-wider opacity-85 mt-1">{{ $label }}</p>
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
