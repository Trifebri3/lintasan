@extends('admin.layout.app')

@section('content')
<div class="space-y-6 max-w-xl text-xs">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Tambah Media Sosial Baru</h1>
            <p class="text-xs text-gray-500 mt-1">Daftarkan akun atau tautan media sosial resmi yayasan.</p>
        </div>
        <a href="{{ route('admin.social-links.index') }}" class="text-gray-500 text-xs font-semibold hover:text-brand-green transition flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.social-links.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="platform" class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih Platform Media Sosial</label>
                    <select id="platform" name="platform" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white font-medium text-gray-800">
                        <option value="instagram">Instagram</option>
                        <option value="youtube">YouTube</option>
                        <option value="facebook">Facebook</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="twitter">X / Twitter</option>
                        <option value="tiktok">TikTok</option>
                        <option value="other">Lainnya / Website</option>
                    </select>
                    @error('platform') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Akun / Label</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-semibold" placeholder="Contoh: @senyum_anaknegeri">
                    @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="url" class="block text-xs font-bold text-gray-700 uppercase mb-2">Tautan URL Lengkap</label>
                <input type="url" id="url" name="url" required value="{{ old('url') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-mono" placeholder="Contoh: https://www.instagram.com/senyum_anaknegeri/">
                @error('url') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description_id" class="block text-xs font-bold text-gray-700 uppercase mb-2">Deskripsi Singkat (Bahasa Indonesia)</label>
                <input type="text" id="description_id" name="description_id" value="{{ old('description_id') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Ikuti foto kegiatan dan Reels lapangan kami.">
                @error('description_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description_en" class="block text-xs font-bold text-gray-700 uppercase mb-2">Deskripsi Singkat (Bahasa Inggris)</label>
                <input type="text" id="description_en" name="description_en" value="{{ old('description_en') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Follow our field updates and photo logs.">
                @error('description_en') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-gray-700 uppercase mb-2">Urutan Tampil (Sort Order)</label>
                    <input type="number" id="sort_order" name="sort_order" required value="{{ old('sort_order', 1) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-bold" placeholder="1">
                    @error('sort_order') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Status Publikasi</label>
                    <label class="flex items-center gap-2 mt-2 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-brand-green border-gray-200 rounded focus:ring-brand-green/20">
                        <span class="font-bold text-gray-700">Tampilkan Secara Publik</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-50 flex justify-end gap-3">
                <a href="{{ route('admin.social-links.index') }}" class="border border-gray-200 text-gray-700 text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="bg-brand-green text-white text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">Simpan Media</button>
            </div>
        </form>
    </div>
</div>
@endsection
