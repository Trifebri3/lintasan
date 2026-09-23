@php
    $cardLabel = $meta['label'] ?? ucwords(str_replace('_', ' ', $setting->key));
    $cardIcon = $meta['icon'] ?? 'fa-file-lines';
    $cardLocation = $meta['location'] ?? 'Konten Publik';
    $cardHelp = $meta['help'] ?? 'Sesuaikan nilai pengaturan sesuai kebutuhan.';
    $cardRows = $meta['rows'] ?? 3;
    $inputType = $meta['type'] ?? $setting->type;
@endphp

<div class="setting-item-card bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden transition-all duration-200 hover:border-brand-green/40 hover:shadow-md" data-setting-key="{{ $setting->key }}">
    <!-- Card Header -->
    <div class="bg-gray-50 border-b border-gray-150 px-5 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-brand-green border border-emerald-200 flex items-center justify-center text-xs shrink-0">
                <i class="fas {{ $cardIcon }}"></i>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-900 leading-snug">{{ $cardLabel }}</h3>
                <span class="text-[10px] text-gray-400 font-mono">key: {{ $setting->key }}</span>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="text-[9px] font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 flex items-center gap-1">
                <i class="fas fa-location-dot text-[8px] text-emerald-600"></i> {{ $cardLocation }}
            </span>
            <span class="text-[9px] font-mono uppercase text-gray-400 px-1.5 py-0.5 bg-gray-100 rounded border border-gray-200">{{ $setting->type }}</span>
        </div>
    </div>

    <!-- Instruction Helper Banner -->
    <div class="px-5 py-2 text-[11px] text-gray-600 bg-amber-50/20 border-b border-gray-100 flex items-start gap-2">
        <i class="fas fa-circle-info text-brand-orange mt-0.5 shrink-0 text-xs"></i>
        <span><strong>Panduan:</strong> {{ $cardHelp }}</span>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data" onsubmit="if(window.tinymce){tinymce.triggerSave();}" class="p-5 space-y-4 text-xs">
        @csrf
        @method('PUT')
        <input type="hidden" name="active_tab" value="{{ $catId ?? 'profil' }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Bahasa Indonesia Column -->
            <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-200/70 space-y-2">
                <label class="block font-bold text-gray-800 uppercase text-[11px] flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <span class="bg-red-50 text-red-600 text-[9px] px-1.5 py-0.5 rounded font-extrabold border border-red-200">ID</span>
                        <span>Versi Bahasa Indonesia</span>
                    </span>
                    <span class="text-[9px] text-gray-400 font-normal lowercase">(Wajib diisi)</span>
                </label>

                @if($setting->type == 'image' || $inputType == 'image')
                    @if($setting->value_id)
                        <div class="relative group w-fit">
                            <div class="w-48 h-28 rounded-lg bg-gray-200 bg-cover bg-center border border-gray-200 shadow-sm" style="background-image: url('{{ $setting->value_id }}');"></div>
                            <a href="{{ $setting->value_id }}" target="_blank" class="absolute inset-0 bg-black/40 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition text-[10px] font-bold gap-1">
                                <i class="fas fa-eye"></i> Lihat Foto
                            </a>
                        </div>
                    @endif
                    <input type="file" name="value_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-3 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100 bg-white">
                @elseif($setting->type == 'textarea' || $inputType == 'textarea')
                    <textarea id="editor_{{ $setting->id }}_id" name="value_id" required rows="{{ $cardRows }}" class="setting-editor w-full border border-gray-200 rounded-lg p-3 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition leading-relaxed bg-white" placeholder="Isikan konten dalam Bahasa Indonesia...">{{ $setting->value_id }}</textarea>
                @elseif($setting->type == 'boolean' || $inputType == 'boolean')
                    <select name="value_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-semibold text-gray-800 bg-white">
                        <option value="1" {{ $setting->value_id == '1' ? 'selected' : '' }}>Tampilkan (Aktif)</option>
                        <option value="0" {{ $setting->value_id == '0' ? 'selected' : '' }}>Sembunyikan (Nonaktif)</option>
                    </select>
                @else
                    <input type="text" name="value_id" required value="{{ $setting->value_id }}" class="w-full border border-gray-200 rounded-lg px-3.5 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white" placeholder="Isikan teks dalam Bahasa Indonesia...">
                @endif

                @error('value_id')
                    <p class="text-red-500 text-[10px] font-semibold"><i class="fas fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- English Column -->
            <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-200/70 space-y-2">
                <label class="block font-bold text-gray-800 uppercase text-[11px] flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <span class="bg-blue-50 text-blue-600 text-[9px] px-1.5 py-0.5 rounded font-extrabold border border-blue-200">EN</span>
                        <span>English Translation</span>
                    </span>
                    <span class="text-[9px] text-gray-400 font-normal lowercase">(Terjemahan Inggris)</span>
                </label>

                @if($setting->type == 'image' || $inputType == 'image')
                    @if($setting->value_en)
                        <div class="relative group w-fit">
                            <div class="w-48 h-28 rounded-lg bg-gray-200 bg-cover bg-center border border-gray-200 shadow-sm" style="background-image: url('{{ $setting->value_en }}');"></div>
                            <a href="{{ $setting->value_en }}" target="_blank" class="absolute inset-0 bg-black/40 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition text-[10px] font-bold gap-1">
                                <i class="fas fa-eye"></i> Lihat Foto
                            </a>
                        </div>
                    @endif
                    <input type="file" name="value_en" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition file:mr-3 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 bg-white">
                @elseif($setting->type == 'textarea' || $inputType == 'textarea')
                    <textarea id="editor_{{ $setting->id }}_en" name="value_en" required rows="{{ $cardRows }}" class="setting-editor w-full border border-gray-200 rounded-lg p-3 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition leading-relaxed bg-white" placeholder="Write translation in English...">{{ $setting->value_en }}</textarea>
                @elseif($setting->type == 'boolean' || $inputType == 'boolean')
                    <select name="value_en" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition font-semibold text-gray-800 bg-white">
                        <option value="1" {{ $setting->value_en == '1' ? 'selected' : '' }}>Show (Active)</option>
                        <option value="0" {{ $setting->value_en == '0' ? 'selected' : '' }}>Hide (Inactive)</option>
                    </select>
                @else
                    <input type="text" name="value_en" required value="{{ $setting->value_en }}" class="w-full border border-gray-200 rounded-lg px-3.5 py-2 text-xs focus:border-brand-green focus:ring-1 focus:ring-brand-green outline-none transition bg-white" placeholder="Write text in English...">
                @endif

                @error('value_en')
                    <p class="text-red-500 text-[10px] font-semibold"><i class="fas fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button Footer -->
        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
            <span class="text-[10px] text-gray-400">
                <i class="fas fa-clock text-[9px] mr-0.5"></i> Terakhir diubah: {{ $setting->updated_at ? $setting->updated_at->diffForHumans() : '-' }}
            </span>
            <button type="submit" class="bg-brand-green hover:bg-brand-darkgreen text-white font-bold text-xs px-4 py-2 rounded-lg shadow-sm hover:shadow transition flex items-center gap-1.5 cursor-pointer">
                <i class="fas fa-floppy-disk text-xs"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
