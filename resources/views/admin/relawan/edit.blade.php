@extends('admin.layout.app')

@section('content')
<div class="space-y-6 max-w-2xl text-xs">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Edit Relawan</h1>
            <p class="text-xs text-gray-500 mt-1">Ubah peran, status, atau rincian profil relawan.</p>
        </div>
        <a href="{{ route('admin.volunteers.index') }}" class="text-gray-500 text-xs font-semibold hover:text-brand-green transition flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.volunteers.update', $volunteer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required value="{{ old('name', $volunteer->name) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Andi Wijaya">
                    @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-2">Alamat Email</label>
                    <input type="email" id="email" name="email" required value="{{ old('email', $volunteer->email) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="andi@domain.com">
                    @error('email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-xs font-bold text-gray-700 uppercase mb-2">Telepon / WhatsApp</label>
                    <input type="text" id="phone" name="phone" required value="{{ old('phone', $volunteer->phone) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="08xxxxxxxxxx">
                    @error('phone') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="role" class="block text-xs font-bold text-gray-700 uppercase mb-2">Peran / Posisi Relawan</label>
                    <input type="text" id="role" name="role" required value="{{ old('role', $volunteer->role) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Koordinator SPAB">
                    @error('role') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase mb-2">Status Tampilan</label>
                    <select id="status" name="status" required class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white">
                        <option value="aktif" {{ $volunteer->status == 'aktif' ? 'selected' : '' }}>Aktif (Tampilkan di direktori publik)</option>
                        <option value="pending" {{ $volunteer->status == 'pending' ? 'selected' : '' }}>Pending (Review / Simpan di admin saja)</option>
                    </select>
                    @error('status') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Foto Saat Ini</label>
                    <div class="w-12 h-12 rounded-full bg-green-50 overflow-hidden flex items-center justify-center font-extrabold text-brand-green mb-2 shadow-inner">
                        @if($volunteer->photo_path)
                            <img src="{{ $volunteer->photo_path }}" alt="{{ $volunteer->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($volunteer->name, 0, 1)) }}
                        @endif
                    </div>
                    
                    <label for="photo_path" class="block text-xs font-bold text-gray-700 uppercase mb-2">Ganti Foto Profil (Avatar)</label>
                    <input type="file" id="photo_path" name="photo_path" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                    @error('photo_path') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-bold text-gray-700 uppercase mb-2">Alamat Asal</label>
                <input type="text" id="address" name="address" required value="{{ old('address', $volunteer->address) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Bandung, Jawa Barat">
                @error('address') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="motivation" class="block text-xs font-bold text-gray-700 uppercase mb-2">Pernyataan Motivasi / Kutipan</label>
                <textarea id="motivation" name="motivation" rows="3" required class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tuliskan motivasi singkat atau kutipan/quote relawan...">{{ old('motivation', $volunteer->motivation) }}</textarea>
                @error('motivation') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="bio" class="block text-xs font-bold text-gray-700 uppercase mb-2">Cerita Diri (Bio / Tentang Anda)</label>
                <textarea id="bio" name="bio" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tuliskan cerita diri lengkap relawan di sini...">{{ old('bio', $volunteer->bio) }}</textarea>
                @error('bio') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.volunteers.index') }}" class="border border-gray-200 text-gray-700 text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="bg-brand-green text-white text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
