<section id="how-we-work" class="py-20 mt-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
            {{ db_trans('hww_title', 'Bagaimana LINTASAN Bekerja', 'How LINTASAN Works') }}
        </h2>
        <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 relative">
        <!-- Connecting Line 1 to 2 -->
        <div class="absolute top-8 left-[calc(12.5%+2rem)] w-[calc(25%-4rem)] h-0.5 border-t-2 border-dashed border-gray-300 hidden lg:block z-0">
            <div class="absolute right-0 -top-1 text-gray-400 text-[8px]"><i class="fas fa-chevron-right"></i></div>
        </div>
        <!-- Connecting Line 2 to 3 -->
        <div class="absolute top-8 left-[calc(37.5%+2rem)] w-[calc(25%-4rem)] h-0.5 border-t-2 border-dashed border-gray-300 hidden lg:block z-0">
            <div class="absolute right-0 -top-1 text-gray-400 text-[8px]"><i class="fas fa-chevron-right"></i></div>
        </div>
        <!-- Connecting Line 3 to 4 -->
        <div class="absolute top-8 left-[calc(62.5%+2rem)] w-[calc(25%-4rem)] h-0.5 border-t-2 border-dashed border-gray-300 hidden lg:block z-0">
            <div class="absolute right-0 -top-1 text-gray-400 text-[8px]"><i class="fas fa-chevron-right"></i></div>
        </div>

        <!-- Step 1 -->
        <div class="text-center group relative z-10">
            <div class="w-16 h-16 bg-blue-50/80 border border-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-650 group-hover:bg-gradient-to-br group-hover:from-[#00c6ff] group-hover:to-[#0072ff] group-hover:text-white transition duration-300 text-xl shadow-sm">
                <i class="fas fa-ear-listen"></i>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">
                {{ db_trans('hww_step1_title', '1. Mendengar', '1. Listen') }}
            </h3>
            <p class="text-xs text-gray-500 max-w-xs mx-auto leading-relaxed">
                {{ db_trans('hww_step1_desc', 'Pemetaan desa dan mendengar kebutuhan masyarakat secara langsung.', 'Village mapping and listening directly to local community needs.') }}
            </p>
        </div>
        
        <!-- Step 2 -->
        <div class="text-center group relative z-10">
            <div class="w-16 h-16 bg-teal-50/80 border border-teal-100 rounded-full flex items-center justify-center mx-auto mb-4 text-teal-650 group-hover:bg-gradient-to-br group-hover:from-[#11998e] group-hover:to-[#38ef7d] group-hover:text-white transition duration-300 text-xl shadow-sm">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">
                {{ db_trans('hww_step2_title', '2. Merancang', '2. Design') }}
            </h3>
            <p class="text-xs text-gray-500 max-w-xs mx-auto leading-relaxed">
                {{ db_trans('hww_step2_desc', 'Menyusun solusi dan program bersama komunitas sesuai kebutuhan lokal.', 'Formulating solutions and programs alongside communities based on local needs.') }}
            </p>
        </div>
        
        <!-- Step 3 -->
        <div class="text-center group relative z-10">
            <div class="w-16 h-16 bg-orange-50/80 border border-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 text-brand-orange group-hover:bg-gradient-to-br group-hover:from-[#ff9966] group-hover:to-[#ff5e62] group-hover:text-white transition duration-300 text-xl shadow-sm">
                <i class="fas fa-handshake"></i>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">
                {{ db_trans('hww_step3_title', '3. Berkolaborasi', '3. Collaborate') }}
            </h3>
            <p class="text-xs text-gray-500 max-w-xs mx-auto leading-relaxed">
                {{ db_trans('hww_step3_desc', 'Menghubungkan sumber daya, mitra, dan relawan untuk bergerak bersama.', 'Connecting resources, partners, and volunteers to move forward together.') }}
            </p>
        </div>
        
        <!-- Step 4 -->
        <div class="text-center group relative z-10">
            <div class="w-16 h-16 bg-purple-50/80 border border-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 text-purple-650 group-hover:bg-gradient-to-br group-hover:from-[#833ab4] group-hover:to-[#da1b60] group-hover:text-white transition duration-300 text-xl shadow-sm">
                <i class="fas fa-bullseye"></i>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">
                {{ db_trans('hww_step4_title', '4. Berdampak', '4. Impact') }}
            </h3>
            <p class="text-xs text-gray-500 max-w-xs mx-auto leading-relaxed">
                {{ db_trans('hww_step4_desc', 'Menghasilkan perubahan nyata yang berkelanjutan bagi masyarakat.', 'Generating tangible and sustainable positive changes for the society.') }}
            </p>
        </div>
    </div>
</section>
