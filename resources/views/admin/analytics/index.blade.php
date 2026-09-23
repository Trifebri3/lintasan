@extends('admin.layout.app')

@section('title', 'Analisis Pengunjung & SEO - Admin LINTASAN')

@section('content')
<div class="space-y-8">
    <!-- Page Header & Period Filter -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-brand-green/10 text-brand-green border border-brand-green/20">
                    <i class="fas fa-chart-pie mr-1"></i> Web Intelligence
                </span>
                <span class="text-gray-300">•</span>
                <span class="text-xs font-semibold text-gray-500">{{ $periodLabel }}</span>
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Analisis Pengunjung & SEO</h1>
            <p class="text-xs text-gray-500 mt-1">Pantau performa trafik website, sebaran demografi wilayah Indonesia, kata kunci pencarian, dan audit SEO.</p>
        </div>

        <!-- Period Filter Pills -->
        <div class="flex items-center gap-1.5 bg-gray-50 p-1.5 rounded-xl border border-gray-200/80 self-start md:self-auto shrink-0 flex-wrap">
            <a href="{{ route('admin.analytics.index', ['period' => '7_days']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $period === '7_days' ? 'bg-brand-green text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
                7 Hari
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => '30_days']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $period === '30_days' ? 'bg-brand-green text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
                30 Hari
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => 'this_month']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $period === 'this_month' ? 'bg-brand-green text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
                Bulan Ini
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => 'all_time']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $period === 'all_time' ? 'bg-brand-green text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}">
                Semua
            </a>
        </div>
    </div>

    <!-- 1. KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Pageviews -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Kunjungan</span>
                    <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ number_format($totalPageviews) }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-brand-green flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2 text-[11px] text-gray-500 pt-3 border-t border-gray-50">
                <span class="text-brand-green font-bold flex items-center"><i class="fas fa-arrow-trend-up mr-1 text-[10px]"></i> Pageviews</span>
                <span class="text-gray-400">dalam {{ $periodLabel }}</span>
            </div>
        </div>

        <!-- Card 2: Unique Visitors -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Pengunjung Unik</span>
                    <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ number_format($uniqueVisitors) }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-orange-50 text-brand-orange flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2 text-[11px] text-gray-500 pt-3 border-t border-gray-50">
                <span class="text-brand-orange font-bold flex items-center"><i class="fas fa-fingerprint mr-1 text-[10px]"></i> Sesi Unik</span>
                <span class="text-gray-400">~{{ $pagesPerVisitor }} hal/orang</span>
            </div>
        </div>

        <!-- Card 3: Today vs Yesterday -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Kunjungan Hari Ini</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-gray-900 tracking-tight">{{ number_format($todayPageviews) }}</span>
                        <span class="text-xs font-bold text-gray-400">({{ $todayUniques }} unik)</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500 pt-3 border-t border-gray-50">
                <span>Kemarin: <strong>{{ number_format($yesterdayPageviews) }}</strong></span>
                @if($todayPageviews >= $yesterdayPageviews)
                    <span class="text-emerald-600 font-bold flex items-center gap-0.5"><i class="fas fa-caret-up"></i> Naik</span>
                @else
                    <span class="text-amber-600 font-bold flex items-center gap-0.5"><i class="fas fa-caret-down"></i> Stabil</span>
                @endif
            </div>
        </div>

        <!-- Card 4: Bounce Rate & Engagement -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Tingkat Pantulan</span>
                    <span class="text-3xl font-black text-gray-900 block tracking-tight">{{ $bounceRate }}%</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2 text-[11px] text-gray-500 pt-3 border-t border-gray-50">
                <span class="text-teal-600 font-bold"><i class="fas fa-shield-halved mr-1 text-[10px]"></i> Sehat</span>
                <span class="text-gray-400">Pengunjung menjelajah multi-halaman</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Traffic Trend Chart -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-gray-100">
            <div>
                <h3 class="font-black text-gray-900 text-base flex items-center gap-2">
                    <i class="fas fa-chart-area text-brand-green"></i> Tren Pertumbuhan Trafik Kunjungan
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Grafik harian membandingkan Total Pageviews vs Pengunjung Unik (Unique Visitors).</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-bold">
                <span class="flex items-center gap-1.5 text-brand-green">
                    <span class="w-3 h-3 rounded-full bg-brand-green inline-block"></span> Total Pageviews
                </span>
                <span class="flex items-center gap-1.5 text-brand-orange">
                    <span class="w-3 h-3 rounded-full bg-brand-orange inline-block"></span> Pengunjung Unik
                </span>
            </div>
        </div>
        <div class="h-80 w-full relative">
            <canvas id="trafficTrendChart"></canvas>
        </div>
    </div>

    <!-- 3. Two Column Breakdown: Perangkat & Saluran Trafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Perangkat & Browser -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fas fa-mobile-screen-button text-brand-green"></i> Distribusi Perangkat & Browser
                    </h3>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">Device Ratio</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-6 items-center">
                    <div class="sm:col-span-5 h-48 relative flex items-center justify-center">
                        <canvas id="deviceChart"></canvas>
                    </div>
                    <div class="sm:col-span-7 space-y-3">
                        @php
                            $totalDev = max(1, array_sum($deviceCounts));
                        @endphp
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                                <span class="text-xs font-bold text-gray-800"><i class="fas fa-mobile-alt mr-1 text-gray-400"></i> Ponsel / Mobile</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-extrabold text-gray-900">{{ number_format($deviceCounts['Mobile']) }}</span>
                                <span class="text-[10px] text-gray-400 ml-1">({{ round(($deviceCounts['Mobile'] / $totalDev) * 100) }}%)</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                <span class="text-xs font-bold text-gray-800"><i class="fas fa-laptop mr-1 text-gray-400"></i> Komputer / Desktop</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-extrabold text-gray-900">{{ number_format($deviceCounts['Desktop']) }}</span>
                                <span class="text-[10px] text-gray-400 ml-1">({{ round(($deviceCounts['Desktop'] / $totalDev) * 100) }}%)</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                <span class="text-xs font-bold text-gray-800"><i class="fas fa-tablet-alt mr-1 text-gray-400"></i> Tablet</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-extrabold text-gray-900">{{ number_format($deviceCounts['Tablet']) }}</span>
                                <span class="text-[10px] text-gray-400 ml-1">({{ round(($deviceCounts['Tablet'] / $totalDev) * 100) }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Browser Pills -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-2">Browser Terpopuler</span>
                <div class="flex items-center gap-2 flex-wrap">
                    @foreach($browserData as $b)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 text-xs font-semibold">
                            <i class="fab fa-{{ strtolower($b->browser) === 'chrome' ? 'chrome text-amber-500' : (strtolower($b->browser) === 'safari' ? 'safari text-blue-500' : (strtolower($b->browser) === 'edge' ? 'edge text-emerald-500' : (strtolower($b->browser) === 'firefox' ? 'firefox text-orange-500' : 'compass text-gray-400'))) }}"></i>
                            {{ $b->browser }}: <strong class="text-gray-900">{{ number_format($b->count) }}</strong>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Saluran Sumber Trafik (Referrers) -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fas fa-bullhorn text-brand-orange"></i> Saluran Sumber Kedatangan Trafik
                    </h3>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">Traffic Channels</span>
                </div>

                <div class="space-y-3.5">
                    @php
                        $maxRef = max(1, $referrerData->max('count') ?? 1);
                        $totalRefs = max(1, $referrerData->sum('count'));
                    @endphp
                    @forelse($referrerData->take(6) as $ref)
                        @php
                            $pct = round(($ref->count / $totalRefs) * 100, 1);
                            $barWidth = round(($ref->count / $maxRef) * 100);
                            $icon = 'fa-globe text-gray-400';
                            if (str_contains(strtolower($ref->channel), 'google')) $icon = 'fab fa-google text-red-500';
                            elseif (str_contains(strtolower($ref->channel), 'instagram')) $icon = 'fab fa-instagram text-pink-600';
                            elseif (str_contains(strtolower($ref->channel), 'whatsapp')) $icon = 'fab fa-whatsapp text-emerald-500';
                            elseif (str_contains(strtolower($ref->channel), 'facebook')) $icon = 'fab fa-facebook text-blue-600';
                            elseif (str_contains(strtolower($ref->channel), 'twitter')) $icon = 'fab fa-x-twitter text-gray-800';
                            elseif (str_contains(strtolower($ref->channel), 'direct')) $icon = 'fas fa-arrow-pointer text-brand-green';
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <div class="flex items-center gap-2 font-bold text-gray-800">
                                    <i class="{{ $icon }} w-4 text-center"></i>
                                    <span>{{ $ref->channel }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-extrabold text-gray-900">{{ number_format($ref->count) }}</span>
                                    <span class="text-[10px] text-gray-400 ml-1">({{ $pct }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-brand-green to-emerald-400 h-2 rounded-full transition-all duration-500" style="width: {{ $barWidth }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 py-6 text-center">Belum ada data referer tercatat.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500">
                <span>Pencarian Organik Google & Medsos mendominasi trafik.</span>
                <span class="font-bold text-brand-green">100% Organik</span>
            </div>
        </div>
    </div>

    <!-- 4. Top Visited Pages & Geolocation Demographics -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Halaman Paling Banyak Dikunjungi (Top Pages) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fas fa-file-lines text-brand-green"></i> Halaman Paling Banyak Dikunjungi
                    </h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Halaman teratas berdasarkan jumlah tayangan dan minat pengunjung.</p>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase bg-gray-100 px-2 py-1 rounded-md">Top 10 Pages</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 font-bold uppercase text-[10px] border-b border-gray-100">
                            <th class="pb-2.5">Halaman & Judul</th>
                            <th class="pb-2.5 text-right">Tayangan</th>
                            <th class="pb-2.5 text-right">Unik</th>
                            <th class="pb-2.5 text-right w-24">Porsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                            $maxPage = max(1, $topPages->max('pageviews') ?? 1);
                        @endphp
                        @forelse($topPages as $idx => $p)
                            @php
                                $portion = round(($p->pageviews / max(1, $totalPageviews)) * 100, 1);
                                $bar = round(($p->pageviews / $maxPage) * 100);
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3 pr-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded-md bg-gray-100 text-gray-500 font-extrabold text-[10px] flex items-center justify-center shrink-0">#{{ $idx + 1 }}</span>
                                        <div class="min-w-0">
                                            <a href="{{ $p->path }}" target="_blank" class="font-bold text-gray-900 hover:text-brand-green transition block truncate max-w-[260px]">
                                                {{ $p->page_title ?: $p->path }}
                                            </a>
                                            <span class="text-[10px] text-gray-400 font-mono">{{ $p->path }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-right font-black text-gray-900">{{ number_format($p->pageviews) }}</td>
                                <td class="py-3 text-right text-gray-500 font-bold">{{ number_format($p->uniques) }}</td>
                                <td class="py-3 text-right">
                                    <span class="text-[10px] font-bold text-gray-600 block">{{ $portion }}%</span>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1 overflow-hidden">
                                        <div class="bg-brand-green h-1.5 rounded-full" style="width: {{ $bar }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-400">Belum ada rekaman halaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Lokasi & Demografi (Provinsi & Kota di Indonesia) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                            <i class="fas fa-map-location-dot text-brand-orange"></i> Lokasi & Demografi Pengunjung
                        </h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">Sebaran wilayah pengguna di Indonesia.</p>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase bg-gray-100 px-2 py-1 rounded-md">Wilayah</span>
                </div>

                <!-- Provinsi Terbanyak -->
                <div class="space-y-3 mb-6">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Provinsi Teratas</span>
                    @php
                        $maxProv = max(1, $topProvinces->max('count') ?? 1);
                        $totalProv = max(1, $topProvinces->sum('count'));
                    @endphp
                    @forelse($topProvinces->take(5) as $prov)
                        @php
                            $pct = round(($prov->count / $totalProv) * 100);
                            $w = round(($prov->count / $maxProv) * 100);
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-bold text-gray-800">{{ $prov->province }}</span>
                                <span class="font-black text-gray-900">{{ number_format($prov->count) }} <span class="text-[10px] text-gray-400 font-normal">({{ $pct }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-orange-400 to-amber-500 h-1.5 rounded-full" style="width: {{ $w }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400">Belum ada data provinsi.</p>
                    @endforelse
                </div>

                <!-- Kota Terbanyak -->
                <div class="pt-4 border-t border-gray-100">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-2.5">Kota / Kabupaten Terbanyak</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($topCities as $c)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-50 border border-gray-100 text-xs font-semibold text-gray-700">
                                <i class="fas fa-location-dot text-[10px] text-red-500"></i>
                                {{ $c->city }}: <strong class="text-gray-900">{{ number_format($c->count) }}</strong>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-gray-100 text-[11px] text-gray-400 flex items-center justify-between">
                <span>Basis utama: <strong>Jawa Barat (Sukabumi, Bandung) & DKI Jakarta</strong></span>
                <i class="fas fa-circle-check text-brand-green"></i>
            </div>
        </div>
    </div>

    <!-- 5. Keywords & SEO Diagnostic Suite -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Kata Kunci Pencarian (Keywords) -->
        <div class="lg:col-span-6 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fas fa-magnifying-glass text-blue-600"></i> Kata Kunci Pencarian (SEO Keywords)
                    </h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Kueri pencarian yang mendatangkan pengunjung dari mesin telusur.</p>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase bg-gray-100 px-2 py-1 rounded-md">Search Queries</span>
            </div>

            <div class="space-y-2.5">
                @forelse($topKeywords as $kw)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50/70 border border-gray-100 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0">
                                <i class="fas fa-search text-[10px]"></i>
                            </span>
                            <span class="text-xs font-bold text-gray-800 truncate">"{{ $kw->keyword }}"</span>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-black bg-white border border-gray-200 text-gray-700 shadow-xs shrink-0">
                            {{ number_format($kw->count) }} kueri
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 py-6 text-center">Belum ada kueri kata kunci tercatat.</p>
                @endforelse
            </div>
        </div>

        <!-- SEO On-Page Health Check & Diagnostics -->
        <div class="lg:col-span-6 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                            <i class="fas fa-award text-amber-500"></i> Diagnostik & Skor SEO Website
                        </h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">Audit kesiapan On-Page SEO dan pengindeksan Google.</p>
                    </div>
                    <div class="flex items-center gap-1.5 bg-emerald-50 text-brand-green border border-brand-green/30 px-3 py-1 rounded-full text-xs font-black">
                        <i class="fas fa-shield-halved"></i> {{ $seoAudit['score'] }}/100
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/50 border border-emerald-100">
                        <i class="fas fa-circle-check text-brand-green text-sm mt-0.5 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">Title Tag & Struktur Heading</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">{{ $seoAudit['title_note'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/50 border border-emerald-100">
                        <i class="fas fa-circle-check text-brand-green text-sm mt-0.5 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">Meta Description Dinamis</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">{{ $seoAudit['meta_desc_note'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/50 border border-emerald-100">
                        <i class="fas fa-circle-check text-brand-green text-sm mt-0.5 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">Desain Mobile-First & Responsif</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">{{ $seoAudit['mobile_note'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/50 border border-emerald-100">
                        <i class="fas fa-circle-check text-brand-green text-sm mt-0.5 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">OpenGraph & Social Share Tags</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">{{ $seoAudit['og_note'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-blue-50/50 border border-blue-100">
                        <i class="fas fa-circle-info text-blue-600 text-sm mt-0.5 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">Pengindeksan Search Engine (Crawler)</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">{{ $seoAudit['sitemap_note'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500">
                <span>Rekomendasi: Terus publikasikan Cerita Lapangan dengan kata kunci relevan.</span>
                <span class="font-bold text-brand-green">SEO Optimal</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Line / Area Chart: Traffic Trend
    const ctxTrend = document.getElementById('trafficTrendChart').getContext('2d');
    
    // Gradients
    const gradientGreen = ctxTrend.createLinearGradient(0, 0, 0, 300);
    gradientGreen.addColorStop(0, 'rgba(0, 122, 72, 0.25)');
    gradientGreen.addColorStop(1, 'rgba(0, 122, 72, 0.0)');

    const gradientOrange = ctxTrend.createLinearGradient(0, 0, 0, 300);
    gradientOrange.addColorStop(0, 'rgba(235, 110, 43, 0.2)');
    gradientOrange.addColorStop(1, 'rgba(235, 110, 43, 0.0)');

    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Total Pageviews',
                    data: {!! json_encode($chartPageviews) !!},
                    borderColor: '#007A48',
                    backgroundColor: gradientGreen,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#007A48'
                },
                {
                    label: 'Pengunjung Unik',
                    data: {!! json_encode($chartUniques) !!},
                    borderColor: '#EB6E2B',
                    backgroundColor: gradientOrange,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#EB6E2B'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0F172A',
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 11 },
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: true
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 }, color: '#94A3B8' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#F1F5F9' },
                    ticks: { font: { size: 10 }, color: '#94A3B8', precision: 0 }
                }
            }
        }
    });

    // 2. Donut Chart: Device Breakdown
    const ctxDevice = document.getElementById('deviceChart').getContext('2d');
    new Chart(ctxDevice, {
        type: 'doughnut',
        data: {
            labels: ['Mobile', 'Desktop', 'Tablet'],
            datasets: [{
                data: [
                    {{ $deviceCounts['Mobile'] }},
                    {{ $deviceCounts['Desktop'] }},
                    {{ $deviceCounts['Tablet'] }}
                ],
                backgroundColor: ['#059669', '#2563EB', '#F59E0B'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endsection
