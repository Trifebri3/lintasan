@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 leading-tight">Statistik & Angka Dampak</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola angka visual, indikator, dan lambang ikon yang tampil di situs utama</p>
        </div>
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
                        <th class="px-6 py-4">Grup Posisi</th>
                        <th class="px-6 py-4">Nama Kolom (Key)</th>
                        <th class="px-6 py-4">Lambang Ikon</th>
                        <th class="px-6 py-4">Nilai Angka</th>
                        <th class="px-6 py-4">Label Indikator</th>
                        <th class="px-6 py-4">Urutan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-150 text-gray-600 bg-white">
                    @forelse($statistics as $stat)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold capitalize">
                                <span class="px-2.5 py-1 rounded-full text-[10px] {{ $stat->group == 'quick_stats' ? 'bg-orange-50 text-brand-orange border border-orange-100' : 'bg-green-50 text-brand-green border border-green-100' }}">
                                    {{ str_replace('_', ' ', $stat->group) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono font-bold text-[10px] text-gray-700">{{ $stat->key }}</td>
                            <td class="px-6 py-4">
                                <span class="flex items-center gap-2">
                                    <span class="w-8 h-8 rounded bg-gray-100 border flex items-center justify-center text-gray-600 text-sm">
                                        <i class="fas {{ $stat->icon }}"></i>
                                    </span>
                                    <span class="font-mono text-gray-400 text-[10px]">{{ $stat->icon }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-extrabold text-sm text-gray-900">{{ $stat->value }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-700">{{ $stat->label }}</td>
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $stat->sort_order }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.statistics.edit', $stat->id) }}" class="inline-flex items-center gap-1 bg-brand-green hover:bg-brand-darkgreen text-white font-bold px-3 py-1.5 rounded transition shadow-sm">
                                    <i class="fas fa-edit text-[10px]"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada statistik terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
