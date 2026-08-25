@extends('admin.layout.app')

@section('content')
<div class="space-y-6 max-w-3xl text-xs">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Edit Desa Mitra Lintasan</h1>
            <p class="text-xs text-gray-500 mt-1">Ubah data profil desa mitra lintasan dampingan Yayasan LINTASAN.</p>
        </div>
        <a href="{{ route('admin.villages.index') }}" class="text-gray-500 text-xs font-semibold hover:text-brand-green transition flex items-center gap-1.5">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.villages.update', $village->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Desa</label>
                    <input type="text" id="name" name="name" required value="{{ old('name', $village->name) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Desa Cijayana">
                    @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="location" class="block text-xs font-bold text-gray-700 uppercase mb-2">Lokasi / Kabupaten</label>
                    <input type="text" id="location" name="location" required value="{{ old('location', $village->location) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: Garut, Jawa Barat">
                    @error('location') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Foto Saat Ini</label>
                <div class="w-48 h-32 rounded-lg bg-gray-200 bg-cover bg-center mb-3 shadow-sm" style="background-image: url('{{ $village->image_path }}');"></div>
                
                <label for="image_path" class="block text-xs font-bold text-gray-700 uppercase mb-2">Ganti Foto Utama (Kosongkan jika tidak diganti)</label>
                <input type="file" id="image_path" name="image_path" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                @error('image_path') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-gray-700 uppercase mb-2">Rangkuman Singkat (Tampilan Depan)</label>
                <textarea id="description" name="description" rows="2" required class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tuliskan 1-2 kalimat rangkuman singkat untuk halaman utama atau katalog desa">{{ old('description', $village->description) }}</textarea>
                @error('description') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                <div>
                    <label for="latitude" class="block text-xs font-bold text-gray-700 uppercase mb-1">Titik Lintang Peta / Latitude (Opsional)</label>
                    <span class="block text-[10px] text-gray-400 mb-2">Koordinat utara/selatan (contoh: -7.508545) untuk menampilkan pin lokasi desa di peta utama.</span>
                    <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $village->latitude) }}" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: -7.50854498">
                    @error('latitude') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="longitude" class="block text-xs font-bold text-gray-700 uppercase mb-1">Titik Bujur Peta / Longitude (Opsional)</label>
                    <span class="block text-[10px] text-gray-400 mb-2">Koordinat barat/timur (contoh: 107.697475) untuk menentukan posisi tepat di peta utama.</span>
                    <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $village->longitude) }}" class="w-full bg-white border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Contoh: 107.69747514">
                    @error('longitude') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="narrative" class="block text-xs font-bold text-gray-700 uppercase mb-2">Kisah Lengkap & Perkembangan Desa Mitra Lintasan</label>
                <textarea id="narrative" name="narrative" rows="10" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition" placeholder="Tulis kisah unik lengkap, program pemberdayaan, narasi cerita perkembangan masyarakat desa mitra lintasan di sini...">{{ old('narrative', $village->narrative) }}</textarea>
                @error('narrative') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.villages.index') }}" class="border border-gray-200 text-gray-700 text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="bg-brand-green text-white text-xs font-bold px-6 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TinyMCE
        tinymce.init({
            selector: '#narrative',
            height: 350,
            menubar: 'edit insert format table help',
            plugins: 'advlist autolink lists link charmap preview anchor searchreplace code table wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table',
            content_style: 'body { font-family: "Instrument Sans", sans-serif; font-size: 13px; line-height: 1.6; color: #374151; }',
            branding: false,
            promotion: false,
            setup: function(editor) {
                editor.on('change keyup', function() {
                    editor.save();
                });
            }
        });
    });
</script>
@endsection
