@extends('admin.layout.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.statistics.index') }}" class="text-xs text-gray-500 hover:text-brand-green flex items-center gap-1.5 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Statistik
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900 leading-tight mt-3">Edit Statistik Dampak</h1>
        <p class="text-xs text-gray-500 mt-1">Perbarui angka indikator, ikon, dan urutan tampilan</p>
    </div>

    <!-- Layout Grid 2 Kolom (Kiri: Form, Kanan: Live Preview) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Kolom Form (Kiri) -->
        <div class="md:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-6 sm:p-8">
            <form action="{{ route('admin.statistics.update', $statistic->id) }}" method="POST" class="space-y-5 text-xs">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-400 uppercase mb-2">Grup</label>
                        <input type="text" disabled value="{{ strtoupper(str_replace('_', ' ', $statistic->group)) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 outline-none font-bold text-gray-500">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-400 uppercase mb-2">Key</label>
                        <input type="text" disabled value="{{ $statistic->key }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 outline-none font-mono text-gray-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="value" class="block font-bold text-gray-700 uppercase mb-2">Nilai Angka (Value)</label>
                        <input type="text" id="value" name="value" required value="{{ old('value', $statistic->value) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-extrabold text-gray-900" placeholder="Contoh: 15+">
                        @error('value') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="icon" class="block font-bold text-gray-700 uppercase mb-2">Pilih Simbol Ikon Statistik</label>
                        <div class="flex items-center gap-3">
                            <select id="icon" name="icon" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white font-medium text-gray-800">
                                @php
                                    $currentIcon = old('icon', $statistic->icon);
                                @endphp
                                <option value="fa-home" {{ $currentIcon == 'fa-home' ? 'selected' : '' }}>Rumah (fa-home)</option>
                                <option value="fa-house-chimney" {{ $currentIcon == 'fa-house-chimney' ? 'selected' : '' }}>Rumah dengan Cerobong (fa-house-chimney)</option>
                                <option value="fa-users" {{ $currentIcon == 'fa-users' ? 'selected' : '' }}>Orang Banyak / Kelompok (fa-users)</option>
                                <option value="fa-user-group" {{ $currentIcon == 'fa-user-group' ? 'selected' : '' }}>Dua Orang / Relawan (fa-user-group)</option>
                                <option value="fa-handshake" {{ $currentIcon == 'fa-handshake' ? 'selected' : '' }}>Jabat Tangan / Mitra (fa-handshake)</option>
                                <option value="fa-tasks" {{ $currentIcon == 'fa-tasks' ? 'selected' : '' }}>Daftar Tugas / Program (fa-tasks)</option>
                                <option value="fa-school" {{ $currentIcon == 'fa-school' ? 'selected' : '' }}>Sekolah / Pendidikan (fa-school)</option>
                                <option value="fa-map-location-dot" {{ $currentIcon == 'fa-map-location-dot' ? 'selected' : '' }}>Peta & Pin Lokasi (fa-map-location-dot)</option>
                                <option value="fa-heart" {{ $currentIcon == 'fa-heart' ? 'selected' : '' }}>Jantung / Kasih Sayang (fa-heart)</option>
                                <option value="fa-tree" {{ $currentIcon == 'fa-tree' ? 'selected' : '' }}>Pohon / Lingkungan (fa-tree)</option>
                                <option value="fa-fish" {{ $currentIcon == 'fa-fish' ? 'selected' : '' }}>Ikan / Nelayan (fa-fish)</option>
                                <option value="fa-laptop-code" {{ $currentIcon == 'fa-laptop-code' ? 'selected' : '' }}>Komputer / Teknologi (fa-laptop-code)</option>
                            </select>
                            <div class="w-10 h-10 border border-gray-200 rounded-lg flex items-center justify-center bg-gray-50 text-gray-700 text-sm shrink-0">
                                <i id="icon-preview" class="fas {{ $currentIcon }}"></i>
                            </div>
                        </div>
                        @error('icon') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="label" class="block font-bold text-gray-700 uppercase mb-2">Label Indikator (Bahasa Indonesia)</label>
                    <input type="text" id="label" name="label" required value="{{ old('label', $statistic->label) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-semibold text-gray-800" placeholder="Contoh: Desa Dampingan">
                    @error('label') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    <p class="text-[10px] text-gray-400 mt-1 italic">Catatan: Versi Bahasa Inggris akan diterjemahkan secara otomatis di halaman publik berdasarkan kunci (key) parameter ini.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="color_class" class="block font-bold text-gray-700 uppercase mb-2">Pilih Warna Latar Belakang Kartu</label>
                        <select id="color_class" name="color_class" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white font-medium text-gray-800">
                            @php
                                $currentColor = old('color_class', $statistic->color_class);
                                $colorsMap = [
                                    'bg-gradient-to-br from-[#ff9966]/70 to-[#ff5e62]/70' => 'Jingga & Merah (Sunset)',
                                    'bg-gradient-to-br from-[#00c6ff]/70 to-[#0072ff]/70' => 'Biru Muda & Biru Tua (Ocean)',
                                    'bg-gradient-to-br from-[#f857a6]/70 to-[#ff5858]/70' => 'Merah Jambu & Rose',
                                    'bg-gradient-to-br from-[#11998e]/70 to-[#38ef7d]/70' => 'Hijau Toska & Emerald',
                                    'bg-gradient-to-br from-[#833ab4]/70 via-[#fd1d1d]/70 to-[#fcb045]/70' => 'Instagram Gradasi (Ungu & Oranye)',
                                    'bg-gradient-to-br from-[#da1b60]/70 to-[#ff8a00]/70' => 'Merah Tua & Gold',
                                    'bg-gradient-to-br from-[#134e5e]/70 to-[#71b280]/70' => 'Hijau Hutan (Forest Green)',
                                    'bg-gradient-to-br from-[#4e54c8]/70 to-[#8f94fb]/70' => 'Ungu Lavender',
                                ];
                                // If currently null, assign default based on index placeholder
                                if (!$currentColor) {
                                    $currentColor = array_keys($colorsMap)[0];
                                }
                            @endphp
                            @foreach($colorsMap as $val => $name)
                                <option value="{{ $val }}" {{ $currentColor == $val ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('color_class') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block font-bold text-gray-400 uppercase mb-2">Pratinjau Warna Kartu</label>
                        <div id="color-preview-box" class="w-full h-10 rounded-lg shadow-inner border border-gray-200 transition duration-300"></div>
                    </div>
                </div>

                <div>
                    <label for="sort_order" class="block font-bold text-gray-700 uppercase mb-2">Urutan Tampilan (Sort Order)</label>
                    <input type="number" id="sort_order" name="sort_order" required value="{{ old('sort_order', $statistic->sort_order) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-bold" placeholder="1, 2, 3...">
                    @error('sort_order') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.statistics.index') }}" class="bg-white border border-gray-200 hover:border-gray-300 text-gray-600 font-bold px-4 py-2.5 rounded transition">Batal</a>
                    <button type="submit" class="bg-brand-green hover:bg-brand-darkgreen text-white font-bold px-6 py-2.5 rounded shadow transition flex items-center gap-1">
                        <i class="fas fa-save"></i> Perbarui Statistik
                    </button>
                </div>
            </form>
        </div>

        <!-- Kolom Preview Real-time (Kanan) -->
        <div class="md:col-span-1 space-y-6">
            <!-- Desktop Layout Preview Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h2 class="text-[10px] font-extrabold text-gray-900 uppercase tracking-wider">Pratinjau Desktop</h2>
                    <span class="bg-blue-50 text-blue-600 border border-blue-100 font-extrabold text-[8px] px-2 py-0.5 rounded-full uppercase">Desktop Grid</span>
                </div>
                
                <div class="bg-gray-50 border border-gray-100 p-4 rounded-xl flex items-center justify-center min-h-[110px]">
                    <!-- Stats Card Preview (Mirrors home page layout) -->
                    <div class="flex items-center justify-start gap-3.5 p-4 bg-white rounded-xl shadow-md border border-gray-100 w-full">
                        <div id="preview-icon-container" class="p-3 text-white rounded-lg text-xl shadow-sm transition-all duration-300">
                            <i id="preview-icon" class="fas {{ $statistic->icon }}"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="text-base font-extrabold leading-tight text-gray-900">
                                <span id="preview-value">0</span>
                            </h3>
                            <p id="preview-label" class="text-[9px] text-gray-400 font-semibold uppercase tracking-wider mt-0.5 leading-none">LABEL</p>
                        </div>
                    </div>
                </div>
                <p class="text-[10px] text-gray-400 mt-2.5 leading-relaxed">
                    * Perubahan pada form sebelah kiri akan memperbarui kartu pratinjau di atas secara real-time.
                </p>
            </div>

            <!-- Mobile Layout Preview Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h2 class="text-[10px] font-extrabold text-gray-900 uppercase tracking-wider">Pratinjau HP (Mobile)</h2>
                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 font-extrabold text-[8px] px-2 py-0.5 rounded-full uppercase">Mobile Banner</span>
                </div>
                
                <div class="bg-[#0f172a] p-4 rounded-xl flex flex-col gap-3 border border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="inline-block bg-brand-green/15 text-brand-green border border-brand-green/25 px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider animate-pulse">
                            ARTIKEL TERBARU
                        </span>
                    </div>
                    <h4 class="text-[11px] font-bold text-white line-clamp-2 leading-snug">
                        {{ session('locale') == 'en' ? 'Latest Impact Story / Activity Article Title' : 'Mengangkat Perekonomian Nelayan Pesisir dengan Solar Freezer' }}
                    </h4>
                    <div class="bg-brand-green text-white text-[9px] font-bold py-2 px-3 rounded text-center cursor-not-allowed uppercase tracking-wider">
                        {{ session('locale') == 'en' ? 'READ MORE' : 'BACA SELENGKAPNYA' }}
                    </div>
                </div>
                <p class="text-[10px] text-emerald-600 bg-emerald-50/50 border border-emerald-100 rounded-lg p-2.5 mt-3 leading-relaxed">
                    <i class="fas fa-info-circle mr-1"></i> <strong>Catatan:</strong> Pada HP, seluruh data statistik disembunyikan dan digantikan oleh artikel & CTA ini.
                </p>
            </div>
        </div>

    </div>

    <!-- Live Preview Script -->
    <script>
        function updateColorPreview(val) {
            const preview = document.getElementById('color-preview-box');
            if (preview) {
                preview.className = 'w-full h-10 rounded-lg shadow-inner border border-gray-200 transition duration-300 ' + val;
            }
            
            const previewIconContainer = document.getElementById('preview-icon-container');
            if (previewIconContainer) {
                previewIconContainer.className = 'p-3 text-white rounded-lg text-xl shadow-sm transition-all duration-300 ' + val;
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const valueInput = document.getElementById('value');
            const labelInput = document.getElementById('label');
            const iconSelect = document.getElementById('icon');
            const colorSelect = document.getElementById('color_class');

            const previewValue = document.getElementById('preview-value');
            const previewLabel = document.getElementById('preview-label');
            const previewIcon = document.getElementById('preview-icon');

            function updateCardPreview() {
                if (previewValue && valueInput) {
                    previewValue.textContent = valueInput.value || '0+';
                }
                if (previewLabel && labelInput) {
                    previewLabel.textContent = labelInput.value || 'LABEL';
                }
                if (previewIcon && iconSelect) {
                    previewIcon.className = 'fas ' + iconSelect.value;
                }
            }

            if (valueInput) valueInput.addEventListener('input', updateCardPreview);
            if (labelInput) labelInput.addEventListener('input', updateCardPreview);
            
            if (iconSelect) {
                iconSelect.addEventListener('change', function() {
                    updateCardPreview();
                    const iconPreview = document.getElementById('icon-preview');
                    if (iconPreview) {
                        iconPreview.className = 'fas ' + this.value;
                    }
                });
            }
            
            if (colorSelect) {
                colorSelect.addEventListener('change', function() {
                    updateColorPreview(this.value);
                });
                updateColorPreview(colorSelect.value);
            }

            updateCardPreview();
        });
    </script>
@endsection
