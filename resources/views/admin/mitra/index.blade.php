@extends('admin.layout.app')

@section('content')
<div class="space-y-8 text-xs">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Kelola Mitra Kolaborasi</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola daftar mitra resmi serta tinjau pengajuan kemitraan baru yang masuk dari situs publik.</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition flex items-center gap-1.5">
            <i class="fas fa-plus"></i> Tambah Mitra Manual
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green rounded-lg p-4 text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-circle-check text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-circle-xmark text-base"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- 1. Pengajuan Kemitraan Masuk dari Form Publik -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-brand-orange animate-pulse"></span>
                <h2 class="text-sm font-extrabold text-gray-900 uppercase tracking-wide">Pengajuan Kemitraan Masuk (Formulir Web)</h2>
                <span class="bg-orange-50 text-brand-orange border border-orange-200 text-[10px] font-bold px-2 py-0.5 rounded-full">
                    {{ isset($applications) ? $applications->where('status', 'pending')->count() : 0 }} Menunggu
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold uppercase text-[10px]">
                        <th class="p-3">Instansi / Lembaga</th>
                        <th class="p-3">Narahubung (PIC)</th>
                        <th class="p-3">Kontak Email & WhatsApp</th>
                        <th class="p-3">Bentuk Kolaborasi</th>
                        <th class="p-3">Rencana & Alamat</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($applications ?? [] as $app)
                        <tr class="hover:bg-gray-50/50">
                            <td class="p-3">
                                <div class="flex items-center gap-2.5">
                                    @if($app->logo_path)
                                        <div class="w-8 h-8 rounded bg-gray-50 flex items-center justify-center border border-gray-100 p-0.5 shrink-0">
                                            <img src="{{ $app->logo_path }}" alt="{{ $app->institution_name }}" class="max-h-full max-w-full object-contain">
                                        </div>
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs shrink-0 font-bold">
                                            {{ strtoupper(substr($app->institution_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $app->institution_name }}</div>
                                        <span class="text-[9px] text-gray-400 font-mono">{{ $app->created_at ? $app->created_at->format('d M Y H:i') : '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 font-semibold text-gray-800">{{ $app->pic_name }}</td>
                            <td class="p-3">
                                <div class="font-mono text-gray-700 text-[11px]">{{ $app->email }}</div>
                                <div class="text-[10px] text-gray-500 font-mono">{{ $app->phone }}</div>
                            </td>
                            <td class="p-3">
                                <span class="bg-blue-50 text-blue-700 border border-blue-100 px-2 py-0.5 rounded text-[10px] font-semibold inline-block">
                                    {{ $app->partnership_type ?: 'Umum' }}
                                </span>
                            </td>
                            <td class="p-3 max-w-xs">
                                <div class="text-gray-800 line-clamp-2 italic" title="{{ $app->proposal }}">"{{ $app->proposal }}"</div>
                                <div class="text-[10px] text-gray-400 mt-0.5 line-clamp-1"><i class="fas fa-location-dot text-[9px] mr-1"></i>{{ $app->address }}</div>
                            </td>
                            <td class="p-3 text-right">
                                <div class="inline-flex gap-2">
                                    @if($app->status === 'pending')
                                        <form action="{{ route('admin.partners.applications.approve', $app->id) }}" method="POST" onsubmit="return confirm('Setujui pengajuan kemitraan ini dan jadikan mitra resmi?')">
                                            @csrf
                                            <button type="submit" class="text-white bg-brand-green hover:bg-brand-darkgreen font-bold px-2.5 py-1.5 rounded transition text-[10px] flex items-center gap-1 shadow-sm">
                                                <i class="fas fa-check"></i> Jadikan Mitra
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-green-700 font-bold bg-green-50 px-2 py-1 rounded text-[10px] border border-green-200">
                                            <i class="fas fa-check-double mr-0.5"></i> Telah Disetujui
                                        </span>
                                    @endif

                                    <form action="{{ route('admin.partners.applications.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Hapus pengajuan kemitraan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold bg-red-50 hover:bg-red-100 px-2 py-1.5 rounded transition text-[10px] flex items-center gap-1">
                                            <i class="fas fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400">Belum ada formulir pengajuan kemitraan masuk dari website.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Mitra Resmi Aktif LINTASAN -->
    <div class="space-y-3 pt-4 border-t border-gray-150">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-extrabold text-gray-900 uppercase tracking-wide">Daftar Mitra Resmi Aktif</h2>
            <span class="text-gray-400 text-xs">Total: {{ $partners->count() }} Mitra</span>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-55 border-b border-gray-100 text-gray-500 font-bold uppercase text-[10px]">
                        <th class="p-3">Logo Mitra</th>
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
                                    <div class="w-12 h-10 rounded bg-gray-50 flex items-center justify-center border border-gray-100 p-1 shadow-sm">
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
                                    <a href="{{ route('admin.partners.edit', $partner->id) }}" class="text-blue-600 hover:text-blue-800 font-bold bg-blue-50 px-2.5 py-1.5 rounded transition text-[10px] flex items-center gap-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold bg-red-50 px-2.5 py-1.5 rounded transition text-[10px] flex items-center gap-1">
                                            <i class="fas fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400">Belum ada mitra kolaborasi resmi yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
