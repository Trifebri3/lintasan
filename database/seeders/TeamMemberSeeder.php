<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            // PENDIRI (FOUNDERS)
            [
                'name' => 'Dr. H. Bambang Soepriyatno, M.Si.',
                'category' => 'pendiri',
                'role_id' => 'Pendiri Yayasan & Pemerhati Kebijakan Pesisir',
                'role_en' => 'Founder & Coastal Policy Observer',
                'photo_path' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Mengawali inisiatif konservasi mangrove dan pemberdayaan pesisir sejak 2012. Berpengalaman lebih dari 20 tahun dalam advokasi tata kelola lingkungan dan pendampingan masyarakat nelayan tradisional di pantai utara Jawa.',
                'bio_en' => 'Initiated coastal empowerment and mangrove conservation since 2012. Has over 20 years of experience in environmental governance advocacy and community mentorship for traditional fisherfolk.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'bambang@lintasan.or.id',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Ir. Hj. Siti Nurjanah, M.Env.',
                'category' => 'pendiri',
                'role_id' => 'Pendiri Yayasan & Konsultan Ekologi Pesisir',
                'role_en' => 'Founder & Coastal Ecology Consultant',
                'photo_path' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Pakar pemulihan bentang alam pesisir dan pendidikan lingkungan usia dini. Menginisiasi modul Satuan Pendidikan Aman Bencana (SPAB) pesisir pertama yang kini diterapkan di berbagai sekolah mitra.',
                'bio_en' => 'Specialist in coastal landscape restoration and early environmental education. Initiated the coastal SPAB disaster safety module now applied in partner schools.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'siti.nurjanah@lintasan.or.id',
                'sort_order' => 2,
                'is_active' => true,
            ],

            // PEMBINA (ADVISORY BOARD)
            [
                'name' => 'Prof. Dr. Ir. Ahmad Sudrajat, M.Sc.',
                'category' => 'pembina',
                'role_id' => 'Ketua Dewan Pembina',
                'role_en' => 'Chairman of the Advisory Board',
                'photo_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Guru Besar Manajemen Wilayah Pesisir dan Kelautan. Memberikan arahan strategis, integritas kelembagaan, dan panduan riset aksi restorasi ekosistem laut bagi seluruh pilar program Yayasan LINTASAN.',
                'bio_en' => 'Professor in Coastal and Marine Resource Management. Provides strategic oversight, institutional integrity, and action research guidance for LINTASAN programs.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'ahmad.sudrajat@lintasan.or.id',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Dra. Ratna Kusuma Wardhani, M.Si.',
                'category' => 'pembina',
                'role_id' => 'Anggota Dewan Pembina (Pemberdayaan Perempuan)',
                'role_en' => 'Member of Advisory Board (Women Empowerment)',
                'photo_path' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Tokoh penggerak koperasi perempuan nelayan dan usaha mikro maritim. Membina perluasan dampak sosial ekonomi keluarga pesisir melalui diversifikasi olahan hasil tangkapan laut.',
                'bio_en' => 'Leading figure in fisherwomen cooperatives and maritime micro-enterprises. Mentors the socio-economic impact expansion of coastal families.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'ratna.wardhani@lintasan.or.id',
                'sort_order' => 4,
                'is_active' => true,
            ],

            // PENGAWAS (SUPERVISORY BOARD)
            [
                'name' => 'Drs. Hendro Wibowo, Ak., CA.',
                'category' => 'pengawas',
                'role_id' => 'Ketua Dewan Pengawas',
                'role_en' => 'Chairman of Supervisory Board',
                'photo_path' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Akuntan publik senior dengan pengalaman audit organisasi nirlaba selama lebih dari 25 tahun. Mengawal tata kelola keuangan, kepatuhan hukum, audit independen, dan transparansi publik Yayasan LINTASAN.',
                'bio_en' => 'Senior certified accountant with over 25 years auditing non-profits. Oversees financial governance, compliance, and public transparency for LINTASAN.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'hendro.wibowo@lintasan.or.id',
                'sort_order' => 5,
                'is_active' => true,
            ],

            // PENGURUS (EXECUTIVE BOARD / LEADERSHIP)
            [
                'name' => 'Fajar Pratama, S.T., M.M.',
                'category' => 'pengurus',
                'role_id' => 'Ketua Umum Yayasan (Executive Director)',
                'role_en' => 'Chairperson / Executive Director',
                'photo_path' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Memimpin operasional dan kemitraan strategis Yayasan LINTASAN secara nasional. Berfokus pada inovasi teknologi tepat guna seperti rantai dingin solar freezer dan kemitraan pentahelix lintas sektor.',
                'bio_en' => 'Leads national operations and strategic partnerships for LINTASAN. Focuses on appropriate technology innovations such as solar freezer cold chains and pentahelix partnerships.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'fajar.pratama@lintasan.or.id',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Anggraeni, S.Sos.',
                'category' => 'pengurus',
                'role_id' => 'Sekretaris Umum Yayasan',
                'role_en' => 'General Secretary',
                'photo_path' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Bertanggung jawab atas administrasi kelembagaan, kepatuhan regulasi, tata kelola relawan, dan komunikasi kesekretariatan mitra donor serta dinas terkait.',
                'bio_en' => 'Responsible for institutional administration, compliance, volunteer governance, and communication with donor partners and agencies.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'dewi.anggraeni@lintasan.or.id',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Rian Hidayat, S.E., Ak.',
                'category' => 'pengurus',
                'role_id' => 'Bendahara Yayasan',
                'role_en' => 'Treasurer',
                'photo_path' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Mengelola alokasi anggaran program, laporan akuntabilitas donasi publik, serta manajemen kepatuhan perpajakan dan keuangan yayasan secara berkala.',
                'bio_en' => 'Manages program budgeting, donation accountability reports, tax compliance, and transparent financial stewardship.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'rian.hidayat@lintasan.or.id',
                'sort_order' => 8,
                'is_active' => true,
            ],

            // TIM PELAKSANA (OPERATIONS & MANAGEMENT TEAM)
            [
                'name' => 'Budi Santoso, S.Kel.',
                'category' => 'tim',
                'role_id' => 'Koordinator Konservasi Bakau & Pesisir',
                'role_en' => 'Mangrove & Coastal Conservation Lead',
                'photo_path' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Ahli kelautan lapangan yang memimpin gerakan penanaman bibit mangrove, pemetaan zona abrasi pesisir, serta pembibitan bakau bersama warga di desa mitra.',
                'bio_en' => 'Marine field expert leading mangrove planting initiatives, coastal erosion mapping, and community nurseries in partner villages.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'budi.santoso@lintasan.or.id',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Anisa Rahmawati, S.Pd.',
                'category' => 'tim',
                'role_id' => 'Koordinator Edukasi Kebencanaan SPAB',
                'role_en' => 'SPAB Disaster Preparedness Lead',
                'photo_path' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Fasilitator utama pelatihan mitigasi bencana gempa bumi dan tsunami untuk sekolah-sekolah pesisir dan komunitas anak di wilayah rawan bencana.',
                'bio_en' => 'Lead facilitator for disaster preparedness, tsunami drills, and child resilience programs in coastal communities.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'anisa.rahma@lintasan.or.id',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Taufik Rahman, S.Kom.',
                'category' => 'tim',
                'role_id' => 'Spesialis Media & Kemitraan Digital',
                'role_en' => 'Media & Digital Partnerships Specialist',
                'photo_path' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=400&q=80',
                'bio_id' => 'Mengelola dokumentasi narasi lapangan, platform publikasi, transparansi laporan dampak digital, dan jejaring relawan kampanye konservasi maritim.',
                'bio_en' => 'Oversees field narrative documentation, digital publications, impact report transparency, and volunteer networks.',
                'social_linkedin' => 'https://linkedin.com',
                'social_email' => 'taufik.rahman@lintasan.or.id',
                'sort_order' => 11,
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name']],
                $member
            );
        }
    }
}

