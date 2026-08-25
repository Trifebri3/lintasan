@extends('public.layout.app')

@section('title', db_trans('meta_donation_title', 'Salurkan Donasi Anda', 'Support Us / Donation') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_donation_desc', 'Salurkan bantuan donasi terbaik Anda untuk membantu pemberdayaan masyarakat dan peningkatan ketangguhan pesisir Indonesia.', 'Support Yayasan LINTASAN programs through donation to help build resilient coastal communities in Indonesia.'))

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                {{ db_trans('donation_badge', 'Salurkan Kebaikan Anda', 'Share Smile & Hope') }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                Dukung Langkah Lintasan di Lapangan
            </h1>
            <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
            <p class="text-gray-500 text-sm max-w-xl mx-auto mt-4 leading-relaxed">
                Dukung program perlindungan, pendidikan, vokasi, dan kelestarian alam bersama Yayasan LINTASAN.
            </p>
        </div>

        <!-- Donation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch mb-12">
            <!-- Left: Transfer Info -->
            <div id="transfer-info-box" class="bg-white rounded-xl shadow-sm border border-gray-150 p-8 flex flex-col justify-between">
                <div>
                    <h3 class="font-extrabold text-lg text-gray-900 mb-2">
                        {{ db_trans('donation_bank_title', 'Transfer Bank', 'Bank Transfer') }}
                    </h3>
                    <p class="text-xs text-gray-500 mb-6">
                        {{ db_trans('donation_bank_desc', 'Silakan lakukan transfer ke rekening resmi yayasan di bawah ini:', 'Please make transfers to the official foundation bank account below:') }}
                    </p>

                    <!-- Mandiri Account Box -->
                    <div class="bg-brand-lightbg border border-brand-green/20 rounded-xl p-6 relative">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[10px] font-bold text-brand-green uppercase tracking-wider">{{ db_trans('donation_acc_label', 'Rekening Mandiri', 'Mandiri Account') }}</span>
                            <span class="text-xs font-extrabold text-gray-700">Bank Mandiri</span>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-[10px] text-gray-400 font-bold uppercase mb-1">
                                {{ db_trans('donation_acc_number_label', 'Nomor Rekening', 'Account Number') }}
                            </label>
                            <div class="flex items-center justify-between gap-2">
                                <span id="account-number" class="text-xl sm:text-2xl font-extrabold text-gray-800 tracking-wider">131-05-5535000-0</span>
                                <button onclick="copyToClipboard()" id="copy-btn" class="bg-white border border-gray-200 text-[10px] font-bold px-3 py-1.5 rounded-lg hover:border-brand-green text-brand-green shadow-sm flex items-center gap-1 shrink-0">
                                    <i class="fas fa-copy"></i> <span>{{ db_trans('donation_copy', 'Salin', 'Copy') }}</span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] text-gray-400 font-bold uppercase mb-1">
                                {{ db_trans('donation_acc_holder_label', 'Nama Pemilik Rekening', 'Account Holder') }}
                            </label>
                            <span class="text-sm font-extrabold text-gray-800 uppercase block leading-snug">YAYASAN LINTAS SENYUM ANAK NEGERI</span>
                        </div>
                    </div>
                </div>

                <div class="text-[10px] text-gray-400 mt-6 leading-relaxed flex items-start gap-2 bg-gray-50 p-3 rounded-lg">
                    <i class="fas fa-circle-info text-brand-orange text-xs mt-0.5 shrink-0"></i>
                    <span>
                        {{ db_trans('donation_instruction_note', 'Mohon tambahkan keterangan saat transfer (misal: "Donasi SPAB") untuk membantu kami mengelompokkan alokasi anggaran.', 'Please include confirmation or description (e.g., "Donasi SPAB") during transfer to help us organize the budget allocations.') }}
                    </span>
                </div>
            </div>

            <!-- Right: Donation Value -->
            <div class="bg-brand-darkgreen text-white rounded-xl shadow-sm border border-brand-green/20 p-8 flex flex-col justify-between">
                <div>
                    <span class="bg-brand-orange text-white text-[9px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider block w-max mb-4">
                        Langkah di Lapangan
                    </span>
                    <h3 class="font-extrabold text-xl mb-6 text-brand-yellow">
                        Fokus Alokasi Dukungan
                    </h3>
                    
                    <div class="space-y-4 text-xs">
                        <div>
                            <strong class="text-brand-orange">SPAB</strong>
                            <p class="text-gray-200 mt-0.5 leading-relaxed">Mendukung sekolah dan masyarakat agar lebih siap menghadapi risiko bencana.</p>
                        </div>
                        <div>
                            <strong class="text-brand-yellow">Senyum Anak Negeri</strong>
                            <p class="text-gray-200 mt-0.5 leading-relaxed">Membuka ruang bagi anak untuk belajar, bermain, tumbuh, dan menemukan potensinya.</p>
                        </div>
                        <div>
                            <strong class="text-blue-300">SMK BISA! SMK JAGO!</strong>
                            <p class="text-gray-200 mt-0.5 leading-relaxed">Membuka akses talenta vokasi terhadap teknologi, mentor, industri, dan kesempatan berkarya.</p>
                        </div>
                        <div>
                            <strong class="text-emerald-300">Hutan Anak Negeri</strong>
                            <p class="text-gray-200 mt-0.5 leading-relaxed">Menguatkan masyarakat dan kelembagaan lokal untuk menjaga hutan dan membangun lanskap yang lestari.</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-white/10 text-xs text-gray-200 leading-relaxed">
                        <p class="font-bold mb-2 text-white text-sm">Anda Bisa Menjadi Bagian dari Perjalanan Ini</p>
                        <p>Dukungan Anda membantu kami membangun program, memperkuat masyarakat, dan menjaga agar inisiatif di lapangan dapat terus tumbuh bersama mereka yang kami dampingi.</p>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="#transfer-info-box" class="w-full text-center block bg-brand-orange hover:bg-orange-600 text-white text-xs font-bold py-3 rounded-lg shadow transition uppercase tracking-wider">
                        DONASI SEKARANG
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function copyToClipboard() {
        const textToCopy = "131-05-5535000-0";
        navigator.clipboard.writeText(textToCopy).then(() => {
            const copyBtn = document.getElementById('copy-btn');
            const spanText = copyBtn.querySelector('span');
            
            spanText.textContent = "{{ db_trans('donation_copied', 'Tersalin!', 'Copied!') }}";
            copyBtn.classList.remove('hover:border-brand-green');
            copyBtn.classList.add('border-brand-green', 'bg-green-50');

            setTimeout(() => {
                spanText.textContent = "{{ db_trans('donation_copy', 'Salin', 'Copy') }}";
                copyBtn.classList.remove('border-brand-green', 'bg-green-50');
                copyBtn.classList.add('hover:border-brand-green');
            }, 2000);
        });
    }
</script>
@endsection
