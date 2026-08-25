@extends('admin.layout.app')

@section('content')
<div class="space-y-6 max-w-xl text-xs">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Tambah Mitra Kolaborasi</h1>
            <p class="text-xs text-gray-500 mt-1">Daftarkan logo lembaga mitra kolaborasi baru.</p>
        </div>
        <a href="{{ route('admin.partners.index') }}" class="text-gray-500 text-xs font-semibold hover:text-brand-green transition flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Instansi / Lembaga</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: BAZNAS">
                @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="logo_path" class="block text-xs font-bold text-gray-700 uppercase mb-2">Upload File Logo (Wajib)</label>
                <input type="file" id="logo_path" name="logo_path" required class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                <p class="text-[10px] text-gray-500 mt-1.5"><i class="fas fa-circle-info text-brand-green mr-1"></i> Format yang didukung: JPG, JPEG, PNG, GIF, SVG. Ukuran maksimal: 2 MB.</p>
                @error('logo_path') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="url" class="block text-xs font-bold text-gray-700 uppercase mb-2">Tautan URL Web Mitra (Opsional)</label>
                <input type="url" id="url" name="url" value="{{ old('url') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-mono" placeholder="Contoh: https://www.baznas.go.id">
                @error('url') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="sort_order" class="block text-xs font-bold text-gray-700 uppercase mb-2">Urutan Tampil (Sort Order)</label>
                <input type="number" id="sort_order" name="sort_order" required value="{{ old('sort_order', 1) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="1">
                @error('sort_order') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.partners.index') }}" class="border border-gray-200 text-gray-700 text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="bg-brand-green text-white text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">Simpan Mitra</button>
            </div>
        </form>
    </div>
</div>
@endsection
