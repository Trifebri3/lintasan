@extends('admin.layout.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Pendaftaran & Direktori Relawan</h1>
            <p class="text-xs text-gray-500 mt-1">Daftar calon relawan dari formulir website, serta pengelolaan manual direktori relawan aktif.</p>
        </div>
        <a href="{{ route('admin.volunteers.create') }}" class="bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition flex items-center gap-1.5">
            <i class="fas fa-plus"></i> Tambah Relawan Manual
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
                    <th class="p-3">Foto</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email / Telepon</th>
                    <th class="p-3">Peran (Role)</th>
                    <th class="p-3">Status Tampil</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($volunteers as $vol)
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3">
                            <div class="w-10 h-10 rounded-full bg-green-50 border border-green-100 overflow-hidden flex items-center justify-center font-extrabold text-brand-green shadow-inner">
                                @if($vol->photo_path)
                                    <img src="{{ $vol->photo_path }}" alt="{{ $vol->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($vol->name, 0, 1)) }}
                                @endif
                            </div>
                        </td>
                        <td class="p-3 font-semibold text-gray-800">
                            <div>{{ $vol->name }}</div>
                            <div class="text-[10px] text-gray-400 font-normal mt-0.5"><i class="fas fa-calendar-day text-[9px] mr-0.5"></i> {{ $vol->created_at->format('d M Y H:i') }}</div>
                        </td>
                        <td class="p-3">
                            <div class="font-medium text-gray-700">{{ $vol->email }}</div>
                            <div class="text-[10px] text-gray-400 mt-0.5"><i class="fab fa-whatsapp text-green-500"></i> {{ $vol->phone }}</div>
                        </td>
                        <td class="p-3">
                            <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-[10px] font-medium border border-gray-200">{{ $vol->role }}</span>
                        </td>
                        <td class="p-3">
                            @if($vol->status == 'aktif')
                                <span class="bg-green-50 text-brand-green border border-green-150 px-2 py-0.5 rounded-full text-[10px] font-bold">Aktif (Tampil)</span>
                            @else
                                <span class="bg-yellow-50 text-yellow-600 border border-yellow-150 px-2 py-0.5 rounded-full text-[10px] font-bold">Pending (Review)</span>
                            @endif
                        </td>
                        <td class="p-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.volunteers.edit', $vol->id) }}" class="text-blue-600 hover:text-blue-800 font-bold bg-blue-50 px-2 py-1 rounded transition text-[10px] flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.volunteers.destroy', $vol->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran relawan ini?')" class="inline">
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
                        <td colspan="6" class="p-6 text-center text-gray-400">Belum ada relawan yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
