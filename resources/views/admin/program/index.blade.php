@extends('admin.layout.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Kelola Program</h1>
            <p class="text-xs text-gray-500 mt-1">Tambahkan, edit, atau hapus program unggulan Yayasan LINTASAN.</p>
        </div>
        <a href="{{ route('admin.programs.create') }}" class="bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition flex items-center gap-1.5">
            <i class="fas fa-plus"></i> Tambah Program
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green rounded-lg p-4 text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-circle-check text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-55 border-b border-gray-100 text-gray-500 font-bold uppercase">
                        <th class="p-3">Gambar</th>
                        <th class="p-3">Nama Program</th>
                        <th class="p-3">Icon</th>
                        <th class="p-3">Warna Badge</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($programs as $program)
                        <tr class="hover:bg-gray-50/50">
                            <td class="p-3">
                                <div class="w-12 h-12 rounded bg-gray-200 bg-cover bg-center shadow-sm" style="background-image: url('{{ $program->image_url }}');"></div>
                            </td>
                            <td class="p-3 font-semibold text-gray-800">
                                <div>{{ $program->title }}</div>
                                <div class="text-[10px] text-gray-400 font-normal line-clamp-1 max-w-[300px] mt-1">{{ $program->description }}</div>
                            </td>
                            <td class="p-3">
                                <span class="text-gray-600"><i class="fas {{ $program->icon }} text-base mr-1"></i> {{ $program->icon }}</span>
                            </td>
                            <td class="p-3">
                                <span class="text-xs font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $program->color_class }}</span>
                            </td>
                            <td class="p-3 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.programs.edit', $program->id) }}" class="text-blue-600 hover:text-blue-800 font-bold bg-blue-50 px-2 py-1 rounded transition text-[10px] flex items-center gap-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')" class="inline">
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
                            <td colspan="5" class="p-6 text-center text-gray-400">Belum ada program yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
