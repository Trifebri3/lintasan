<section id="cta" class="relative text-white py-10 overflow-hidden bg-cover bg-center" style="background-image: linear-gradient(rgba(11, 17, 30, 0.93), rgba(11, 17, 30, 0.87)), url('{{ $settings['bg_photo_cta'] ?? 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=1000&q=80' }}');">
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <span class="text-brand-yellow font-serif text-sm block mb-1.5 italic">
            {{ db_trans('cta_subtitle', 'Bersama Kita Bisa,', 'Together We Can,') }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold mb-6">
            {{ db_trans('cta_title', 'Menjadi Bagian dari Perubahan Nyata', 'Be a Part of Real Change') }}
        </h2>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('public.pages.mitra') }}" class="bg-brand-orange text-white px-6 py-2.5 rounded-md font-semibold flex items-center gap-2 shadow-lg transition text-xs">
                <i class="fas fa-handshake"></i> {{ db_trans('cta_btn_partner', 'Menjadi Mitra', 'Become a Partner') }}
            </a>
            <a href="{{ route('public.volunteer.index') }}" class="border border-white text-white px-6 py-2.5 rounded-md font-semibold flex items-center gap-2 hover:bg-white/10 transition text-xs">
                <i class="fas fa-user-plus"></i> {{ db_trans('cta_btn_volunteer', 'Menjadi Relawan', 'Become a Volunteer') }}
            </a>
        </div>
    </div>
</section>
