<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Visi, Misi, & About Settings
        Setting::updateOrCreate(
            ['key' => 'about_profile'],
            [
                'value_id' => 'berkomitmen untuk membangun kolaborasi yang inklusif dan transparan, meningkatkan edukasi kesiapsiagaan bencana, serta menghadirkan inovasi teknologi tepat guna dan konservasi bakau demi kemandirian masyarakat pesisir secara berkelanjutan.',
                'value_en' => 'committed to building inclusive and transparent collaboration, enhancing disaster preparedness education, and delivering appropriate technological innovation and mangrove conservation for the sustainable independence of coastal communities.',
                'type' => 'textarea'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'about_pillar_kolaborasi'],
            [
                'value_id' => 'Membangun kerja sama lintas sektor antara masyarakat, relawan, lembaga pemerintah, swasta, dan komunitas lokal untuk menciptakan ketangguhan wilayah pesisir secara berkelanjutan.',
                'value_en' => 'Building cross-sector cooperation between communities, volunteers, government agencies, private sectors, and local communities to create sustainable coastal resilience.',
                'type' => 'textarea'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'about_pillar_edukasi'],
            [
                'value_id' => 'Memberikan pengetahuan kesiapsiagaan bencana (SPAB), kesadaran konservasi ekosistem bakau, serta keahlian vokasi agar masyarakat pesisir tangguh, mandiri, dan bijak.',
                'value_en' => 'Providing disaster preparedness knowledge (SPAB), mangrove ecosystem conservation awareness, and vocational skills to make coastal communities resilient, independent, and wise.',
                'type' => 'textarea'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'about_pillar_inovasi'],
            [
                'value_id' => 'Menghadirkan solusi baru dan tepat guna, seperti solar freezer / pendingin bertenaga surya untuk nelayan, serta digitalisasi pengelolaan dan pemasaran hasil tangkapan laut.',
                'value_en' => 'Delivering new and appropriate solutions, such as solar-powered freezers for fishermen, and digitalization of seafood catch management and marketing.',
                'type' => 'textarea'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'about_pillar_transparansi'],
            [
                'value_id' => 'Menjunjung tinggi akuntabilitas dalam setiap proses. Keterbukaan informasi program dan laporan keuangan menjadi dasar kepercayaan antara yayasan, masyarakat, dan mitra kolaborasi.',
                'value_en' => 'Upholding accountability in every process. Open program information and financial reporting are the foundation of trust between the foundation, communities, and collaboration partners.',
                'type' => 'textarea'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'about_conclusion'],
            [
                'value_id' => "Keempat pilar ini saling berkaitan dan saling menguatkan:\n\nKolaborasi memperkuat jaringan kerja dan dukungan lintas sektor.\nEdukasi memperkuat kapasitas masyarakat dan mendorong kemandirian.\nInovasi memperkuat dampak dan efektivitas program di lapangan.\nTransparansi memperkuat kepercayaan publik serta integritas lembaga.\n\nDengan empat pilar ini, Yayasan LINTASAN hadir sebagai lembaga sosial yang berdaya, terpercaya, dan berdampak nyata dalam menjaga kelestarian pesisir serta mendampingi komunitas nelayan di wilayah dampingan.",
                'value_en' => "These four pillars are interrelated and reinforce each other:\n\nCollaboration strengthens networks and cross-sector support.\nEducation strengthens community capacity and encourages independence.\nInnovation strengthens program impact and effectiveness in the field.\nTransparency strengthens public trust and integrity of the institution.\n\nWith these four pillars, LINTASAN Foundation stands as an empowered, trusted, and impactful social institution in preserving coastal areas and accompanying fishermen in our partner communities.",
                'type' => 'textarea'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'about_visi'],
            [
                'value_id' => 'Menjadi yayasan yang berdaya, inklusif, dan berdampak dalam melestarikan ekosistem pesisir serta memberdayakan komunitas nelayan dan masyarakat desa mitra melalui kolaborasi, edukasi, dan inovasi.',
                'value_en' => 'To be an empowered, inclusive, and impactful foundation in preserving coastal ecosystems and empowering fishermen and partner village communities through collaboration, education, and innovation.',
                'type' => 'textarea'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'about_misi'],
            [
                'value_id' => "Melaksanakan mitigasi bencana tsunami dan perlindungan ekosistem pesisir melalui konservasi hutan bakau secara berkelanjutan.\nMemberdayakan masyarakat nelayan dan pesisir melalui penyediaan teknologi tepat guna seperti solar freezer serta digitalisasi pemasaran hasil laut.\nMembangun kolaborasi aktif dengan pemerintah, komunitas lokal, relawan, dan mitra strategis dalam menjaga kelestarian lanskap pesisir.\nMenyelenggarakan edukasi kesiapsiagaan bencana (SPAB) dan pelatihan keahlian vokasi untuk meningkatkan kemandirian masyarakat dampingan.\nMenyelenggarakan keterbukaan informasi dan akuntabilitas dalam tata kelola program demi kepercayaan publik dan integritas lembaga.",
                'value_en' => "Implement tsunami mitigation and coastal ecosystem protection through sustainable mangrove conservation.\nEmpower fishing and coastal communities through the provision of appropriate technology such as solar freezers and digitalization of seafood marketing.\nBuild active collaboration with the government, local communities, volunteers, and strategic partners in preserving coastal landscapes.\nOrganize disaster preparedness education (SPAB) and vocational skills training to enhance the independence of assisted communities.\nConduct open information and accountability in program management for public trust and institutional integrity.",
                'type' => 'textarea'
            ]
        );

        // 2. Meta Default Settings
        Setting::updateOrCreate(
            ['key' => 'meta_default_title'],
            [
                'value_id' => 'Yayasan LINTASAN - Dari Pesisir Untuk Indonesia',
                'value_en' => 'Yayasan LINTASAN - From Coasts to Indonesia',
                'type' => 'text'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'meta_default_desc'],
            [
                'value_id' => 'Yayasan LINTASAN - Membangun Ketangguhan Pesisir Indonesia melalui Pendidikan SPAB, Tabur Laut, Vokasi SMK, dan Reboisasi Hutan Mangrove.',
                'value_en' => 'Yayasan LINTASAN - Building Coastal Resilience of Indonesia through SPAB Education, Tabur Laut, SMK Vocation, and Mangrove Reforestation.',
                'type' => 'text'
            ]
        );

        // 3. Menu Navigation Settings
        Setting::updateOrCreate(
            ['key' => 'menu_home'],
            [
                'value_id' => 'Beranda',
                'value_en' => 'Home',
                'type' => 'text'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'menu_programs_impact'],
            [
                'value_id' => 'Program & Dampak',
                'value_en' => 'Programs & Impact',
                'type' => 'text'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'menu_program'],
            [
                'value_id' => 'Program',
                'value_en' => 'Program',
                'type' => 'text'
            ]
        );
    }
}
