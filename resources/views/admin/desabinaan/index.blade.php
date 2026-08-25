@extends('admin.layout.app')

@section('content')
<div class="space-y-6 text-xs">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Kelola Desa Mitra Lintasan</h1>
            <p class="text-xs text-gray-500 mt-1">Tambahkan, edit, atau hapus profil desa mitra lintasan dampingan Yayasan LINTASAN.</p>
        </div>
        <a href="{{ route('admin.villages.create') }}" class="bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition flex items-center gap-1.5">
            <i class="fas fa-plus"></i> Tambah Desa
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green rounded-lg p-4 text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-circle-check text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold uppercase">
                    <th class="p-3">Foto</th>
                    <th class="p-3">Nama Desa</th>
                    <th class="p-3">Lokasi</th>
                    <th class="p-3">Rangkuman</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($villages as $village)
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3">
                            <div class="w-12 h-12 rounded bg-gray-200 bg-cover bg-center shadow-sm" style="background-image: url('{{ $village->image_path }}');"></div>
                        </td>
                        <td class="p-3 font-semibold text-gray-800">{{ $village->name }}</td>
                        <td class="p-3 text-gray-600"><span class="bg-orange-50 text-brand-orange px-2 py-0.5 rounded font-bold uppercase text-[9px]"><i class="fas fa-location-dot text-[8px] mr-1"></i> {{ $village->location }}</span></td>
                        <td class="p-3 text-gray-500"><div class="line-clamp-1 max-w-[250px]">{{ $village->description }}</div></td>
                        <td class="p-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.villages.edit', $village->id) }}" class="text-blue-600 hover:text-blue-800 font-bold bg-blue-50 px-2 py-1 rounded transition text-[10px] flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.villages.destroy', $village->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus desa mitra lintasan ini?')" class="inline">
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
                        <td colspan="5" class="p-6 text-center text-gray-400">Belum ada desa mitra lintasan yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
