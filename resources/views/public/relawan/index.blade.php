@extends('public.layout.app')

@section('title', db_trans('meta_volunteer_title', 'Pendaftaran Relawan', 'Become a Volunteer') . ' - Yayasan LINTASAN')
@section('meta_description', db_trans('meta_volunteer_desc', 'Mari bergabung menjadi relawan Yayasan LINTASAN untuk memberikan aksi nyata dalam pemberdayaan masyarakat pesisir Indonesia.', 'Become a LINTASAN Volunteer. Join us and become part of real positive changes in Indonesian coastal communities.'))

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                {{ db_trans('volunteer_badge', 'Mari Bergabung', 'Get Involved') }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                {{ db_trans('volunteer_title', 'Menjadi Relawan LINTASAN', 'Become a LINTASAN Volunteer') }}
            </h1>
            <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
            <p class="text-gray-500 text-sm max-w-lg mx-auto mt-4 leading-relaxed">
                {{ db_trans('volunteer_desc', 'Isi formulir pendaftaran di bawah ini untuk bergabung bersama kami menjadi bagian dari perubahan nyata di pesisir Indonesia.', 'Fill out the form below to join us and become part of real positive changes in Indonesian coastal communities.') }}
            </p>
        </div>

        <!-- Signup Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-10 mb-16">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-brand-green rounded-lg p-4 mb-6 flex items-start gap-3 text-sm font-medium">
                    <i class="fas fa-circle-check text-lg mt-0.5"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('public.volunteer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                            {{ db_trans('volunteer_label_name', 'Nama Lengkap', 'Full Name') }}
                        </label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="{{ db_trans('volunteer_ph_name', 'Masukkan nama lengkap Anda', 'Enter your full name') }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                            {{ db_trans('volunteer_label_email', 'Alamat Email', 'Email Address') }}
                        </label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="contoh@domain.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                            {{ db_trans('volunteer_label_phone', 'Nomor Telepon / WhatsApp', 'Phone / WhatsApp Number') }}
                        </label>
                        <input type="text" id="phone" name="phone" required value="{{ old('phone') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="08xxxxxxxxxx">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="photo" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                            {{ db_trans('volunteer_label_photo', 'Foto Diri / Profil (Opsional)', 'Profile Photo (Optional)') }}
                        </label>
                        <input type="file" id="photo" name="photo" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                        <p class="text-[9px] text-gray-500 mt-1"><i class="fas fa-circle-info text-brand-green mr-1"></i> {{ db_trans('volunteer_photo_instruction', 'Format: JPG, JPEG, PNG. Maks: 2 MB. Otomatis dikompres.', 'Format: JPG, JPEG, PNG. Max: 2 MB. Compressed automatically.') }}</p>
                        @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        {{ db_trans('volunteer_label_address', 'Alamat Tinggal', 'Current Address') }}
                    </label>
                    <textarea id="address" name="address" rows="3" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="{{ db_trans('volunteer_ph_address', 'Tuliskan alamat tinggal lengkap Anda saat ini', 'Enter your current living address') }}">{{ old('address') }}</textarea>
                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="bio" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        {{ db_trans('volunteer_label_bio', 'Ceritakan, apa yang bisa kita kolaborasikan ?', 'What can we collaborate on?') }}
                    </label>
                    <textarea id="bio" name="bio" rows="4" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-medium text-gray-800" placeholder="{{ db_trans('volunteer_ph_bio', 'Tulis cerita singkat tentang diri Anda atau ide kolaborasi yang ingin Anda jalankan bersama Yayasan LINTASAN...', 'Tell us how you would like to collaborate or contribute...') }}">{{ old('bio') }}</textarea>
                    @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-brand-green text-white font-semibold py-3 rounded-lg hover:bg-brand-darkgreen shadow transition">
                        {{ db_trans('volunteer_btn_submit', 'Kirim Pendaftaran', 'Submit Registration') }} <i class="fas fa-paper-plane text-xs ml-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Active Volunteers Showcase Directory -->
        <div>
            <div class="text-center mb-10">
                <span class="text-brand-green font-bold text-xs uppercase tracking-wider block mb-2">
                    {{ db_trans('volunteer_active_badge', 'Relawan Aktif', 'Our Active Volunteers') }}
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3">
                    {{ db_trans('volunteer_active_title', 'Mereka yang Terlibat Nyata', 'They are Actively Involved') }}
                </h2>
                <div class="h-1 w-12 bg-brand-orange mx-auto rounded"></div>
                <p class="text-gray-500 text-xs sm:text-sm max-w-lg mx-auto mt-4 leading-relaxed font-medium">
                    {{ db_trans('volunteer_active_desc', 'Profil perwakilan relawan aktif yang mendampingi program pemberdayaan kami secara langsung di lapangan.', 'Profile directory of active volunteers supporting our coastal empowerment programs directly in the field.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @forelse($volunteers as $vol)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition duration-200">
                        <!-- Avatar -->
                        <div class="w-20 h-20 rounded-full bg-green-50 border border-green-100 overflow-hidden mb-4 shadow-inner flex items-center justify-center text-3xl font-extrabold text-brand-green shrink-0">
                            @if($vol->photo_path)
                                <img src="{{ $vol->photo_path }}" alt="{{ $vol->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($vol->name, 0, 1)) }}
                            @endif
                        </div>
                        <h3 class="font-extrabold text-sm text-gray-900 leading-tight mb-1">{{ $vol->name }}</h3>
                        <span class="bg-green-50 text-brand-green text-[9px] font-bold px-2.5 py-0.5 rounded-full border border-green-100">
                            {{ $vol->role }}
                        </span>
                        <p class="text-[11px] text-gray-500 mt-4 italic leading-relaxed">"{{ $vol->bio ?: $vol->motivation }}"</p>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-400 py-12 text-xs">
                        {{ db_trans('volunteer_active_empty', 'Belum ada profil relawan aktif yang ditampilkan.', 'No active volunteers displayed yet.') }}
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
