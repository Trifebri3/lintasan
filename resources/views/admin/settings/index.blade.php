@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 leading-tight">Pengaturan Konten Halaman</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola teks visi, misi, pilar, profil yayasan, dan foto latar belakang secara real-time</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green p-4 rounded-xl text-xs font-semibold mb-6 shadow-sm">
            <i class="fas fa-circle-check mr-1.5"></i> {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        @foreach($settings as $setting)
            @php
                $instructions = [
                    'about_profile' => 'Tuliskan deskripsi singkat mengenai profil utama Yayasan LINTASAN yang akan tampil di bagian awal halaman Tentang Kami.',
                    'about_visi' => 'Tuliskan visi utama organisasi secara jelas dan inspiratif.',
                    'about_misi' => 'Tuliskan poin-poin misi organisasi. Gunakan tombol Enter (baris baru) untuk memisahkan setiap poin misi.',
                    'about_pillar_kolaborasi' => 'Jelaskan nilai kolaborasi lintas sektor yang dijalankan oleh Yayasan LINTASAN.',
                    'about_pillar_edukasi' => 'Jelaskan bagaimana Yayasan LINTASAN memberikan pembekalan kesiapsiagaan dan keahlian.',
                    'about_pillar_inovasi' => 'Jelaskan inovasi tepat guna (seperti solar freezer / energi surya) yang diaplikasikan.',
                    'about_pillar_transparansi' => 'Jelaskan komitmen keterbukaan informasi dan akuntabilitas pelaporan program.',
                    'about_conclusion' => 'Tuliskan paragraf kesimpulan penutup untuk profil tentang kami.',
                    'title_impact' => 'Tuliskan judul bagian statistik dampak yang akan tampil di halaman beranda (contoh: Sebaran Wilayah Binaan).',
                    'bg_photo_impact' => 'Upload foto latar belakang untuk bagian statistik dampak pesisir. Rekomendasi dimensi: 1920x1080px (Lansekap), format JPG/PNG, ukuran file maks 3MB.',
                    'bg_photo_cta' => 'Upload foto latar belakang untuk banner ajakan gabung di footer. Rekomendasi dimensi: 1920x800px (Lansekap), format JPG/PNG, ukuran file maks 3MB.',
                ];
                $helpText = $instructions[$setting->key] ?? 'Kelola konten ini sesuai dengan kebutuhan tata letak web publik.';
            @endphp
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gray-50 border-b border-gray-150 px-6 py-4 flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <i class="fas fa-file-invoice text-brand-green mr-1"></i> {{ str_replace('_', ' ', $setting->key) }}
                    </span>
                    <span class="text-[9px] font-semibold text-gray-400 capitalize px-2 py-0.5 bg-gray-100 rounded border border-gray-200">{{ $setting->type }}</span>
                </div>

                <!-- Helper Instructions Banner -->
                <div class="px-6 py-2.5 text-[10px] text-gray-500 bg-green-50/20 border-b border-gray-100 flex items-start gap-1.5">
                    <i class="fas fa-circle-info text-brand-green mt-0.5 shrink-0"></i>
                    <span><strong>Petunjuk:</strong> {{ $helpText }}</span>
                </div>

                <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Indonesian value -->
                        <div>
                            <label class="block font-bold text-gray-700 uppercase mb-2 flex items-center gap-1.5">
                                <span class="bg-red-50 text-red-600 text-[9px] px-1.5 py-0.5 rounded font-extrabold border border-red-100">ID</span> Versi Bahasa Indonesia
                            </label>
                            @if($setting->type == 'image')
                                @if($setting->value_id)
                                    <div class="mb-3">
                                        <div class="w-48 h-32 rounded-lg bg-gray-200 bg-cover bg-center border border-gray-150 shadow-sm" style="background-image: url('{{ $setting->value_id }}');"></div>
                                    </div>
                                @endif
                                <input type="file" name="value_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                            @elseif($setting->type == 'textarea')
                                <textarea name="value_id" required rows="4" class="setting-editor w-full border border-gray-200 rounded-lg p-3 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition leading-relaxed">{{ $setting->value_id }}</textarea>
                            @elseif($setting->type == 'boolean')
                                <select name="value_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-semibold text-gray-800 bg-white">
                                    <option value="1" {{ $setting->value_id == '1' ? 'selected' : '' }}>Tampilkan (Aktif)</option>
                                    <option value="0" {{ $setting->value_id == '0' ? 'selected' : '' }}>Sembunyikan (Nonaktif)</option>
                                </select>
                            @else
                                <input type="text" name="value_id" required value="{{ $setting->value_id }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition">
                            @endif
                        </div>

                        <!-- English value -->
                        <div>
                            <label class="block font-bold text-gray-700 uppercase mb-2 flex items-center gap-1.5">
                                <span class="bg-blue-50 text-blue-600 text-[9px] px-1.5 py-0.5 rounded font-extrabold border border-blue-100">EN</span> Versi Bahasa Inggris
                            </label>
                            @if($setting->type == 'image')
                                @if($setting->value_en)
                                    <div class="mb-3">
                                        <div class="w-48 h-32 rounded-lg bg-gray-200 bg-cover bg-center border border-gray-150 shadow-sm" style="background-image: url('{{ $setting->value_en }}');"></div>
                                    </div>
                                @endif
                                <input type="file" name="value_en" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                            @elseif($setting->type == 'textarea')
                                <textarea name="value_en" required rows="4" class="setting-editor w-full border border-gray-200 rounded-lg p-3 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition leading-relaxed">{{ $setting->value_en }}</textarea>
                            @elseif($setting->type == 'boolean')
                                <select name="value_en" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-semibold text-gray-800 bg-white">
                                    <option value="1" {{ $setting->value_en == '1' ? 'selected' : '' }}>Show (Active)</option>
                                    <option value="0" {{ $setting->value_en == '0' ? 'selected' : '' }}>Hide (Inactive)</option>
                                </select>
                            @else
                                <input type="text" name="value_en" required value="{{ $setting->value_en }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition">
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end pt-2 border-t border-gray-50">
                        <button type="submit" class="bg-brand-green hover:bg-brand-darkgreen text-white font-bold px-4 py-2 rounded shadow transition flex items-center gap-1.5">
                            <i class="fas fa-save text-[10px]"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '.setting-editor',
            height: 250,
            menubar: 'edit insert format table help',
            plugins: 'advlist autolink lists link charmap preview anchor searchreplace code table wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table',
            content_style: 'body { font-family: "Instrument Sans", sans-serif; font-size: 13px; line-height: 1.6; color: #374151; }',
            branding: false,
            promotion: false,
            setup: function(editor) {
                // Synchronize TinyMCE contents back to textarea on keyup/change for form validation
                editor.on('change keyup', function() {
                    editor.save();
                });
            }
        });
    });
</script>
@endsection
