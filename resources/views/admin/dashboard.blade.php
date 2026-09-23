@extends('admin.layout.app')

@section('content')
<div class="space-y-8">
    <!-- Header Page -->
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">Dashboard</h1>
        <p class="text-xs text-gray-500 mt-1">Selamat datang di Panel Kontrol Yayasan LINTASAN. Kelola semua konten web di sini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Program</span>
                <span class="text-3xl font-extrabold text-gray-800 block">{{ $programCount }}</span>
            </div>
            <div class="w-12 h-12 bg-green-50 text-brand-green rounded-full flex items-center justify-center text-xl shadow-sm"><i class="fas fa-tasks"></i></div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Cerita Lapangan</span>
                <span class="text-3xl font-extrabold text-gray-800 block">{{ $storyCount }}</span>
            </div>
            <div class="w-12 h-12 bg-orange-50 text-brand-orange rounded-full flex items-center justify-center text-xl shadow-sm"><i class="fas fa-book-open"></i></div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Mitra Kolaborasi</span>
                <span class="text-3xl font-extrabold text-gray-800 block">{{ $partnerCount }}</span>
            </div>
            <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center text-xl shadow-sm"><i class="fas fa-handshake"></i></div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Pendaftar Relawan</span>
                <span class="text-3xl font-extrabold text-gray-800 block">{{ $volunteerCount }}</span>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl shadow-sm"><i class="fas fa-user-group"></i></div>
        </div>
    </div>

    @if(Auth::user()->role === 'admin')
    <!-- Quick Shortcuts to Custom Views -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <a href="{{ route('admin.hero-images.index') }}" class="bg-white hover:border-brand-green border border-gray-100 rounded-xl p-5 shadow-sm transition block group">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-green-50 text-brand-green rounded-lg flex items-center justify-center text-lg shrink-0"><i class="fas fa-images"></i></div>
                <div>
                    <h4 class="font-bold text-gray-950 group-hover:text-brand-green transition text-xs leading-snug">Kelola Banner Slide Hero</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5 leading-snug">Ubah foto slideshow, slogan utama & sub-slogan.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="bg-white hover:border-brand-green border border-gray-100 rounded-xl p-5 shadow-sm transition block group">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-orange-50 text-brand-orange rounded-lg flex items-center justify-center text-lg shrink-0"><i class="fas fa-file-lines"></i></div>
                <div>
                    <h4 class="font-bold text-gray-950 group-hover:text-brand-green transition text-xs leading-snug">Kelola Visi, Misi & Konten</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5 leading-snug">Ubah isi profil yayasan, visi misi, & pilar dasar.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.statistics.index') }}" class="bg-white hover:border-brand-green border border-gray-100 rounded-xl p-5 shadow-sm transition block group">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-teal-50 text-teal-650 rounded-lg flex items-center justify-center text-lg shrink-0"><i class="fas fa-calculator"></i></div>
                <div>
                    <h4 class="font-bold text-gray-950 group-hover:text-brand-green transition text-xs leading-snug">Kelola Angka Statistik</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5 leading-snug">Ubah metrik angka dampak desa mitra lintasan & relawan.</p>
                </div>
            </div>
        </a>
    </div>
    @endif

    <!-- Traffic & Analytics Widget -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-brand-green border border-emerald-200/60">
                        <i class="fas fa-chart-line mr-1"></i> Ringkasan Trafik 7 Hari
                    </span>
                    <span class="text-xs text-gray-400 font-semibold">• {{ number_format($totalPageviews) }} Total Kunjungan</span>
                </div>
                <h3 class="font-extrabold text-gray-900 text-base">Performa Pengunjung & Halaman Terpopuler</h3>
            </div>
            <a href="{{ route('admin.analytics.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-green hover:bg-brand-darkgreen text-white text-xs font-bold transition shadow-xs">
                <span>Buka Analisis & SEO Lengkap</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            <!-- Mini Chart -->
            <div class="lg:col-span-7">
                <div class="flex items-center justify-between text-xs mb-2">
                    <span class="font-bold text-gray-700">Grafik Kunjungan Harian (7 Hari)</span>
                    <span class="text-[11px] text-gray-400 font-semibold">Hari ini: <strong class="text-brand-green">{{ number_format($todayPageviews) }}</strong></span>
                </div>
                <div class="h-44 w-full relative">
                    <canvas id="dashboardMiniTrendChart"></canvas>
                </div>
            </div>

            <!-- Top 4 Pages Quick List -->
            <div class="lg:col-span-5 space-y-2.5">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Halaman Paling Banyak Dikunjungi</span>
                @forelse($topPages as $idx => $p)
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 border border-gray-100 text-xs">
                        <div class="flex items-center gap-2 min-w-0 pr-2">
                            <span class="w-5 h-5 rounded-md bg-white border border-gray-200 text-gray-600 font-black text-[10px] flex items-center justify-center shrink-0">#{{ $idx + 1 }}</span>
                            <span class="font-bold text-gray-800 truncate">{{ $p->page_title ?: $p->path }}</span>
                        </div>
                        <span class="font-extrabold text-brand-green shrink-0">{{ number_format($p->views) }} <span class="text-[10px] text-gray-400 font-normal">views</span></span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 py-3">Belum ada rekaman kunjungan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Latest Volunteer Signups -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-900 text-sm mb-4 border-b border-gray-100 pb-3"><i class="fas fa-users-line mr-1 text-brand-green"></i> Pendaftaran Relawan Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold uppercase">
                        <th class="p-3">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Telepon</th>
                        <th class="p-3">Alamat</th>
                        <th class="p-3">Motivasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($latestVolunteers as $vol)
                        <tr class="hover:bg-gray-50/50">
                            <td class="p-3 font-semibold text-gray-800">{{ $vol->name }}</td>
                            <td class="p-3 text-gray-600">{{ $vol->email }}</td>
                            <td class="p-3 text-gray-600">{{ $vol->phone }}</td>
                            <td class="p-3 text-gray-600"><div class="line-clamp-1 max-w-[200px]">{{ $vol->address }}</div></td>
                            <td class="p-3 text-gray-500"><div class="line-clamp-1 max-w-[250px]">{{ $vol->motivation }}</div></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400">Belum ada relawan yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('dashboardMiniTrendChart');
    if (!ctx) return;

    const ctxTrend = ctx.getContext('2d');
    const gradient = ctxTrend.createLinearGradient(0, 0, 0, 150);
    gradient.addColorStop(0, 'rgba(0, 122, 72, 0.25)');
    gradient.addColorStop(1, 'rgba(0, 122, 72, 0.0)');

    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: {!! json_encode($trendLabels) !!},
            datasets: [{
                label: 'Kunjungan',
                data: {!! json_encode($trendValues) !!},
                borderColor: '#007A48',
                backgroundColor: gradient,
                borderWidth: 2,
                fill: true,
                tension: 0.35,
                pointRadius: 3,
                pointHoverRadius: 5,
                pointBackgroundColor: '#007A48'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F172A',
                    padding: 8,
                    cornerRadius: 6,
                    titleFont: { size: 11, weight: 'bold' },
                    bodyFont: { size: 10 }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 9 }, color: '#94A3B8' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#F1F5F9' },
                    ticks: { font: { size: 9 }, color: '#94A3B8', precision: 0 }
                }
            }
        }
    });
});
</script>
@endsection
