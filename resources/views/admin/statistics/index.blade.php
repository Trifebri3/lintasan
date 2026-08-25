@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 leading-tight">Statistik Dampak</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola indikator statistik dampak yang ditampilkan pada halaman publik.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-brand-green p-4 rounded-xl text-xs font-semibold mb-6 shadow-sm">
            <i class="fas fa-circle-check mr-1.5"></i> {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        @forelse($statistics as $index => $stat)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden p-6">
                <!-- Card Header -->
                <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $stat->group == 'quick_stats' ? 'bg-orange-50 text-brand-orange border border-orange-100' : 'bg-green-50 text-brand-green border border-green-100' }}">
                        {{ str_replace('_', ' ', $stat->group) }}
                    </span>
                    <span class="text-xs font-extrabold text-gray-400">#{{ $index + 1 }}</span>
                </div>

                <!-- Card Body -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <!-- Title & Key -->
                    <div class="w-full lg:w-1/4">
                        <h3 class="text-sm font-extrabold text-gray-900 leading-snug">{{ $stat->label }}</h3>
                        <p class="font-mono text-gray-400 text-[10px] mt-0.5">{{ $stat->key }}</p>
                    </div>

                    <!-- Details: Preview, Value, Icon -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">
                        <!-- Preview Box -->
                        <div>
                            <span class="block font-bold text-gray-400 uppercase text-[9px] mb-1.5">Pratinjau</span>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-150 rounded-xl h-[52px] overflow-hidden">
                                @php
                                    $gradients = [
                                        'bg-gradient-to-br from-[#833ab4]/70 via-[#fd1d1d]/70 to-[#fcb045]/70',
                                        'bg-gradient-to-br from-[#00c6ff]/70 to-[#0072ff]/70',
                                        'bg-gradient-to-br from-[#f857a6]/70 to-[#ff5858]/70',
                                        'bg-gradient-to-br from-[#11998e]/70 to-[#38ef7d]/70',
                                        'bg-gradient-to-br from-[#ff9966]/70 to-[#ff5e62]/70',
                                        'bg-gradient-to-br from-[#da1b60]/70 to-[#ff8a00]/70',
                                    ];
                                    $previewBg = $stat->color_class ?: $gradients[$index % count($gradients)];
                                @endphp
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs {{ $previewBg }} shrink-0">
                                    <i class="fas {{ $stat->icon }}"></i>
                                </div>
                                <div class="text-left overflow-hidden">
                                    <h4 class="text-xs font-black text-gray-900 leading-tight truncate">{{ $stat->value }}</h4>
                                    <p class="text-[8px] text-gray-400 font-semibold uppercase tracking-wider leading-none mt-0.5 truncate">{{ $stat->label }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Value Box -->
                        <div>
                            <span class="block font-bold text-gray-400 uppercase text-[9px] mb-1.5">Nilai</span>
                            <div class="border border-gray-200 bg-gray-50/50 rounded-xl px-4 py-3 font-extrabold text-sm text-gray-900 h-[52px] flex items-center">
                                {{ $stat->value }}
                            </div>
                        </div>

                        <!-- Icon Box -->
                        <div>
                            <span class="block font-bold text-gray-400 uppercase text-[9px] mb-1.5">Ikon</span>
                            <div class="border border-gray-200 bg-gray-50/50 rounded-xl px-4 py-3 font-mono text-gray-700 flex items-center gap-2 h-[52px] overflow-hidden">
                                <i class="fas {{ $stat->icon }} text-brand-green"></i>
                                <span class="truncate">{{ $stat->icon }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('admin.statistics.edit', $stat->id) }}" class="w-full lg:w-auto inline-flex items-center justify-center gap-1.5 bg-brand-green hover:bg-brand-darkgreen text-white font-bold px-4 py-3 rounded-lg shadow-sm transition text-xs">
                            <i class="fas fa-edit text-[10px]"></i> Edit Statistik
                        </a>
                    </div>
                </div>

                <!-- Footer Tags -->
                <div class="flex flex-wrap gap-2 border-t border-gray-50 pt-4 mt-4 text-[10px]">
                    <span class="bg-gray-50 text-gray-500 border border-gray-150 px-2.5 py-0.5 rounded-full font-bold">
                        {{ $stat->group }}
                    </span>
                    <span class="bg-gray-50 text-gray-500 border border-gray-150 px-2.5 py-0.5 rounded-full font-bold">
                        Urutan {{ $stat->sort_order }}
                    </span>
                    <span class="bg-gray-50 text-gray-500 border border-gray-150 px-2.5 py-0.5 rounded-full font-bold">
                        {{ $stat->color_class ? 'Custom Color' : 'Default Gradient' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center text-gray-400 text-xs">
                Belum ada statistik terdaftar.
            </div>
        @endforelse
    </div>
</div>
@endsection
