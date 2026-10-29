@extends('admin.layout.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Tambah Figur Baru</h1>
            <p class="text-xs text-gray-500 mt-1">Tambahkan profil pendiri, pembina, pengawas, pengurus, atau tim pelaksana Yayasan LINTASAN.</p>
        </div>
        <a href="{{ route('admin.people.index') }}" class="text-gray-500 hover:text-gray-700 text-xs font-bold flex items-center gap-1 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs font-semibold mb-6 shadow-sm">
            <div class="font-bold text-sm mb-1 flex items-center gap-1">
                <i class="fas fa-triangle-exclamation"></i> Periksa Isian Formulir:
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.people.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf

            <!-- Nama & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Nama Lengkap & Gelar <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Dr. Ir. H. Ahmad Sudrajat, M.Sc.">
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Kategori Struktur Organisasi <span class="text-red-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none bg-white transition">
                        @foreach($categories as $catKey => $catInfo)
                            <option value="{{ $catKey }}" {{ old('category') === $catKey ? 'selected' : '' }}>
                                {{ $catInfo['id'] }} ({{ $catInfo['en'] }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Peran ID & Peran EN -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="role_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Jabatan / Peran (Bahasa Indonesia) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="role_id" name="role_id" required value="{{ old('role_id') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Ketua Dewan Pembina / Ketua Umum Yayasan">
                </div>

                <div>
                    <label for="role_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Jabatan / Peran (English Translation)
                    </label>
                    <input type="text" id="role_en" name="role_en" value="{{ old('role_en') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Chairman of the Advisory Board / Executive Director">
                </div>
            </div>

            <!-- Foto & Urutan & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="photo" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Foto Profil (Portrait Avatar)
                    </label>
                    <input type="file" id="photo" name="photo" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none file:mr-3 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100 transition">
                    <p class="text-[9px] text-gray-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maks 4 MB. Otomatis dikompres.</p>
                </div>

                <div>
                    <label for="sort_order" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Urutan Tampil (Sort Order) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="sort_order" name="sort_order" required value="{{ old('sort_order', 1) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition">
                    <p class="text-[9px] text-gray-400 mt-1">Angka lebih kecil tampil lebih awal di halaman.</p>
                </div>

                <div>
                    <label for="is_active" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Status Publikasi <span class="text-red-500">*</span>
                    </label>
                    <select id="is_active" name="is_active" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none bg-white transition">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Tampilkan (Aktif)</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Sembunyikan (Nonaktif)</option>
                    </select>
                </div>
            </div>

            <!-- Kontak & Jejaring -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="social_linkedin" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Tautan Profil LinkedIn (Opsional)
                    </label>
                    <input type="url" id="social_linkedin" name="social_linkedin" value="{{ old('social_linkedin') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="https://linkedin.com/in/username">
                </div>

                <div>
                    <label for="social_email" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                        Alamat Email Resmi (Opsional)
                    </label>
                    <input type="email" id="social_email" name="social_email" value="{{ old('social_email') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="nama@lintasan.or.id">
                </div>
            </div>

            <!-- Bio ID -->
            <div>
                <label for="bio_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                    Biografi / Riwayat Singkat (Bahasa Indonesia)
                </label>
                <textarea id="bio_id" name="bio_id" rows="4" class="w-full border border-gray-200 rounded-lg p-3 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tuliskan latar belakang keahlian, riwayat pengabdian, atau rekam jejak di bidang pemberdayaan pesisir...">{{ old('bio_id') }}</textarea>
            </div>

            <!-- Bio EN -->
            <div>
                <label for="bio_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">
                    Biografi / Riwayat Singkat (English Translation)
                </label>
                <textarea id="bio_en" name="bio_en" rows="4" class="w-full border border-gray-200 rounded-lg p-3 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Write profile summary, background, and expertise in English...">{{ old('bio_en') }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.people.index') }}" class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-600 font-bold hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-brand-green text-white font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition flex items-center gap-1.5">
                    <i class="fas fa-save"></i> Simpan Figur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

