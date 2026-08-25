@extends('admin.layout.app')

@section('content')
<div class="space-y-6 text-xs">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Kelola Mitra Kolaborasi</h1>
            <p class="text-xs text-gray-500 mt-1">Tambahkan, edit, atau hapus mitra resmi Yayasan LINTASAN.</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition flex items-center gap-1.5">
            <i class="fas fa-plus"></i> Tambah Mitra
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
                <tr class="bg-gray-55 border-b border-gray-100 text-gray-500 font-bold uppercase">
                    <th class="p-3">Icon Mitra</th>
                    <th class="p-3">Nama Lembaga / Instansi</th>
                    <th class="p-3">Tautan URL</th>
                    <th class="p-3">Urutan Tampil</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($partners as $partner)
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3">
                            @if($partner->logo_path)
                                <div class="w-10 h-10 rounded bg-gray-50 flex items-center justify-center border border-gray-100 p-1 shadow-sm">
                                    <img src="{{ $partner->logo_path }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-lg text-brand-green shadow-sm">
                                    <i class="fas {{ $partner->logo_icon }}"></i>
                                </div>
                            @endif
                        </td>
                        <td class="p-3 font-semibold text-gray-800">{{ $partner->name }}</td>
                        <td class="p-3">
                            @if($partner->url)
                                <a href="{{ $partner->url }}" target="_blank" class="text-brand-green hover:underline font-mono text-[10px]">{{ $partner->url }} <i class="fas fa-external-link text-[8px] ml-0.5"></i></a>
                            @else
                                <span class="text-gray-400 font-mono text-[10px]">-</span>
                            @endif
                        </td>
                        <td class="p-3 text-gray-600 font-mono">{{ $partner->sort_order }}</td>
                        <td class="p-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.partners.edit', $partner->id) }}" class="text-blue-600 hover:text-blue-800 font-bold bg-blue-50 px-2 py-1 rounded transition text-[10px] flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')" class="inline">
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
                        <td colspan="4" class="p-6 text-center text-gray-400">Belum ada mitra kolaborasi yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
