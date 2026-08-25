@extends('public.layout.app')

@section('title', (session('locale') == 'en' ? ($village->name_en ?: $village->name) : $village->name) . ' - Desa Mitra Lintasan Yayasan LINTASAN')
@section('meta_description', Str::limit(strip_tags(session('locale') == 'en' ? ($village->description_en ?: $village->description) : $village->description), 150))

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-xs text-gray-500 gap-2">
            <a href="/" class="hover:text-brand-green transition">{{ db_trans('breadcrumb_home', 'Beranda', 'Home') }}</a>
            <span>/</span>
            <a href="{{ route('public.pages.desabinaan') }}" class="hover:text-brand-green transition">{{ db_trans('breadcrumb_villages', 'Desa Mitra Lintasan', 'Partner Villages') }}</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">{{ $village->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Village Info & Narrative -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
                <div class="flex items-center gap-2 text-brand-orange font-bold text-xs">
                    <i class="fas fa-location-dot"></i>
                    <span>{{ $village->location }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">{{ $village->name }}</h1>
                
                <div class="h-64 sm:h-[380px] w-full rounded-lg bg-gray-200 bg-cover bg-center" style="background-image: url('{{ $village->image_path }}');"></div>

                <div class="rich-text-content prose max-w-none text-gray-700 text-sm sm:text-base leading-relaxed space-y-4 pt-4">
                    @if(strip_tags($village->narrative) == $village->narrative)
                        {!! nl2br(e($village->narrative)) !!}
                    @else
                        {!! $village->narrative !!}
                    @endif
                </div>

                <!-- Peta Lokasi Desa -->
                @if($village->latitude && $village->longitude)
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="font-bold text-gray-900 text-sm mb-4"><i class="fas fa-map-location-dot mr-1 text-brand-green"></i> {{ db_trans('village_map_title', 'Peta Lokasi Desa', 'Village Location Map') }}</h3>
                        <div id="village-detail-map" class="w-full h-80 rounded-xl overflow-hidden shadow-sm border border-gray-200" style="z-index: 1;"></div>
                    </div>

                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                    <style>
                        /* Popup styling overrides */
                        .leaflet-popup-content-wrapper {
                            border-radius: 12px !important;
                            padding: 8px 12px !important;
                            overflow: hidden !important;
                            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
                            border: 1px solid rgba(0, 0, 0, 0.04) !important;
                        }
                        .leaflet-popup-content {
                            margin: 0 !important;
                            font-family: 'Plus Jakarta Sans', sans-serif !important;
                        }
                    </style>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const lat = {{ $village->latitude }};
                            const lng = {{ $village->longitude }};
                            const map = L.map('village-detail-map', {
                                center: [lat, lng],
                                zoom: 12,
                                scrollWheelZoom: false,
                                zoomControl: true
                            });

                            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                                subdomains: 'abcd',
                                maxZoom: 19
                            }).addTo(map);

                            const pulsingIcon = L.divIcon({
                                html: `
                                    <div class="relative w-6 h-6 flex items-center justify-center">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#f97316]/50"></span>
                                        <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-gradient-to-r from-[#ff9966] to-[#ff5e62] border-2 border-white shadow-md"></span>
                                    </div>
                                `,
                                className: 'custom-glowing-marker',
                                iconSize: [24, 24],
                                iconAnchor: [12, 12]
                            });

                            L.marker([lat, lng], { icon: pulsingIcon }).addTo(map)
                                .bindPopup(`<h4 class="font-extrabold text-xs text-gray-900 leading-tight">{{ $village->name }}</h4>`);
                        });
                    </script>
                @elseif($village->map_iframe)
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="font-bold text-gray-900 text-sm mb-4"><i class="fas fa-map-location-dot mr-1 text-brand-green"></i> {{ db_trans('village_map_title', 'Peta Lokasi Desa', 'Village Location Map') }}</h3>
                        <div class="w-full overflow-hidden rounded-xl shadow-sm">
                            {!! $village->map_iframe !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Sidebar: Other Villages -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 border-b border-gray-100 pb-2">{{ db_trans('village_sidebar_other', 'Desa Mitra Lintasan Lainnya', 'Other Partner Villages') }}</h3>
                    <div class="space-y-4">
                        @forelse($otherVillages as $other)
                            <a href="{{ route('public.pages.village.show', $other->slug) }}" class="flex gap-3 group">
                                <div class="w-16 h-16 rounded bg-gray-200 bg-cover bg-center shrink-0 shadow-sm" style="background-image: url('{{ $other->image_path }}');"></div>
                                <div>
                                    <span class="text-[9px] font-bold text-brand-orange block mb-0.5"><i class="fas fa-location-dot text-[8px]"></i> {{ $other->location }}</span>
                                    <h4 class="font-bold text-xs text-gray-900 group-hover:text-brand-green transition leading-tight line-clamp-2">{{ $other->name }}</h4>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-gray-500">{{ db_trans('village_sidebar_other_empty', 'Tidak ada desa mitra lintasan lain.', 'No other partner villages.') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-brand-darkgreen text-white rounded-xl shadow-sm border border-brand-green/20 p-6 text-center">
                    <h4 class="font-bold text-sm mb-2 text-brand-yellow">{{ db_trans('village_sidebar_cta_title', 'Ikut Memberdayakan!', 'Join the Empowerment!') }}</h4>
                    <p class="text-xs text-gray-200 mb-4 leading-relaxed">{{ db_trans('village_sidebar_cta_desc', 'Bergabunglah bersama kami untuk memajukan perekonomian dan kesiapsiagaan desa pesisir.', 'Join us to advance the economy and preparedness of coastal villages.') }}</p>
                    <a href="{{ route('public.volunteer.index') }}" class="inline-block bg-brand-orange text-white text-xs font-semibold px-4 py-2.5 rounded hover:bg-orange-600 shadow transition">
                        {{ db_trans('village_sidebar_cta_btn', 'Daftar Relawan', 'Register as Volunteer') }}
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
