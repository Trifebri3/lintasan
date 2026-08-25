<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', db_trans('meta_default_title', 'Yayasan LINTASAN - Dari Pesisir Untuk Indonesia', 'Yayasan LINTASAN - From Coasts to Indonesia'))</title>
    <meta name="description" content="@yield('meta_description', db_trans('meta_default_desc', 'Yayasan LINTASAN - Membangun Ketangguhan Pesisir Indonesia melalui Pendidikan SPAB, Tabur Laut, Vokasi SMK, dan Reboisasi Hutan Mangrove.', 'Yayasan LINTASAN - Building Coastal Resilience of Indonesia through SPAB Education, Tabur Laut, SMK Vocation, and Mangrove Reforestation.'))">
    <meta name="keywords" content="@yield('meta_keywords', 'Yayasan LINTASAN, Ketangguhan Pesisir, SPAB, Tangguh Bencana, Nelayan Mandiri, Mangrove')">
    <meta name="theme-color" content="#007A48">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- OpenGraph Tags -->
    <meta property="og:title" content="@yield('title', db_trans('meta_default_title', 'Yayasan LINTASAN - Dari Pesisir Untuk Indonesia', 'Yayasan LINTASAN - From Coasts to Indonesia'))">
    <meta property="og:description" content="@yield('meta_description', db_trans('meta_default_desc', 'Yayasan LINTASAN - Membangun Ketangguhan Pesisir Indonesia melalui Pendidikan SPAB, Tabur Laut, Vokasi SMK, dan Reboisasi Hutan Mangrove.', 'Yayasan LINTASAN - Building Coastal Resilience of Indonesia through SPAB Education, Tabur Laut, SMK Vocation, and Mangrove Reforestation.'))">
    <meta property="og:image" content="@yield('og_image', asset('images/logo-lintasan.png'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="LINTASAN">
    <link rel="apple-touch-icon" href="/images/logo-lintasan.png">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <!-- Font Google: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Playfair+Display:ital,wght@1,700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
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
        /* Dynamic premium gradient overrides for all website pages */
        .bg-brand-green {
            background: linear-gradient(135deg, #11998e, #38ef7d) !important;
            border: none !important;
        }
        .bg-brand-green:hover {
            background: linear-gradient(135deg, #0e837a, #30cb6a) !important;
        }
        
        .bg-brand-orange {
            background: linear-gradient(135deg, #ff9966, #ff5e62) !important;
            border: none !important;
        }
        .bg-brand-orange:hover {
            background: linear-gradient(135deg, #e68555, #e64f53) !important;
        }

        /* Color overrides */
        .text-brand-green {
            color: #0d9488 !important;
        }
        .border-brand-green {
            border-color: #0d9488 !important;
        }
        .text-brand-orange {
            color: #f97316 !important;
        }
        .text-brand-yellow {
            color: #eab308 !important;
        }

        /* Hover states */
        .hover\:text-brand-green:hover {
            color: #0d9488 !important;
        }
        .hover\:bg-brand-darkgreen:hover {
            background: linear-gradient(135deg, #095030, #0a693f) !important;
        }

        /* Custom font styles */
        h1, h2, h3, h4 {
            letter-spacing: -0.025em;
        }

        /* Clamp descriptions */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }

        /* Smooth global transitions */
        a, button {
            transition: all 0.2s ease-in-out;
        }

        /* High contrast mode styles */
        body.high-contrast {
            background-color: #000000 !important;
            color: #ffffff !important;
        }
        body.high-contrast nav,
        body.high-contrast footer,
        body.high-contrast header,
        body.high-contrast section,
        body.high-contrast main,
        body.high-contrast div:not(#accessibility-widget):not(#accessibility-panel),
        body.high-contrast p,
        body.high-contrast span,
        body.high-contrast h1,
        body.high-contrast h2,
        body.high-contrast h3,
        body.high-contrast h4,
        body.high-contrast a,
        body.high-contrast input,
        body.high-contrast textarea,
        body.high-contrast button {
            background-color: #000000 !important;
            background-image: none !important;
            color: #ffff00 !important;
            border-color: #ffffff !important;
        }
        body.high-contrast a:hover,
        body.high-contrast button:hover {
            color: #ffffff !important;
            text-decoration: underline !important;
        }

        /* Floating background bubbles styling */
        .bubble {
            animation: float-bubble infinite alternate ease-in-out;
            will-change: transform;
            filter: blur(40px);
        }
        .bubble-1 {
            width: 180px;
            height: 180px;
            top: 15%;
            left: -50px;
            animation-duration: 25s;
        }
        .bubble-2 {
            width: 250px;
            height: 250px;
            top: 45%;
            right: -80px;
            animation-duration: 32s;
            animation-delay: -5s;
        }
        .bubble-3 {
            width: 200px;
            height: 200px;
            bottom: 10%;
            left: 8%;
            animation-duration: 28s;
            animation-delay: -10s;
        }
        .bubble-4 {
            width: 150px;
            height: 150px;
            top: 75%;
            right: 12%;
            animation-duration: 22s;
            animation-delay: -2s;
        }
        .bubble-5 {
            width: 280px;
            height: 280px;
            top: -100px;
            right: 25%;
            animation-duration: 38s;
            animation-delay: -15s;
        }

        @keyframes float-bubble {
            0% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(40px, -60px) scale(1.1);
            }
            100% {
                transform: translate(-30px, 30px) scale(0.95);
            }
        }
    </style>
</head>
<body class="bg-white text-gray-800 font-sans antialiased transition-all duration-300 relative">
    
    <!-- Floating Background Bubbles -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden opacity-[0.22]">
        <div class="bubble bubble-1 absolute rounded-full bg-gradient-to-br from-[#11998e]/20 to-[#38ef7d]/10"></div>
        <div class="bubble bubble-2 absolute rounded-full bg-gradient-to-br from-[#ff9966]/20 to-[#ff5e62]/10"></div>
        <div class="bubble bubble-3 absolute rounded-full bg-gradient-to-br from-[#00c6ff]/20 to-[#0072ff]/10"></div>
        <div class="bubble bubble-4 absolute rounded-full bg-gradient-to-br from-[#da1b60]/20 to-[#ff8a00]/10"></div>
        <div class="bubble bubble-5 absolute rounded-full bg-gradient-to-br from-[#11998e]/15 to-[#38ef7d]/10"></div>
    </div>

    <!-- ================= NAVBAR ================= -->
    @include('public.layout.header')

    <!-- ================= CONTENT ================= -->
    <main role="main">
        @yield('content')
    </main>

    <!-- ================= FOOTER ================= -->
    @include('public.layout.footer')

    <!-- ================= ACCESSIBILITY FLOAT PANEL ================= -->
    <div id="accessibility-widget" class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-2">
        <!-- Expanded controls -->
        <div id="accessibility-panel" class="hidden bg-white border border-gray-200 rounded-xl shadow-2xl p-4 w-48 text-xs font-semibold text-gray-700 flex flex-col gap-3 transition-all duration-200">
            <div>
                <span class="block mb-2 text-gray-400 uppercase tracking-wider text-[9px]">{{ db_trans('accessibility_options', 'Aksesibilitas', 'Accessibility Options') }}</span>
                <hr class="border-gray-100">
            </div>
            <!-- High Contrast Toggle -->
            <button id="contrast-toggle" class="w-full flex items-center justify-between border border-gray-200 hover:border-brand-green px-3 py-2 rounded-lg transition" aria-label="Toggle High Contrast">
                <span>{{ db_trans('high_contrast', 'Kontras Tinggi', 'High Contrast') }}</span>
                <i class="fas fa-circle-half-stroke text-brand-green text-sm"></i>
            </button>
            <!-- Text Resizing -->
            <div class="flex items-center justify-between border border-gray-200 px-3 py-2 rounded-lg">
                <span>{{ db_trans('text_size', 'Ukuran Teks', 'Text Size') }}</span>
                <div class="flex items-center gap-2 font-extrabold text-xs">
                    <button id="text-size-sm" class="hover:text-brand-green transition text-[10px]" title="Small text">A-</button>
                    <button id="text-size-md" class="hover:text-brand-green transition text-xs text-brand-green" title="Normal text">A</button>
                    <button id="text-size-lg" class="hover:text-brand-green transition text-sm" title="Large text">A+</button>
                </div>
            </div>
        </div>
        <!-- Trigger button -->
        <button id="accessibility-btn" aria-expanded="false" aria-label="Accessibility Menu" class="w-12 h-12 rounded-full bg-brand-green hover:bg-brand-darkgreen text-white flex items-center justify-center shadow-lg transition text-lg">
            <i class="fas fa-universal-access"></i>
        </button>
    </div>

    <!-- Accessibility Widget Script -->
    <script>
        const accBtn = document.getElementById('accessibility-btn');
        const accPanel = document.getElementById('accessibility-panel');
        const contrastTog = document.getElementById('contrast-toggle');
        const sizeSm = document.getElementById('text-size-sm');
        const sizeMd = document.getElementById('text-size-md');
        const sizeLg = document.getElementById('text-size-lg');

        // Toggle panel display
        accBtn.addEventListener('click', () => {
            const isVisible = accPanel.classList.contains('hidden');
            if (isVisible) {
                accPanel.classList.remove('hidden');
                accBtn.setAttribute('aria-expanded', 'true');
            } else {
                accPanel.classList.add('hidden');
                accBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Contrast Mode
        contrastTog.addEventListener('click', () => {
            document.body.classList.toggle('high-contrast');
            const isHighContrast = document.body.classList.contains('high-contrast');
            localStorage.setItem('high-contrast', isHighContrast);
        });

        // Check local storage for contrast setting
        if (localStorage.getItem('high-contrast') === 'true') {
            document.body.classList.add('high-contrast');
        }

        // Sizing logic
        sizeSm.addEventListener('click', () => {
            document.documentElement.style.fontSize = '87.5%'; // 14px base
            sizeSm.classList.add('text-brand-green');
            sizeMd.classList.remove('text-brand-green');
            sizeLg.classList.remove('text-brand-green');
        });
        sizeMd.addEventListener('click', () => {
            document.documentElement.style.fontSize = '100%'; // 16px base
            sizeSm.classList.remove('text-brand-green');
            sizeMd.classList.add('text-brand-green');
            sizeLg.classList.remove('text-brand-green');
        });
        sizeLg.addEventListener('click', () => {
            document.documentElement.style.fontSize = '112.5%'; // 18px base
            sizeSm.classList.remove('text-brand-green');
            sizeMd.classList.remove('text-brand-green');
            sizeLg.classList.add('text-brand-green');
        });

        // Register Service Worker for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((reg) => {
                    console.log('ServiceWorker registration successful: ', reg.scope);
                }).catch((err) => {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>

</body>
</html>
