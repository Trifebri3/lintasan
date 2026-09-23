@extends('public.layout.app')

@section('title', db_trans('meta_mitra_title', 'Mitra Kolaborasi', 'Collaboration Partners') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_mitra_desc', 'Daftar lembaga, korporasi, dan organisasi mitra kolaborasi dalam mendukung program Yayasan LINTASAN.', 'Collaborative partners supporting Yayasan LINTASAN coastal empowerment programs.'))

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
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

        <!-- 1. Daftar Mitra Resmi yang Telah Bersinergi (Bagian Atas) -->
        <div class="mb-20">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @forelse($partners as $partner)
                    @if($partner->logo_path)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col items-center text-center hover:shadow-md transition duration-200">
                            <div class="w-24 h-16 rounded bg-gray-50 flex items-center justify-center border border-gray-100 p-2 mb-3 shadow-inner">
                                <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-12 max-w-full object-contain">
                            </div>
                            <h3 class="font-bold text-gray-900 text-xs leading-snug">{{ $partner->name }}</h3>
                            <span class="bg-green-50 text-brand-green text-[9px] font-bold px-2 py-0.5 rounded-full border border-green-100 mt-2">
                                {{ db_trans('mitra_official_label', 'Mitra Resmi', 'Official Partner') }}
                            </span>
                        </div>
                    @endif
                @empty
                    <div class="col-span-full text-center text-gray-400 py-12 text-xs">
                        {{ db_trans('mitra_empty', 'Belum ada mitra kolaborasi yang terdaftar.', 'No partners registered.') }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. Formulir Partisipasi Kemitraan (Bagian Bawah) -->
        <div class="max-w-4xl mx-auto pt-10 border-t border-gray-200">
            <div class="text-center mb-10">
                <span class="text-brand-green font-bold text-xs uppercase tracking-wider block mb-2">
                    {{ db_trans('mitra_form_badge', 'Partisipasi Kemitraan', 'Partnership Form') }}
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">
                    {{ db_trans('mitra_form_title', 'Mari Berkolaborasi Bersama Kami', 'Let\'s Collaborate With Us') }}
                </h2>
                <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
                <p class="text-gray-500 text-xs sm:text-sm max-w-lg mx-auto mt-4 leading-relaxed font-medium">
                    {{ db_trans('mitra_form_desc', 'Lembaga, perusahaan, atau instansi Anda ingin bersinergi? Isi formulir kemitraan di bawah ini untuk memulai inisiatif bersama.', 'Would your institution or company like to synergize? Fill out the partnership form below to initiate collaboration.') }}
                </p>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-10">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-brand-green rounded-lg p-4 mb-6 flex items-start gap-3 text-sm font-medium">
                        <i class="fas fa-circle-check text-lg mt-0.5"></i>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-300 text-red-800 rounded-lg p-4 mb-6 flex items-start gap-3 text-sm font-medium shadow-sm">
                        <i class="fas fa-circle-xmark text-lg text-red-600 mt-0.5 shrink-0"></i>
                        <div>
                            <div class="font-bold text-red-900 mb-1">Gagal Mengirim Pengajuan Kemitraan</div>
                            <div class="text-xs text-red-700 whitespace-pre-line leading-relaxed">{{ session('error') }}</div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6 text-xs font-semibold shadow-sm">
                        <div class="font-extrabold text-sm mb-2 flex items-center gap-1.5 text-red-800">
                            <i class="fas fa-triangle-exclamation text-base text-red-600"></i> Mohon Periksa Isian Formulir Anda:
                        </div>
                        <ul class="list-disc pl-5 space-y-1 font-medium">
                            @foreach($errors->all() as $error)
                                <li class="leading-relaxed">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ \Illuminate\Support\Facades\Route::has('public.partner.store') ? route('public.partner.store') : url('/mitra/register') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="institution_name" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                                {{ db_trans('mitra_label_institution', 'Nama Lembaga / Perusahaan / Instansi', 'Institution / Company Name') }}
                            </label>
                            <input type="text" id="institution_name" name="institution_name" required value="{{ old('institution_name') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="{{ db_trans('mitra_ph_institution', 'Contoh: PT Bangun Negeri / Dinas Pendidikan', 'e.g. Acme Corp / Education Board') }}">
                            @error('institution_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="pic_name" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                                {{ db_trans('mitra_label_pic', 'Nama Kontak Person (PIC)', 'Contact Person / PIC Name') }}
                            </label>
                            <input type="text" id="pic_name" name="pic_name" required value="{{ old('pic_name') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="{{ db_trans('mitra_ph_pic', 'Nama lengkap narahubung / PIC', 'Full name of contact person') }}">
                            @error('pic_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                                {{ db_trans('mitra_label_email', 'Alamat Email Resmi', 'Official Email Address') }}
                            </label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="kontak@instansi.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                                {{ db_trans('mitra_label_phone', 'Nomor Telepon / WhatsApp PIC', 'Phone / WhatsApp Number') }}
                            </label>
                            <input type="text" id="phone" name="phone" required value="{{ old('phone') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="08xxxxxxxxxx">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="partnership_type" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                                {{ db_trans('mitra_label_type', 'Sektor / Bentuk Kemitraan', 'Partnership Category') }}
                            </label>
                            <select id="partnership_type" name="partnership_type" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white font-medium text-gray-700">
                                <option value="CSR & Pendanaan" {{ old('partnership_type') == 'CSR & Pendanaan' ? 'selected' : '' }}>{{ db_trans('mitra_type_csr', 'CSR Perusahaan / Pendanaan', 'Corporate CSR / Funding') }}</option>
                                <option value="Program & Implementasi Lapangan" {{ old('partnership_type') == 'Program & Implementasi Lapangan' ? 'selected' : '' }}>{{ db_trans('mitra_type_program', 'Program & Implementasi Lapangan', 'Program & Field Implementation') }}</option>
                                <option value="Lembaga Pemerintah" {{ old('partnership_type') == 'Lembaga Pemerintah' ? 'selected' : '' }}>{{ db_trans('mitra_type_gov', 'Lembaga Pemerintah / Dinas', 'Government Agency') }}</option>
                                <option value="Pendidikan & Riset" {{ old('partnership_type') == 'Pendidikan & Riset' ? 'selected' : '' }}>{{ db_trans('mitra_type_edu', 'Universitas / Sekolah / Lembaga Riset', 'Education / Research') }}</option>
                                <option value="Media & Komunitas" {{ old('partnership_type') == 'Media & Komunitas' ? 'selected' : '' }}>{{ db_trans('mitra_type_media', 'Media Partner / Komunitas Masyarakat', 'Media / Community') }}</option>
                                <option value="Lainnya" {{ old('partnership_type') == 'Lainnya' ? 'selected' : '' }}>{{ db_trans('mitra_type_other', 'Lainnya', 'Other') }}</option>
                            </select>
                            @error('partnership_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="logo" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                                {{ db_trans('mitra_label_logo', 'Logo Instansi / Profil (Opsional)', 'Organization Logo (Optional)') }}
                            </label>
                            <input type="file" id="logo" name="logo" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                            <p class="text-[9px] text-gray-500 mt-1"><i class="fas fa-circle-info text-brand-green mr-1"></i> {{ db_trans('mitra_logo_instruction', 'Format: JPG, JPEG, PNG, WEBP. Maks: 4 MB.', 'Format: JPG, JPEG, PNG, WEBP. Max: 4 MB.') }}</p>
                            @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                            {{ db_trans('mitra_label_address', 'Alamat Kantor / Domisili Instansi', 'Office / Institution Address') }}
                        </label>
                        <textarea id="address" name="address" rows="2" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="{{ db_trans('mitra_ph_address', 'Tuliskan alamat lengkap kantor atau lembaga Anda', 'Enter full office or institution address') }}">{{ old('address') }}</textarea>
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="proposal" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                            {{ db_trans('mitra_label_proposal', 'Rencana / Ide Kolaborasi yang Ingin Dijalankan', 'Collaboration Plan / Proposal') }}
                        </label>
                        <textarea id="proposal" name="proposal" rows="4" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-medium text-gray-800" placeholder="{{ db_trans('mitra_ph_proposal', 'Jelaskan bentuk kolaborasi, sasaran program, atau gagasan kemitraan bersama Yayasan LINTASAN...', 'Describe your intended collaboration, target programs, or partnership ideas...') }}">{{ old('proposal') }}</textarea>
                        @error('proposal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-brand-green text-white font-semibold py-3 rounded-lg hover:bg-brand-darkgreen shadow transition flex items-center justify-center gap-2">
                            <span>{{ db_trans('mitra_btn_submit', 'Kirim Pengajuan Kemitraan', 'Submit Partnership Application') }}</span>
                            <i class="fas fa-paper-plane text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
