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
    <aside class="w-64 bg-[#0a2016] text-white shrink-0 hidden md:flex flex-col justify-between p-6">
        <div>
            <!-- Sidebar Header -->
            <div class="mb-8">
                <div class="text-white font-bold text-xl tracking-wider flex items-center leading-none">
                    LINTAS<span class="relative inline-block text-white">A<span class="absolute -top-2.5 left-1/2 -translate-x-1/2 text-xs flex gap-0.5"><i class="fas fa-leaf text-[9px] text-brand-yellow rotate-12"></i><i class="fas fa-leaf text-[9px] text-brand-green -rotate-45 -ml-1"></i></span></span>N
                    <span class="text-brand-yellow font-normal text-xs ml-1 border-l pl-2 border-white/20">ADMIN</span>
                </div>
                <p class="text-[8px] text-gray-400 tracking-widest mt-1">YAYASAN KETANGGUHAN PESISIR</p>
            </div>

            <!-- Nav Items -->
            <nav class="space-y-2 text-sm font-medium">
                @php
                    $activeClass = 'bg-brand-green text-white font-bold relative overflow-hidden before:absolute before:left-0 before:top-0 before:bottom-0 before:w-1.5 before:bg-brand-yellow';
                    $inactiveClass = 'text-gray-300 hover:bg-white/5 hover:text-white';
                @endphp
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-chart-line w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.hero-images.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.hero-images.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-images w-5"></i> Slide Hero
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.settings.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-file-lines w-5"></i> Konten Halaman
                    </a>
                    <a href="{{ route('admin.statistics.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.statistics.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-calculator w-5"></i> Statistik & Angka
                    </a>
                    <a href="{{ route('admin.programs.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.programs.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-tasks w-5"></i> Program
                    </a>
                    <a href="{{ route('admin.villages.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.villages.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-map-location-dot w-5"></i> Desa Mitra Lintasan
                    </a>
                @endif
                <a href="{{ route('admin.stories.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.stories.*') ? $activeClass : $inactiveClass }} transition">
                    <i class="fas fa-book-open w-5"></i> Cerita Lapangan
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.partners.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-handshake w-5"></i> Mitra
                    </a>
                    <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.galleries.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-images w-5"></i> Galeri
                    </a>
                    <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.volunteers.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fas fa-user-group w-5"></i> Pendaftar Relawan
                    </a>
                    <a href="{{ route('admin.social-links.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.social-links.*') ? $activeClass : $inactiveClass }} transition">
                        <i class="fab fa-instagram w-5 text-base"></i> Media Sosial
                    </a>
                @endif
            </nav>
        </div>

        <div class="space-y-4 pt-4 border-t border-white/10">
            <!-- User Info -->
            <div class="flex items-center gap-2 text-xs">
                <div class="w-8 h-8 rounded-full bg-brand-green flex items-center justify-center font-bold text-white shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-gray-200 line-clamp-1">{{ Auth::user()->name }}</div>
                    <span class="text-[9px] text-gray-400 capitalize bg-white/5 px-2 py-0.5 rounded-full border border-white/5 font-semibold tracking-wide">{{ Auth::user()->role }}</span>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="space-y-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-[10px] text-gray-400 hover:text-white transition">
                    <i class="fas fa-arrow-left"></i> Lihat Situs Utama
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-2.5 text-[10px] text-red-400 hover:text-red-300 font-bold transition">
                        <i class="fas fa-right-from-bracket"></i> Keluar (Logout)
                    </button>
                </form>
            </div>
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

    <!-- Image Upload Inspector & Client Auto-Compressor -->
    <script src="{{ asset('js/image-upload-helper.js') }}"></script>
    @yield('scripts')
</body>
</html>
