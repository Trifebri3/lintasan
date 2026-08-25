@extends('admin.layout.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Kelola Cerita Lapangan</h1>
            <p class="text-xs text-gray-500 mt-1">Tambahkan, edit, atau hapus kisah lapangan Yayasan LINTASAN.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.stories.template') }}" class="bg-white border border-gray-200 text-gray-655 hover:border-gray-300 hover:bg-gray-50 text-[10px] sm:text-xs font-bold px-3 py-2.5 rounded-lg transition flex items-center gap-1 shadow-sm">
                <i class="fas fa-download"></i> Unduh Template
            </a>
            <a href="{{ route('admin.stories.export') }}" class="bg-white border border-gray-200 text-gray-655 hover:border-gray-300 hover:bg-gray-50 text-[10px] sm:text-xs font-bold px-3 py-2.5 rounded-lg transition flex items-center gap-1 shadow-sm">
                <i class="fas fa-file-export"></i> Ekspor Excel
            </a>
            <button onclick="toggleImportModal(true)" class="bg-white border border-gray-200 text-gray-655 hover:border-gray-300 hover:bg-gray-50 text-[10px] sm:text-xs font-bold px-3 py-2.5 rounded-lg transition flex items-center gap-1 shadow-sm">
                <i class="fas fa-file-import"></i> Impor Excel
            </button>
            <a href="{{ route('admin.stories.create') }}" class="bg-brand-green text-white text-[10px] sm:text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow-sm transition flex items-center gap-1.5">
                <i class="fas fa-plus"></i> Tambah Cerita
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green rounded-lg p-4 text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-circle-check text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Stories -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold uppercase">
                        <th class="p-3">Foto</th>
                        <th class="p-3">Judul</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Statistik Dampak</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($stories as $story)
                        <tr class="hover:bg-gray-50/50">
                            <td class="p-3">
                                <div class="w-12 h-12 rounded bg-gray-200 bg-cover bg-center shadow-sm" style="background-image: url('{{ $story->image_url }}');"></div>
                            </td>
                            <td class="p-3 font-semibold text-gray-800">
                                <div>{{ $story->title }}</div>
                                <div class="text-[10px] text-gray-400 font-normal line-clamp-1 max-w-[300px] mt-1">{{ $story->description }}</div>
                            </td>
                            <td class="p-3">
                                <span class="{{ $story->category_bg }} {{ $story->category_color }} text-[9px] font-extrabold px-2 py-0.5 rounded uppercase">
                                    {{ $story->category }}
                                </span>
                            </td>
                            <td class="p-3">
                                @if($story->impact_number)
                                    <div class="font-bold text-brand-green">{{ $story->impact_number }}</div>
                                    <div class="text-[10px] text-gray-500">{{ $story->impact_label }}</div>
                                @else
                                    <span class="text-gray-400 italic text-[10px]">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-3 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.stories.edit', $story->id) }}" class="text-blue-600 hover:text-blue-800 font-bold bg-blue-50 px-2 py-1 rounded transition text-[10px] flex items-center gap-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold bg-red-50 px-2 py-1 rounded transition text-[10px] flex items-center gap-1">
                                            <i class="fas fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400">Belum ada cerita lapangan yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Import Excel Modal -->
<div id="import-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-550/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="toggleImportModal(false)"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-middle bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 p-6">
            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                <h3 class="text-base font-extrabold text-gray-900" id="modal-title">Impor Cerita Lapangan via Excel/CSV</h3>
                <button onclick="toggleImportModal(false)" class="text-gray-400 hover:text-gray-650 text-lg"><i class="fas fa-xmark"></i></button>
            </div>
            
            <form action="{{ route('admin.stories.import') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih File Spreadsheet (CSV)</label>
                    <input type="file" name="file" required accept=".csv,.txt" class="w-full border border-gray-200 rounded-lg p-2.5 outline-none focus:border-brand-green text-xs file:mr-4 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-green-50 file:text-brand-green hover:file:bg-green-100">
                    <p class="text-[10px] text-gray-400 mt-2 leading-relaxed">Pastikan file menggunakan format/template yang sudah diunduh. Kolom 'title_id' wajib diisi.</p>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-2 text-xs font-bold">
                    <button type="button" onclick="toggleImportModal(false)" class="border border-gray-200 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg transition">Batal</button>
                    <button type="submit" class="bg-brand-green text-white hover:bg-brand-darkgreen px-5 py-2 rounded-lg shadow transition">Mulai Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleImportModal(show) {
        const modal = document.getElementById('import-modal');
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>
@endsection
