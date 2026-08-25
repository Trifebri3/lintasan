@extends('admin.layout.app')

@section('content')
<div class="bg-gray-50/50 min-h-screen text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 pb-5 border-b border-gray-200">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Kelola Galeri</h1>
                <p class="text-xs text-gray-500 mt-1">Tambahkan, edit, atau hapus dokumentasi foto dan video YouTube Yayasan LINTASAN.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition">
                    <i class="fas fa-plus"></i> Tambah Item Galeri
                </a>
            </div>
        </div>

        <!-- Notification Alerts -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm">
                <i class="fas fa-circle-check text-emerald-500 text-base mt-0.5"></i>
                <div class="font-semibold">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-150 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 font-bold uppercase text-[10px] tracking-wider border-b border-gray-150">
                            <th class="p-4 w-28">Preview</th>
                            <th class="p-4">Judul (Bilingual)</th>
                            <th class="p-4 w-32">Tipe</th>
                            <th class="p-4 w-24 text-center">Urutan</th>
                            <th class="p-4 w-36 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4">
                                    <div class="w-20 aspect-video rounded-lg bg-gray-100 overflow-hidden border border-gray-200 flex items-center justify-center relative">
                                        @if($item->type === 'image')
                                            <img src="{{ $item->image_path }}" alt="Preview" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/mqdefault.jpg" alt="Video Thumbnail" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/25">
                                                <i class="fas fa-play text-white text-[10px]"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-900 line-clamp-1 mb-1">{{ $item->title_id ?: 'Tanpa Judul (ID)' }}</div>
                                    <div class="text-[10px] text-gray-400 font-semibold italic line-clamp-1">{{ $item->title_en ?: 'No Title (EN)' }}</div>
                                </td>
                                <td class="p-4">
                                    @if($item->type === 'image')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-extrabold uppercase text-[9px] border border-emerald-100 shadow-sm">
                                            <i class="fas fa-camera text-[10px]"></i> Foto
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-700 font-extrabold uppercase text-[9px] border border-red-100 shadow-sm">
                                            <i class="fab fa-youtube text-[10px]"></i> Video
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center font-bold text-gray-900">
                                    {{ $item->sort_order }}
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit button -->
                                        <a href="{{ route('admin.galleries.edit', $item->id) }}" class="p-2 text-brand-green hover:bg-brand-green/5 rounded-lg transition" title="Edit Item">
                                            <i class="fas fa-pen-to-square text-sm"></i>
                                        </a>
                                        <!-- Delete button -->
                                        <form action="{{ route('admin.galleries.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item galeri ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Item">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-400 bg-white">
                                    <div class="text-4xl mb-3"><i class="fas fa-images"></i></div>
                                    <p class="font-semibold text-sm">Belum ada dokumentasi galeri yang terdaftar.</p>
                                    <a href="{{ route('admin.galleries.create') }}" class="inline-block mt-3 text-brand-green font-bold hover:underline">
                                        Tambah Dokumentasi Pertama Anda &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
