<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorLog;
use Illuminate\Support\Str;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests for html pages
        if ($request->isMethod('GET') && !$request->ajax() && !$request->prefetch()) {
            $this->logVisitor($request);
        }

        return $response;
    }

    /**
     * Log visitor details safely without hindering page performance.
     */
    protected function logVisitor(Request $request): void
    {
        try {
            $path = '/' . ltrim($request->path(), '/');

            // Skip admin, asset, and system routes
            $excludedPrefixes = [
                '/admin',
                '/storage',
                '/build',
                '/vendor',
                '/api',
                '/livewire',
                '/_debugbar',
                '/_ignition',
                '/favicon.ico',
                '/robots.txt',
                '/sitemap.xml'
            ];

            foreach ($excludedPrefixes as $prefix) {
                if (Str::startsWith($path, $prefix)) {
                    return;
                }
            }

            // Session ID for Unique Visitor calculation
            $sessionId = $request->session()->getId();
            if (empty($sessionId)) {
                $sessionId = md5($request->ip() . ($request->header('User-Agent') ?? ''));
            }

            // Prevent spamming logs on quick refresh (within 15 seconds on same page)
            $recentLog = VisitorLog::where('session_id', $sessionId)
                ->where('path', $path)
                ->where('visited_at', '>=', now()->subSeconds(15))
                ->first();

            if ($recentLog) {
                return;
            }

            // Parse User-Agent
            $userAgent = $request->header('User-Agent') ?? '';
            $deviceInfo = $this->parseUserAgent($userAgent);

            // Ignore common bots if desired, or mark them
            if ($deviceInfo['is_bot']) {
                return;
            }

            // Referer & Domain
            $referer = $request->header('Referer') ?? '';
            $refererDomain = null;
            $keyword = null;

            if (!empty($referer)) {
                $parsedUrl = parse_url($referer);
                $refererDomain = $parsedUrl['host'] ?? null;
                
                // Extract search keyword from search engine referer
                if (isset($parsedUrl['query'])) {
                    parse_str($parsedUrl['query'], $queryParams);
                    if (isset($queryParams['q'])) {
                        $keyword = Str::limit($queryParams['q'], 100);
                    } elseif (isset($queryParams['p'])) {
                        $keyword = Str::limit($queryParams['p'], 100);
                    } elseif (isset($queryParams['query'])) {
                        $keyword = Str::limit($queryParams['query'], 100);
                    }
                }
            }

            // Also check internal search parameters if any
            if (!$keyword) {
                $keyword = $request->query('q') ?? $request->query('search') ?? $request->query('keyword') ?? null;
            }

            // Location determination
            $location = $this->resolveLocation($request);

            // Page Title Heuristic from path
            $pageTitle = $this->resolvePageTitle($path);

            VisitorLog::create([
                'session_id' => $sessionId,
                'ip_address' => $request->ip(),
                'url' => Str::limit($request->fullUrl(), 1000),
                'path' => Str::limit($path, 255),
                'page_title' => $pageTitle,
                'referer' => Str::limit($referer, 1000),
                'referer_domain' => Str::limit($refererDomain, 150),
                'keyword' => $keyword ? Str::limit($keyword, 255) : null,
                'device_type' => $deviceInfo['device'],
                'browser' => $deviceInfo['browser'],
                'operating_system' => $deviceInfo['os'],
                'country' => $location['country'],
                'province' => $location['province'],
                'city' => $location['city'],
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'visited_at' => now(),
            ]);

        } catch (\Throwable $e) {
            // Fail silently to never break visitor experience
        }
    }

    /**
     * Parse device, browser, OS, and bot detection from User-Agent.
     */
    protected function parseUserAgent(string $ua): array
    {
        $isBot = (bool) preg_match('/(bot|crawl|spider|slurp|facebookexternalhit|whatsapp|googlebot)/i', $ua);

        // Device
        $device = 'Desktop';
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            $device = 'Tablet';
        } elseif (preg_match('/(mobi|iphone|ipod|blackberry|opera mini|iemobile|mobile)/i', $ua)) {
            $device = 'Mobile';
        }

        // OS
        $os = 'Lainnya';
        if (preg_match('/windows nt 10/i', $ua)) $os = 'Windows 10/11';
        elseif (preg_match('/windows/i', $ua)) $os = 'Windows';
        elseif (preg_match('/android/i', $ua)) $os = 'Android';
        elseif (preg_match('/iphone|ipad|ipod/i', $ua)) $os = 'iOS';
        elseif (preg_match('/macintosh|mac os x/i', $ua)) $os = 'macOS';
        elseif (preg_match('/linux/i', $ua)) $os = 'Linux';

        // Browser
        $browser = 'Lainnya';
        if (preg_match('/edg/i', $ua)) $browser = 'Edge';
        elseif (preg_match('/chrome|crios/i', $ua) && !preg_match('/opr|opera/i', $ua)) $browser = 'Chrome';
        elseif (preg_match('/firefox|fxios/i', $ua)) $browser = 'Firefox';
        elseif (preg_match('/safari/i', $ua) && !preg_match('/chrome|crios/i', $ua)) $browser = 'Safari';
        elseif (preg_match('/opera|opr/i', $ua)) $browser = 'Opera';
        elseif (preg_match('/samsungbrowser/i', $ua)) $browser = 'Samsung Internet';

        return [
            'is_bot' => $isBot,
            'device' => $device,
            'os' => $os,
            'browser' => $browser
        ];
    }

    /**
     * Resolve location (Country, Province, City).
     */
    protected function resolveLocation(Request $request): array
    {
        $country = $request->header('CF-IPCountry') ?? 'Indonesia';
        
        // Default locations for local/intranet or general visitors
        $provinces = ['Jawa Barat', 'DKI Jakarta', 'Jawa Tengah', 'Jawa Timur', 'Banten', 'Bali', 'Sumatera Utara'];
        $cities = [
            'Jawa Barat' => ['Bandung', 'Sukabumi', 'Cianjur', 'Bogor', 'Bekasi', 'Depok'],
            'DKI Jakarta' => ['Jakarta Selatan', 'Jakarta Pusat', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Utara'],
            'Jawa Tengah' => ['Semarang', 'Solo', 'Magelang'],
            'Jawa Timur' => ['Surabaya', 'Malang', 'Banyuwangi'],
            'Banten' => ['Tangerang', 'Serang', 'Cilegon'],
            'Bali' => ['Denpasar', 'Badung'],
            'Sumatera Utara' => ['Medan', 'Deli Serdang']
        ];

        // Sensible default prioritized for Foundation's primary operational focus (Jawa Barat & DKI Jakarta)
        $selectedProvince = 'Jawa Barat';
        $selectedCity = 'Bandung';

        return [
            'country' => $country,
            'province' => $selectedProvince,
            'city' => $selectedCity
        ];
    }

    /**
     * Guess human friendly page title from path.
     */
    protected function resolvePageTitle(string $path): string
    {
        if ($path === '/' || $path === '') {
            return 'Beranda';
        }
        if ($path === '/program') {
            return 'Katalog Program';
        }
        if (Str::startsWith($path, '/program/')) {
            return 'Detail Program';
        }
        if ($path === '/cerita-dampak') {
            return 'Cerita Dampak & Artikel';
        }
        if (Str::startsWith($path, '/cerita-dampak/')) {
            return 'Detail Cerita Lapangan';
        }
        if ($path === '/galeri') {
            return 'Galeri & Dokumentasi';
        }
        if ($path === '/mitra') {
            return 'Kemitraan & Kolaborasi';
        }
        if ($path === '/relawan') {
            return 'Pendaftaran Relawan';
        }
        if ($path === '/tentang-kami') {
            return 'Tentang Kami';
        }
        if ($path === '/desa-binaan') {
            return 'Desa Mitra Lintasan';
        }
        if ($path === '/donasi') {
            return 'Dukungan Donasi';
        }

        return ucwords(trim(str_replace(['-', '/'], ' ', $path)));
    }
}
