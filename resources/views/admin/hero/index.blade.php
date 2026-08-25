@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 leading-tight">Pengaturan Slide Hero Utama</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola gambar latar slideshow hero dan teks slogan multi-bahasa</p>
        </div>
        <a href="{{ route('admin.hero-images.create') }}" class="bg-brand-green hover:bg-brand-darkgreen text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow transition flex items-center gap-1.5">
            <i class="fas fa-plus"></i> Tambah Slide Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green p-4 rounded-xl text-xs font-semibold mb-6 shadow-sm">
            <i class="fas fa-circle-check mr-1.5"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden text-xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-150">
                <thead class="bg-gray-50 font-bold text-gray-700 uppercase tracking-wider text-left">
                    <tr>
                        <th class="px-6 py-4">Pratinjau Gambar</th>
                        <th class="px-6 py-4">Slogan (Bahasa Indonesia)</th>
                        <th class="px-6 py-4">Slogan (English)</th>
                        <th class="px-6 py-4">Urutan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-150 text-gray-600 bg-white">
                    @forelse($slides as $slide)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="w-24 h-14 rounded-lg bg-cover bg-center border border-gray-100 shadow-sm" style="background-image: url('{{ $slide->image_path }}');"></div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 max-w-xs truncate">
                                <div>{{ $slide->title_id }}</div>
                                <p class="text-[10px] text-gray-400 font-normal line-clamp-1 mt-1">{{ $slide->subtitle_id }}</p>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 max-w-xs truncate">
                                <div>{{ $slide->title_en }}</div>
                                <p class="text-[10px] text-gray-400 font-normal line-clamp-1 mt-1">{{ $slide->subtitle_en }}</p>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $slide->sort_order }}</td>
                            <td class="px-6 py-4">
                                @if($slide->is_active)
                                    <span class="bg-green-50 text-brand-green px-2.5 py-1 rounded-full text-[10px] font-bold border border-green-100 uppercase tracking-wider">Aktif</span>
                                @else
                                    <span class="bg-gray-100 text-gray-400 px-2.5 py-1 rounded-full text-[10px] font-bold border border-gray-200 uppercase tracking-wider">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-2 h-20">
                                <a href="{{ route('admin.hero-images.edit', $slide->id) }}" class="bg-brand-green hover:bg-brand-darkgreen text-white font-bold px-3 py-1.5 rounded transition shadow-sm flex items-center gap-1">
                                    <i class="fas fa-edit text-[10px]"></i> Edit
                                </a>
                                <form action="{{ route('admin.hero-images.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded border border-red-100 transition shadow-sm flex items-center gap-1">
                                        <i class="fas fa-trash-can text-[10px]"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada slide terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
