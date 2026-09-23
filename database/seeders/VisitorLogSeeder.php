<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Support\Str;

class VisitorLogSeeder extends Seeder
{
    /**
     * Run the database seeds with realistic data over the last 30 days.
     */
    public function run(): void
    {
        // Avoid re-seeding if data exists
        if (VisitorLog::count() > 100) {
            return;
        }

        $pages = [
            ['path' => '/', 'title' => 'Beranda Yayasan LINTASAN', 'weight' => 35],
            ['path' => '/program', 'title' => 'Katalog Program Unggulan', 'weight' => 18],
            ['path' => '/program/mGy1nIpOuVfChoNKz9NcdPDokPVT4eyI', 'title' => 'Satuan Pendidikan Aman Bencana SPAB', 'weight' => 11],
            ['path' => '/program/lmoB3yc90qeVjByAxKOcD2apzPMUpUB3', 'title' => 'Senyum Anak Negeri (SAN)', 'weight' => 9],
            ['path' => '/galeri', 'title' => 'Galeri & Dokumentasi Kegiatan', 'weight' => 10],
            ['path' => '/cerita-dampak', 'title' => 'Cerita Lapangan & Berita', 'weight' => 7],
            ['path' => '/mitra', 'title' => 'Kemitraan & Kolaborasi Instansi', 'weight' => 5],
            ['path' => '/desa-binaan', 'title' => 'Desa Mitra Lintasan Pesisir', 'weight' => 3],
            ['path' => '/tentang-kami', 'title' => 'Tentang Kami & Profil Yayasan', 'weight' => 2],
        ];

        $referers = [
            ['domain' => 'www.google.com', 'url' => 'https://www.google.com/', 'channel' => 'Organic Search', 'weight' => 45],
            ['domain' => null, 'url' => null, 'channel' => 'Direct', 'weight' => 26],
            ['domain' => 'l.instagram.com', 'url' => 'https://l.instagram.com/', 'channel' => 'Social Media', 'weight' => 15],
            ['domain' => 'api.whatsapp.com', 'url' => 'https://api.whatsapp.com/', 'channel' => 'Social Media', 'weight' => 8],
            ['domain' => 'm.facebook.com', 'url' => 'https://m.facebook.com/', 'channel' => 'Social Media', 'weight' => 4],
            ['domain' => 't.co', 'url' => 'https://t.co/', 'channel' => 'Social Media', 'weight' => 2],
        ];

        $keywords = [
            'yayasan lintasan',
            'relawan pesisir jawa barat',
            'program spab sukabumi',
            'senyum anak negeri ciwidey',
            'sekolah aman bencana indonesia',
            'desa mitra lintasan',
            'pemberdayaan masyarakat pesisir',
            'donasi pendidikan bencana',
            'pelatihan vokasi smk bisa jago',
            'hutan anak negeri',
            'mitra csr lingkungan indonesia',
            'komunitas relawan bandung',
        ];

        $devices = [
            ['type' => 'Mobile', 'os' => 'Android', 'browser' => 'Chrome', 'weight' => 48],
            ['type' => 'Mobile', 'os' => 'iOS', 'browser' => 'Safari', 'weight' => 18],
            ['type' => 'Desktop', 'os' => 'Windows 10/11', 'browser' => 'Chrome', 'weight' => 18],
            ['type' => 'Desktop', 'os' => 'Windows 10/11', 'browser' => 'Edge', 'weight' => 7],
            ['type' => 'Desktop', 'os' => 'macOS', 'browser' => 'Safari', 'weight' => 4],
            ['type' => 'Tablet', 'os' => 'Android', 'browser' => 'Chrome', 'weight' => 3],
            ['type' => 'Tablet', 'os' => 'iOS', 'browser' => 'Safari', 'weight' => 2],
        ];

        $locations = [
            ['province' => 'Jawa Barat', 'city' => 'Bandung', 'weight' => 22],
            ['province' => 'Jawa Barat', 'city' => 'Sukabumi', 'weight' => 14],
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Selatan', 'weight' => 12],
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Pusat', 'weight' => 10],
            ['province' => 'Jawa Barat', 'city' => 'Bogor', 'weight' => 8],
            ['province' => 'Jawa Barat', 'city' => 'Cianjur', 'weight' => 6],
            ['province' => 'Jawa Timur', 'city' => 'Surabaya', 'weight' => 7],
            ['province' => 'Jawa Tengah', 'city' => 'Semarang', 'weight' => 6],
            ['province' => 'Banten', 'city' => 'Tangerang', 'weight' => 5],
            ['province' => 'Jawa Tengah', 'city' => 'Solo', 'weight' => 4],
            ['province' => 'Bali', 'city' => 'Denpasar', 'weight' => 3],
            ['province' => 'Sumatera Utara', 'city' => 'Medan', 'weight' => 3],
        ];

        $helperPick = function(array $weightedList) {
            $totalWeight = array_sum(array_column($weightedList, 'weight'));
            $rand = mt_rand(1, $totalWeight);
            $current = 0;
            foreach ($weightedList as $item) {
                $current += $item['weight'];
                if ($rand <= $current) {
                    return $item;
                }
            }
            return $weightedList[0];
        };

        $logs = [];
        $now = Carbon::now();

        // Generate logs for the past 30 days
        for ($daysAgo = 30; $daysAgo >= 0; $daysAgo--) {
            $date = $now->copy()->subDays($daysAgo);
            // Dynamic daily volume with slight growth trend
            $baseVisits = 65 + (30 - $daysAgo) * 2;
            $dailyVisits = mt_rand($baseVisits - 15, $baseVisits + 25);
            $dailySessions = [];

            // Generate ~50-80 unique visitors per day
            $uniqueCount = (int) ($dailyVisits * 0.65);
            for ($s = 0; $s < $uniqueCount; $s++) {
                $dailySessions[] = Str::random(32);
            }

            for ($v = 0; $v < $dailyVisits; $v++) {
                $sessionId = $dailySessions[array_rand($dailySessions)];
                $page = $helperPick($pages);
                $ref = $helperPick($referers);
                $dev = $helperPick($devices);
                $loc = $helperPick($locations);

                // Assign keyword occasionally if organic search
                $kw = null;
                if ($ref['domain'] === 'www.google.com' && mt_rand(1, 100) <= 65) {
                    $kw = $keywords[array_rand($keywords)];
                }

                $hour = mt_rand(6, 23);
                $minute = mt_rand(0, 59);
                $second = mt_rand(0, 59);
                $timestamp = $date->copy()->setTime($hour, $minute, $second);

                $logs[] = [
                    'session_id' => $sessionId,
                    'ip_address' => '180.252.' . mt_rand(10, 240) . '.' . mt_rand(2, 250),
                    'url' => 'https://lintasan.or.id' . $page['path'],
                    'path' => $page['path'],
                    'page_title' => $page['title'],
                    'referer' => $ref['url'],
                    'referer_domain' => $ref['domain'],
                    'keyword' => $kw,
                    'device_type' => $dev['type'],
                    'browser' => $dev['browser'],
                    'operating_system' => $dev['os'],
                    'country' => 'Indonesia',
                    'province' => $loc['province'],
                    'city' => $loc['city'],
                    'utm_source' => ($ref['domain'] === 'l.instagram.com') ? 'instagram' : null,
                    'utm_medium' => ($ref['domain'] === 'l.instagram.com') ? 'social_bio' : null,
                    'utm_campaign' => ($ref['domain'] === 'l.instagram.com') ? 'program_pesisir' : null,
                    'visited_at' => $timestamp,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];

                // Insert in batches of 500
                if (count($logs) >= 500) {
                    VisitorLog::insert($logs);
                    $logs = [];
                }
            }
        }

        if (!empty($logs)) {
            VisitorLog::insert($logs);
        }
    }
}
