@extends('admin.layout.app')

@section('content')
<div class="space-y-6 text-xs">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Kelola Tautan Media Sosial</h1>
            <p class="text-xs text-gray-500 mt-1">Tambahkan, aktifkan, atau sembunyikan (bongkar pasang) media sosial resmi Yayasan LINTASAN.</p>
        </div>
        <a href="{{ route('admin.social-links.create') }}" class="bg-brand-green text-white text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-brand-darkgreen shadow transition flex items-center gap-1.5">
            <i class="fas fa-plus"></i> Tambah Media Baru
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
                    <th class="p-3">Platform</th>
                    <th class="p-3">Nama Akun / Label</th>
                    <th class="p-3">Tautan URL</th>
                    <th class="p-3">Urutan</th>
                    <th class="p-3">Status Tampilan</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($socialLinks as $link)
                    @php
                        $icons = [
                            'instagram' => ['fab fa-instagram', 'bg-pink-50 text-pink-600 border-pink-100'],
                            'youtube' => ['fab fa-youtube', 'bg-red-50 text-red-600 border-red-100'],
                            'facebook' => ['fab fa-facebook-f', 'bg-blue-50 text-blue-600 border-blue-100'],
                            'linkedin' => ['fab fa-linkedin-in', 'bg-sky-50 text-sky-700 border-sky-100'],
                            'twitter' => ['fab fa-x-twitter', 'bg-gray-100 text-gray-800 border-gray-200'],
                            'tiktok' => ['fab fa-tiktok', 'bg-slate-50 text-slate-900 border-slate-200'],
                        ];
                        $style = $icons[strtolower($link->platform)] ?? ['fas fa-share-nodes', 'bg-gray-50 text-gray-500 border-gray-150'];
                    @endphp
                    <tr class="hover:bg-gray-50/50">
                        <td class="p-3">
                            <span class="inline-flex items-center gap-1.5 font-bold uppercase tracking-wider text-[10px] px-2.5 py-1 rounded-full border {{ $style[1] }}">
                                <i class="{{ $style[0] }}"></i> {{ $link->platform }}
                            </span>
                        </td>
                        <td class="p-3 font-semibold text-gray-800">{{ $link->name }}</td>
                        <td class="p-3">
                            <a href="{{ $link->url }}" target="_blank" class="text-brand-green hover:underline font-medium font-mono text-[10px] line-clamp-1">
                                {{ $link->url }} <i class="fas fa-external-link text-[8px] ml-0.5"></i>
                            </a>
                        </td>
                        <td class="p-3 text-gray-600 font-mono font-bold">{{ $link->sort_order }}</td>
                        <td class="p-3">
                            @if($link->is_active)
                                <span class="bg-green-50 text-brand-green border border-green-150 text-[9px] px-2 py-0.5 rounded-full font-bold uppercase"><i class="fas fa-circle-check text-[8px] mr-1"></i> Tampil / Aktif</span>
                            @else
                                <span class="bg-gray-50 text-gray-400 border border-gray-200 text-[9px] px-2 py-0.5 rounded-full font-bold uppercase"><i class="fas fa-circle-minus text-[8px] mr-1"></i> Sembunyi</span>
                            @endif
                        </td>
                        <td class="p-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.social-links.edit', $link->id) }}" class="text-blue-600 hover:text-blue-800 font-bold bg-blue-50 px-2 py-1 rounded transition text-[10px] flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <form action="{{ route('admin.social-links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus media sosial ini?')" class="inline">
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
                        <td colspan="6" class="p-6 text-center text-gray-400">Belum ada tautan media sosial yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
