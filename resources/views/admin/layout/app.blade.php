<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - Yayasan LINTASAN</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            green: '#007A48',
                            darkgreen: '#004D2E',
                            orange: '#F58220',
                            yellow: '#FFB800',
                            lightbg: '#F4F9F6'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Modern input focus rings */
        input:focus, textarea:focus, select:focus {
            border-color: #007A48 !important;
            box-shadow: 0 0 0 2px rgba(0, 122, 72, 0.15) !important;
        }
        
        /* Table hover transition */
        table tbody tr {
            transition: background-color 0.15s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#0a2016] text-white shrink-0 hidden md:flex flex-col justify-between p-5 border-r border-emerald-950/40 select-none">
        <div class="flex flex-col h-full overflow-hidden">
            <!-- Sidebar Header -->
            <div class="mb-5 shrink-0 px-2">
                <div class="text-white font-bold text-xl tracking-wider flex items-center leading-none">
                    LINTAS<span class="relative inline-block text-white">A<span class="absolute -top-2.5 left-1/2 -translate-x-1/2 text-xs flex gap-0.5"><i class="fas fa-leaf text-[9px] text-brand-yellow rotate-12"></i><i class="fas fa-leaf text-[9px] text-brand-green -rotate-45 -ml-1"></i></span></span>N
                    <span class="text-brand-yellow font-normal text-xs ml-1 border-l pl-2 border-white/20">ADMIN</span>
                </div>
                <p class="text-[8px] text-gray-400 tracking-widest mt-1">YAYASAN KETANGGUHAN PESISIR</p>
            </div>

            <!-- Nav Items (Scrollable) -->
            <nav class="flex-1 overflow-y-auto pr-1 space-y-4 text-xs font-medium">
                @php
                    $activeClass = 'bg-brand-green text-white font-bold shadow-sm relative overflow-hidden before:absolute before:left-0 before:top-0 before:bottom-0 before:w-1.5 before:bg-brand-yellow';
                    $inactiveClass = 'text-gray-300 hover:bg-white/10 hover:text-white';
                @endphp

                <!-- KELOMPOK 1: UTAMA -->
                <div>
                    <div class="text-[10px] uppercase font-bold tracking-wider text-emerald-400/70 px-3 pb-1.5 flex items-center justify-between">
                        <span>Utama</span>
                    </div>
                    <div class="space-y-1">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-chart-line w-4 text-center"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.analytics.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-chart-pie w-4 text-center"></i>
                                <span>Analisis & SEO</span>
                            </a>
                        @endif
                        <!-- Live Preview Trigger Button -->
                        <button type="button" onclick="openLivePreviewModal('/')" class="w-full text-left flex items-center justify-between px-3.5 py-2.5 rounded-lg text-emerald-300 hover:text-white bg-emerald-950/40 hover:bg-emerald-900/60 border border-emerald-800/40 transition group">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-desktop w-4 text-center group-hover:scale-110 transition-transform text-emerald-400"></i>
                                <span class="font-bold">Live Preview Web</span>
                            </div>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 tracking-wider">
                                LIVE
                            </span>
                        </button>
                    </div>
                </div>

                <!-- KELOMPOK 2: KONTEN WEBSITE -->
                <div>
                    <div class="text-[10px] uppercase font-bold tracking-wider text-emerald-400/70 px-3 pb-1.5">
                        <span>Konten Website</span>
                    </div>
                    <div class="space-y-1">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.hero-images.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.hero-images.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-images w-4 text-center"></i>
                                <span>Slide Hero Banner</span>
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.settings.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-file-pen w-4 text-center"></i>
                                <span>Konten Halaman & Nilai</span>
                            </a>
                            <a href="{{ route('admin.programs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.programs.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-hand-holding-heart w-4 text-center"></i>
                                <span>Program Unggulan</span>
                            </a>
                        @endif
                        <a href="{{ route('admin.stories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.stories.*') ? $activeClass : $inactiveClass }} transition">
                            <i class="fas fa-newspaper w-4 text-center"></i>
                            <span>Cerita Lapangan</span>
                        </a>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.galleries.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-photo-film w-4 text-center"></i>
                                <span>Galeri Foto & Video</span>
                            </a>
                            <a href="{{ route('admin.statistics.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.statistics.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-chart-simple w-4 text-center"></i>
                                <span>Statistik & Capaian</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- KELOMPOK 3: JARINGAN & MITRA -->
                <div>
                    <div class="text-[10px] uppercase font-bold tracking-wider text-emerald-400/70 px-3 pb-1.5">
                        <span>Jaringan & Mitra</span>
                    </div>
                    <div class="space-y-1">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.villages.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.villages.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-map-location-dot w-4 text-center"></i>
                                <span>Desa Mitra Lintasan</span>
                            </a>
                            <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.partners.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-handshake w-4 text-center"></i>
                                <span>Mitra & Kerjasama</span>
                            </a>
                            <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.volunteers.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fas fa-users-line w-4 text-center"></i>
                                <span>Pendaftar Relawan</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- KELOMPOK 4: PENGATURAN -->
                @if(Auth::user()->role === 'admin')
                    <div>
                        <div class="text-[10px] uppercase font-bold tracking-wider text-emerald-400/70 px-3 pb-1.5">
                            <span>Pengaturan</span>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.social-links.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg {{ request()->routeIs('admin.social-links.*') ? $activeClass : $inactiveClass }} transition">
                                <i class="fab fa-instagram w-4 text-center text-sm"></i>
                                <span>Media Sosial & Kontak</span>
                            </a>
                        </div>
                    </div>
                @endif
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="space-y-3 pt-3 border-t border-white/10 shrink-0">
            <!-- User Info Badge -->
            <div class="flex items-center justify-between bg-white/5 p-2 rounded-lg border border-white/5">
                <div class="flex items-center gap-2 text-xs min-w-0">
                    <div class="w-7 h-7 rounded-full bg-brand-green flex items-center justify-center font-bold text-white shadow-inner shrink-0 text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="font-bold text-gray-200 text-xs truncate">{{ Auth::user()->name }}</div>
                        <span class="text-[9px] text-emerald-300 capitalize font-medium">{{ Auth::user()->role }}</span>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" title="Keluar (Logout)" class="w-7 h-7 rounded flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition">
                        <i class="fas fa-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
            
            <!-- Quick Link to Public Web -->
            <a href="{{ route('home') }}" target="_blank" class="w-full py-1.5 px-2.5 rounded-md text-[10px] font-semibold text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 flex items-center justify-center gap-1.5 transition">
                <i class="fas fa-arrow-up-right-from-square text-[9px]"></i>
                <span>Buka Website di Tab Baru</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Admin Header Bar -->
        @include('admin.layout.header')

        <!-- Content Page -->
        <main class="flex-grow p-6 md:p-8">
            <!-- Global Flash Success Alert -->
            @if(session('success'))
                <div class="max-w-6xl mx-auto mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs font-semibold shadow-sm flex items-start justify-between gap-3">
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-circle-check text-base text-emerald-600 mt-0.5 shrink-0"></i>
                        <div>
                            <div class="font-bold text-sm text-emerald-900">Operasi Berhasil</div>
                            <div class="text-xs font-medium text-emerald-700 mt-0.5 leading-relaxed">{{ session('success') }}</div>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-sm font-bold">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Global Flash Error Alert -->
            @if(session('error'))
                <div class="max-w-6xl mx-auto mb-6 bg-red-50 border border-red-300 text-red-800 p-4 rounded-xl text-xs shadow-sm flex items-start justify-between gap-3">
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-circle-xmark text-lg text-red-600 mt-0.5 shrink-0"></i>
                        <div>
                            <div class="font-extrabold text-sm text-red-900 flex items-center gap-1.5">
                                Gagal Menyimpan Data / Berkas
                            </div>
                            <div class="text-xs font-medium text-red-700 mt-1 whitespace-pre-line leading-relaxed">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-700 text-sm font-bold">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Global Form Validation Failure Warnings -->
            @if($errors->any())
                <div class="max-w-6xl mx-auto mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs font-semibold shadow-sm">
                    <div class="font-extrabold text-sm mb-2 flex items-center justify-between text-red-800">
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-triangle-exclamation text-base text-red-600"></i> Terjadi Kesalahan Validasi Formulir ({{ $errors->count() }} Isian Gagal):
                        </span>
                        <span class="text-[10px] bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-bold">Perlu Diperbaiki</span>
                    </div>
                    <ul class="list-disc pl-5 space-y-1 font-medium">
                        @foreach($errors->all() as $error)
                            <li class="leading-relaxed">{{ $error }}</li>
                        @endforeach
                    </ul>
                    <div class="mt-3 pt-2.5 border-t border-red-200/60 text-[10px] text-red-600 flex items-center gap-1.5 font-normal">
                        <i class="fas fa-circle-info text-red-500"></i> 
                        <strong>Petunjuk Debug:</strong> Pastikan format file foto berupa JPG, PNG, atau WEBP dan tidak melebihi batas upload PHP server (2 MB).
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Admin Footer -->
        @include('admin.layout.footer')
    </div>

    <!-- Live Preview Modal -->
    @include('admin.components.live-preview-modal')

    <!-- Image Upload Inspector & Client Auto-Compressor -->
    <script src="{{ asset('js/image-upload-helper.js') }}"></script>
    @yield('scripts')
</body>
</html>
