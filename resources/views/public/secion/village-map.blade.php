<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    /* Popup styling overrides */
    .leaflet-popup-content-wrapper {
        border-radius: 12px !important;
        padding: 0 !important;
        overflow: hidden !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
        border: 1px solid rgba(0, 0, 0, 0.04) !important;
    }
    .leaflet-popup-content {
        margin: 0 !important;
        width: 250px !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }
    .leaflet-popup-close-button {
        color: #ffffff !important;
        font-size: 16px !important;
        top: 8px !important;
        right: 8px !important;
        z-index: 1000 !important;
        background: rgba(0, 0, 0, 0.3) !important;
        border-radius: 50% !important;
        width: 20px !important;
        height: 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
    }
    .leaflet-popup-close-button:hover {
        background: rgba(0, 0, 0, 0.5) !important;
    }
    .leaflet-popup-tip {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
    }
</style>

@php
    $mapData = [];
    foreach ($villages as $village) {
        $lat = $village->latitude;
        $lng = $village->longitude;
        
        // Fallbacks if coordinate is null
        if (is_null($lat) || is_null($lng)) {
            if (str_contains(strtolower($village->location), 'garut')) {
                $lat = -7.5085;
                $lng = 107.6975;
            } elseif (str_contains(strtolower($village->location), 'pangandaran')) {
                $lat = -7.6827;
                $lng = 108.6253;
            } elseif (str_contains(strtolower($village->location), 'bekasi')) {
                $lat = -5.9609;
                $lng = 107.0081;
            } else {
                $lat = -6.9175;
                $lng = 107.6191;
            }
        } else {
            $lat = (float) $lat;
            $lng = (float) $lng;
        }
        
        $mapData[] = [
            'id' => $village->id,
            'name' => $village->name,
            'location' => $village->location,
            'description' => $village->description,
            'image' => $village->image_path,
            'url' => route('public.pages.village.show', $village->slug),
            'lat' => $lat,
            'lng' => $lng
        ];
    }
    
    // De-duplicate coordinates mathematically using mt_rand jitter
    $usedCoords = [];
    foreach ($mapData as &$item) {
        $coordKey = round($item['lat'], 4) . ',' . round($item['lng'], 4);
        if (in_array($coordKey, $usedCoords)) {
            $item['lat'] += (mt_rand(-80, 80) / 100000);
            $item['lng'] += (mt_rand(-80, 80) / 100000);
        }
        $usedCoords[] = round($item['lat'], 4) . ',' . round($item['lng'], 4);
    }
@endphp

<section id="village-map-section" class="py-16 bg-[#F4F9F6]/30 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Page -->
        <div class="text-center mb-10 scroll-animate">
            <span class="text-brand-orange font-bold text-xs uppercase tracking-wider block mb-2">
                {{ db_trans('home_map_badge', 'Sebaran Wilayah Mitra Lintasan', 'Partner Territory') }}
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                {{ db_trans('home_map_title', 'Peta Sebaran Desa Mitra Lintasan', 'Interactive Partner Villages Map') }}
            </h2>
            <div class="h-1 w-12 bg-gradient-to-r from-brand-green to-teal-500 mx-auto rounded mb-4"></div>

        </div>

        <!-- Map Container -->
        <div class="relative w-full h-[480px] rounded-2xl overflow-hidden shadow-md border border-gray-200 bg-gray-50 scroll-animate">
            <div id="leaflet-village-map" class="w-full h-full z-10"></div>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mapData = @json($mapData);
        if (!mapData.length) return;

        // Initialize Map centered around West Java area
        const map = L.map('leaflet-village-map', {
            center: [-7.0, 107.8],
            zoom: 8,
            scrollWheelZoom: false, // prevent accidental scrolling
            zoomControl: true
        });

        // Use CartoDB Positron style (elegant light-grey theme, not pitch black)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        // Define pulsing markers using DivIcon
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

        const bounds = [];

        mapData.forEach(item => {
            if (!item.lat || !item.lng) return;
            
            const marker = L.marker([item.lat, item.lng], { icon: pulsingIcon }).addTo(map);
            bounds.push([item.lat, item.lng]);

            // Construct Card layout popup
            const popupContent = `
                <div class="w-[250px] overflow-hidden">
                    <div class="h-28 bg-gray-200 bg-cover bg-center relative" style="background-image: url('${item.image}')">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0b111e]/40 to-transparent"></div>
                    </div>
                    <div class="p-3.5 bg-white">
                        <span class="inline-block bg-teal-50 text-[#0d9488] text-[8px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider mb-1.5 border border-teal-100/50">${item.location}</span>
                        <h4 class="font-extrabold text-xs text-gray-900 leading-tight mb-1">${item.name}</h4>
                        <p class="text-[10px] text-gray-500 leading-normal line-clamp-2 mb-3">${item.description}</p>
                        <a href="${item.url}" class="block text-center bg-gradient-to-r from-[#11998e] to-[#38ef7d] text-white text-[9px] font-bold py-1.5 rounded-lg transition duration-200 hover:shadow-md">
                            {{ db_trans('home_map_view_details', 'LIHAT DETAIL DESA', 'VIEW VILLAGE DETAILS') }}
                        </a>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent, {
                maxWidth: 250,
                minWidth: 250
            });
        });

        // Fit map view bounds dynamically around all active pins
        if (bounds.length) {
            map.fitBounds(bounds, { padding: [50, 50] });
        }
    });
</script>
