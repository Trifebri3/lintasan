<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Story;
use App\Models\Statistic;
use App\Models\Partner;
use App\Models\Village;
use App\Models\Volunteer;
use App\Models\HeroImage;
use App\Models\Setting;
use App\Models\Gallery;

class LINTASANDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Programs
        Program::create([
            'title' => 'SPAB (Sekolah Aman Bencana)',
            'description' => 'Membangun budaya sadar bencana di sekolah dan masyarakat.',
            'icon' => 'fa-shield-halved',
            'color_class' => 'bg-brand-orange',
            'text_color' => 'text-brand-orange',
            'image_url' => 'https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?auto=format&fit=crop&w=400&q=80',
            'link' => '/program/1'
        ]);

        Program::create([
            'title' => 'Tabur Laut',
            'description' => 'Penguatan ekonomi nelayan melalui pendampingan usaha dan inovasi.',
            'icon' => 'fa-fish',
            'color_class' => 'bg-emerald-600',
            'text_color' => 'text-emerald-700',
            'image_url' => 'https://images.unsplash.com/photo-1534685780516-6583b984c7f5?auto=format&fit=crop&w=400&q=80',
            'link' => '/program/2'
        ]);

        Program::create([
            'title' => 'SMK Bisa! SMK Jago!',
            'description' => 'Meningkatkan kompetensi siswa SMK agar siap kerja dan berdaya saing.',
            'icon' => 'fa-laptop-code',
            'color_class' => 'bg-blue-600',
            'text_color' => 'text-blue-700',
            'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=400&q=80',
            'link' => '/program/3'
        ]);

        Program::create([
            'title' => 'Hutan Anak Negeri',
            'description' => 'Gerakan menanam dan merawat hutan untuk masa depan bumi yang lebih baik.',
            'icon' => 'fa-tree',
            'color_class' => 'bg-green-700',
            'text_color' => 'text-green-700',
            'image_url' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=400&q=80',
            'link' => '/program/4'
        ]);

        Program::create([
            'title' => 'Kesehatan Masyarakat',
            'description' => 'Pemeriksaan kesehatan dan edukasi hidup sehat bagi komunitas.',
            'icon' => 'fa-heart-pulse',
            'color_class' => 'bg-rose-600',
            'text_color' => 'text-rose-600',
            'image_url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=400&q=80',
            'link' => '/program/5'
        ]);

        // 2. Seed Stories with Full Content and Optional Impact Numbers
        Story::create([
            'title_id' => 'Siap Siaga, Selamat Bersama',
            'title_en' => 'Be Prepared, Save Lives Together',
            'category_id' => 'SPAB Cijayana',
            'category_en' => 'SPAB Cijayana',
            'category_bg' => 'bg-orange-100',
            'category_color' => 'text-brand-orange',
            'description_id' => 'Pelatihan SPAB mengajarkan siswa dan warga untuk kesiapsiagaan bencana.',
            'description_en' => 'Disaster school training empowers teachers and students in south Garut coastal regions.',
            'content_id' => '<p>Program Sekolah Aman Bencana (SPAB) di Cijayana dirancang untuk mengantisipasi potensi bencana alam yang sering mengancam wilayah pesisir Jawa Barat. Lewat program ini, Yayasan LINTASAN memberikan pelatihan mitigasi bencana terpadu kepada guru, siswa, dan masyarakat sekitar sekolah.</p><p>Pelatihan meliputi pemetaan risiko bencana, pembuatan jalur evakuasi, penyusunan rencana kesiapsiagaan darurat sekolah, hingga simulasi evakuasi mandiri saat terjadi gempa bumi dan tsunami.</p><p>Melalui kolaborasi intensif dengan Badan Penanggulangan Bencana Daerah (BPBD), program ini diharapkan dapat menumbuhkan budaya sadar bencana sejak dini demi menyelamatkan generasi masa depan bangsa.</p>',
            'content_en' => '<p>The Disaster Preparedness School (SPAB) program in Cijayana is designed to anticipate natural disaster potentials that often threaten the southern coast of West Java. Through this program, LINTASAN Foundation provides integrated disaster mitigation training to teachers, students, and communities surrounding schools.</p><p>Training includes disaster risk mapping, evacuation path creation, school emergency preparedness planning, to self-evacuation simulations during earthquakes and tsunami warnings.</p><p>Through intensive collaboration with the Regional Disaster Management Agency (BPBD), this program is expected to grow disaster-aware cultures from an early age to save the future generations of the nation.</p>',
            'gallery' => [
                'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=400&q=80', 
                'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=400&q=80', 
                'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=400&q=80'
            ],
            'views' => 324,
            'impact_number' => '450+',
            'impact_label_id' => 'Siswa & Guru Terlatih',
            'impact_label_en' => 'Students & Teachers Trained',
            'image_url' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=500&q=80',
            'link' => '/cerita-dampak/1'
        ]);

        Story::create([
            'title_id' => 'Nelayan Kuat, Ekonomi Naik',
            'title_en' => 'Stronger Fishermen, Rising Income',
            'category_id' => 'Tabur Laut',
            'category_en' => 'Tabur Laut',
            'category_bg' => 'bg-emerald-100',
            'category_color' => 'text-emerald-700',
            'description_id' => 'Pendampingan freezer komunitas membantu nelayan meningkatkan pendapatan.',
            'description_en' => 'Community cold storage guidance lifts fishermen revenues on Pangandaran coasts.',
            'content_id' => '<p>Wilayah pesisir memiliki potensi perikanan yang luar biasa, namun nelayan tradisional seringkali mengalami kerugian akibat sistem penyimpanan ikan hasil tangkapan yang kurang memadai. Program Tabur Laut dari Yayasan LINTASAN hadir memberikan solusi konkret.</p><p>Kami memfasilitasi pengadaan freezer bertenaga surya untuk komunitas nelayan pesisir, serta memberikan pelatihan manajemen bisnis, teknik pengemasan higienis, dan pemasaran digital.</p><p>Kini, nelayan dapat menyimpan hasil tangkapan lebih lama tanpa khawatir membusuk, serta menjual ikan dengan harga yang lebih stabil dan adil ke pasar regional.</p>',
            'content_en' => '<p>Coastal regions have extraordinary fisheries potential, but traditional fishermen often experience losses due to inadequate fish preservation systems. The Tabur Laut program from LINTASAN Foundation comes to offer concrete solutions.</p><p>We facilitate solar-powered community freezers for coastal fishermen, and provide business management training, hygienic packaging techniques, and digital marketing skills.</p><p>Now, fishermen can store their catch longer without worrying about rotting, and sell fresh fish at a more stable and fair price to the regional markets.</p>',
            'gallery' => [
                'https://images.unsplash.com/photo-1516715094727-ec48be335d79?auto=format&fit=crop&w=400&q=80', 
                'https://images.unsplash.com/photo-1534685780516-6583b984c7f5?auto=format&fit=crop&w=400&q=80', 
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=400&q=80'
            ],
            'views' => 142,
            'impact_number' => '150',
            'impact_label_id' => 'Nelayan Binaan Aktif',
            'impact_label_en' => 'Active Assisted Fishermen',
            'image_url' => 'https://images.unsplash.com/photo-1516715094727-ec48be335d79?auto=format&fit=crop&w=500&q=80',
            'link' => '/cerita-dampak/2'
        ]);

        Story::create([
            'title_id' => 'Belajar Hari Ini, Sukses Esok Hari',
            'title_en' => 'Learn Today, Succeed Tomorrow',
            'category_id' => 'SMK Bisa! SMK Jago!',
            'category_en' => 'SMK Success',
            'category_bg' => 'bg-blue-100',
            'category_color' => 'text-blue-700',
            'description_id' => 'Siswa SMK lebih percaya diri dan siap kerja berkat pelatihan praktis.',
            'description_en' => 'Vocational students feel more confident and job-ready after industrial internship placements.',
            'content_id' => '<p>Menjawab tantangan tingginya angka pengangguran lulusan SMK di daerah pesisir, program SMK Bisa! SMK Jago! menghadirkan kolaborasi antara sekolah dengan dunia industri.</p><p>Yayasan LINTASAN memfasilitasi kurikulum berbasis industri, menyelenggarakan program magang terstruktur, serta memberikan sertifikasi kompetensi keahlian dan pembekalan soft skills berupa public speaking dan adaptasi dunia kerja.</p><p>Hasilnya, kepercayaan diri siswa meningkat pesat, dan banyak dari lulusan langsung terserap bekerja di berbagai perusahaan mitra nasional maupun membangun usaha mandiri.</p>',
            'content_en' => '<p>Answering the challenge of high unemployment rates for vocational school (SMK) graduates in coastal areas, the SMK Bisa! SMK Jago! program brings collaboration between schools and the industrial world.</p><p>LINTASAN Foundation facilitates industrial-based curricula, organizes structured internship placements, and provides competence certifications along with soft skills coaching such as public speaking and workplace adaptability.</p><p>As a result, vocational students confidence has grown significantly, and many of the graduates are immediately hired in various national partner corporations or launch their own independent businesses.</p>',
            'gallery' => [
                'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=400&q=80', 
                'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=400&q=80', 
                'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=400&q=80'
            ],
            'views' => 219,
            'impact_number' => '85%',
            'impact_label_id' => 'Lulusan Langsung Bekerja',
            'impact_label_en' => 'Graduates Directly Hired',
            'image_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=500&q=80',
            'link' => '/cerita-dampak/3'
        ]);

        Story::create([
            'title_id' => 'Menanam Harapan, Menjaga Bumi',
            'title_en' => 'Planting Hope, Shielding the Earth',
            'category_id' => 'Hutan Anak Negeri',
            'category_en' => 'National Forest',
            'category_bg' => 'bg-green-100',
            'category_color' => 'text-green-700',
            'description_id' => 'Gerakan menanam pohon untuk kelestarian lingkungan dan masa depan.',
            'description_en' => 'Youth-led mangrove planting protects utara Bekasi coastal areas against abrasion.',
            'content_id' => '<p>Abrasi pantai dan kerusakan ekosistem mangrove di pesisir menjadi ancaman serius bagi kelestarian alam serta pemukiman warga. Lewat gerakan Hutan Anak Negeri, Yayasan LINTASAN mengajak generasi muda bergerak bersama memulihkan alam pesisir.</p><p>Kami berkolaborasi dengan komunitas lokal dan sukarelawan untuk melakukan penanaman bibit mangrove dan pohon pelindung pantai secara berkala di area rawan abrasi.</p><p>Tidak hanya menanam, program ini juga mencakup pemantauan berkala dan edukasi konservasi lingkungan untuk memastikan pohon-pohon yang ditanam dapat tumbuh subur dan memberikan meraih kelestarian lingkungan.</p>',
            'content_en' => '<p>Coastal erosion and mangrove ecosystem damage on northern coasts are serious threats to environmental conservation and residents settlements. Through the Hutan Anak Negeri movement, LINTASAN Foundation invites the youth to work together in restoring coastal nature.</p><p>We collaborate closely with local forestry departments, environmental communities, and hundreds of volunteers to perform regular plantings and maintain nurseries of more than 5,000 mangrove seedlings.</p><p>Not only planting, this program also includes periodic monitoring and ecological preservation education to ensure that the trees planted can grow healthily and provide long-term environmental protection.</p>',
            'gallery' => [
                'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=400&q=80', 
                'https://images.unsplash.com/photo-1530587191325-3db32d826c18?auto=format&fit=crop&w=400&q=80', 
                'https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=400&q=80'
            ],
            'views' => 405,
            'impact_number' => '5.000+',
            'impact_label_id' => 'Bibit Mangrove Ditanam',
            'impact_label_en' => 'Mangrove Seedlings Planted',
            'image_url' => 'https://images.unsplash.com/photo-1530587191325-3db32d826c18?auto=format&fit=crop&w=500&q=80',
            'link' => '/cerita-dampak/4'
        ]);

        // 3. Seed Statistics
        // Quick Stats for Floating Bar on Hero
        Statistic::create([
            'group' => 'quick_stats',
            'key' => 'desa_dampingan',
            'value' => '15+',
            'label' => 'Desa Dampingan',
            'icon' => 'fa-home',
            'color_class' => 'text-brand-orange bg-orange-50',
            'sort_order' => 1
        ]);
        Statistic::create([
            'group' => 'quick_stats',
            'key' => 'penerima_manfaat',
            'value' => '3.200+',
            'label' => 'Penerima Manfaat',
            'icon' => 'fa-users',
            'color_class' => 'text-brand-green bg-green-50',
            'sort_order' => 2
        ]);
        Statistic::create([
            'group' => 'quick_stats',
            'key' => 'mitra_kolaborasi',
            'value' => '50+',
            'label' => 'Mitra Kolaborasi',
            'icon' => 'fa-handshake',
            'color_class' => 'text-teal-600 bg-teal-50',
            'sort_order' => 3
        ]);
        Statistic::create([
            'group' => 'quick_stats',
            'key' => 'program_berjalan',
            'value' => '20+',
            'label' => 'Program Berjalan',
            'icon' => 'fa-tasks',
            'color_class' => 'text-blue-600 bg-blue-50',
            'sort_order' => 4
        ]);

        // Connected Impact Stats (Green Counter Bar)
        Statistic::create([
            'group' => 'connected_impact',
            'key' => 'sekolah_terjangkau',
            'value' => '40',
            'label' => 'Sekolah Terjangkau',
            'icon' => 'fa-school',
            'sort_order' => 1
        ]);
        Statistic::create([
            'group' => 'connected_impact',
            'key' => 'desa_dampingan',
            'value' => '15',
            'label' => 'Desa Dampingan',
            'icon' => 'fa-house-chimney',
            'sort_order' => 2
        ]);
        Statistic::create([
            'group' => 'connected_impact',
            'key' => 'relawan_terlibat',
            'value' => '120',
            'label' => 'Relawan Terlibat',
            'icon' => 'fa-user-group',
            'sort_order' => 3
        ]);
        Statistic::create([
            'group' => 'connected_impact',
            'key' => 'mitra_kolaborasi',
            'value' => '50',
            'label' => 'Mitra Kolaborasi',
            'icon' => 'fa-handshake',
            'sort_order' => 4
        ]);
        Statistic::create([
            'group' => 'connected_impact',
            'key' => 'penerima_manfaat',
            'value' => '3.200',
            'label' => 'Penerima Manfaat',
            'icon' => 'fa-users',
            'sort_order' => 5
        ]);
        Statistic::create([
            'group' => 'connected_impact',
            'key' => 'program_berjalan',
            'value' => '20',
            'label' => 'Program Berjalan',
            'icon' => 'fa-tasks',
            'sort_order' => 6
        ]);

        // 4. Seed Partners (Using Abstract Logotype Image URLs - Required Logo constraint)
        Partner::create([
            'name' => 'BAZNAS',
            'logo_icon' => 'fa-handshake',
            'logo_path' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=200&q=80',
            'sort_order' => 1
        ]);
        Partner::create([
            'name' => 'Dinas Pendidikan Jawa Barat',
            'logo_icon' => 'fa-handshake',
            'logo_path' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&w=200&q=80',
            'sort_order' => 2
        ]);
        Partner::create([
            'name' => 'PUSKESMAS',
            'logo_icon' => 'fa-handshake',
            'logo_path' => 'https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=200&q=80',
            'sort_order' => 3
        ]);
        Partner::create([
            'name' => 'Sekolah Mitra',
            'logo_icon' => 'fa-handshake',
            'logo_path' => 'https://images.unsplash.com/photo-1618005198143-e5283464403f?auto=format&fit=crop&w=200&q=80',
            'sort_order' => 4
        ]);
        Partner::create([
            'name' => 'Komunitas Pesisir',
            'logo_icon' => 'fa-handshake',
            'logo_path' => 'https://images.unsplash.com/photo-1620641788276-888f4b0051e9?auto=format&fit=crop&w=200&q=80',
            'sort_order' => 5
        ]);
        Partner::create([
            'name' => 'CSR Perusahaan',
            'logo_icon' => 'fa-handshake',
            'logo_path' => 'https://images.unsplash.com/photo-1557683311-eac922347aa1?auto=format&fit=crop&w=200&q=80',
            'sort_order' => 6
        ]);

        // 5. Seed Partner Villages (Desa Mitra Lintasan)
        Village::create([
            'name' => 'Desa Cijayana',
            'slug' => 'desa-cijayana-garut',
            'location' => 'Garut, Jawa Barat',
            'description' => 'Desa mitra lintasan dengan program mitigasi kebencanaan tsunami dan Sekolah Aman Bencana (SPAB) pesisir selatan.',
            'narrative' => '<p>Desa Cijayana yang terletak di pesisir selatan Kabupaten Garut memiliki potensi perikanan dan pariwisata yang sangat indah. Namun, kondisi geografisnya yang berhadapan langsung dengan Samudra Hindia menempatkannya pada risiko tinggi terhadap potensi gempa bumi megathrust dan tsunami.</p><p>Yayasan LINTASAN bekerjasama dengan sekolah setempat merintis program Sekolah Aman Bencana (SPAB). Di sini, kami memberikan pembekalan teoritis maupun simulasi fisik rutin kepada para siswa dan warga sekitar mengenai bagaimana bersikap siaga dan mengevakuasi diri secara mandiri dalam waktu kurang dari 15 menit setelah peringatan dini berbunyi.</p><p>Kami juga membantu pemetaan jalur evakuasi aman menuju bukit penampung darurat dan mendirikan plang-plang evakuasi bertenaga surya agar tetap terlihat jelas di malam hari.</p>',
            'image_path' => 'https://images.unsplash.com/photo-1594608661623-aa0bd3a69d98?auto=format&fit=crop&w=600&q=80',
            'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15822.457850022237!2d107.69747514336081!3d-7.50854497746401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e680a6b2bbbbbbb%3A0x6735e0766cc6efbb!2sCijayana%2C%20Kec.%20Cikelet%2C%20Kabupaten%20Garut%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="350" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy"></iframe>',
            'latitude' => -7.50854498,
            'longitude' => 107.69747514
        ]);

        Village::create([
            'name' => 'Pesisir Pangandaran',
            'slug' => 'pesisir-pangandaran',
            'location' => 'Pangandaran, Jawa Barat',
            'description' => 'Pusat pendampingan pengolahan hasil tangkapan laut dan pemberdayaan ekonomi perempuan.',
            'narrative' => '<p>Pangandaran dikenal sebagai salah satu destinasi wisata utama, namun kehidupan di luar garis pantai wisatanya dipenuhi nelayan tradisional yang serba terbatas. Yayasan LINTASAN meluncurkan program Tabur Laut di daerah binaan ini guna mendampingi kelompok ibu-ibu istri nelayan.</p><p>Kami memberikan pembekalan pelatihan pengolahan ikan pasca tangkap untuk dijadikan abon ikan berkualitas tinggi, dendeng asin, serta kerupuk ikan kemasan higienis yang bernilai jual tinggi. Di samping itu, kami menyalurkan bantuan lemari pendingin (solar freezer) bertenaga surya agar ikan segar tangkapan nelayan tidak terbuang sia-sia saat harga pasar anjlok.</p>',
            'image_path' => 'https://images.unsplash.com/photo-1534685780516-6583b984c7f5?auto=format&fit=crop&w=600&q=80',
            'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63259.04351654316!2d108.62534599557762!3d-7.682672583804825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e65bbf11e6bbbbb%3A0x334468f766e4a2c!2sPangandaran%2C%20Kec.%20Pangandaran%2C%20Kabupaten%20Pangandaran%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="350" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy"></iframe>',
            'latitude' => -7.68267258,
            'longitude' => 108.62534599
        ]);

        Village::create([
            'name' => 'Pesisir Muara Gembong',
            'slug' => 'pesisir-muara-gembong',
            'location' => 'Bekasi, Jawa Barat',
            'description' => 'Kawasan pelestarian hutan bakau (mangrove) dan edukasi kelestarian pesisir pantai utara.',
            'narrative' => '<p>Muara Gembong adalah salah satu titik terluar di utara Kabupaten Bekasi yang terus-menerus terancam oleh abrasi pantai utara Jawa. Setiap tahunnya, puluhan hektar tanah hilang ditelan air laut. Menanggapi ancaman krisis iklim ini, Yayasan LINTASAN menginisiasi gerakan Hutan Anak Negeri di wilayah ini.</p><p>Kami berkolaborasi erat dengan dinas kehutanan setempat, komunitas pecinta alam, dan ratusan relawan untuk menanam serta menjaga pembibitan lebih dari 5.000 bibit pohon bakau (mangrove). Ekosistem bakau yang rapat terbukti sangat efektif memecah ombak laut, menahan abrasi, serta mengembalikan habitat asli kepiting bakau dan burung migran yang menjadi sumber penghidupan warga sekitar.</p>',
            'image_path' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=600&q=80',
            'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63495.14815456247!2d107.00806497258849!3d-5.960938472935272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a2bbaaaaaaaab%3A0xe54e38c7f9999999!2sMuara%20Gembong%2C%20Bekasi%20Regency%2C%20West%20Java!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="350" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy"></iframe>',
            'latitude' => -5.96093847,
            'longitude' => 107.00806497
        ]);

        // 6. Seed Active Volunteers for Directory
        Volunteer::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@lintasan.org',
            'phone' => '+62 82116108483',
            'role' => 'Koordinator Lapangan SPAB',
            'photo_path' => null,
            'status' => 'aktif',
            'address' => 'Bandung, Jawa Barat',
            'motivation' => 'Ingin berkontribusi nyata untuk mendidik kesiapsiagaan bencana bagi anak-anak sekolah pesisir.'
        ]);

        Volunteer::create([
            'name' => 'Siti Rahma',
            'email' => 'siti@lintasan.org',
            'phone' => '+62 81324451423',
            'role' => 'Fasilitator Vokasi SMK Kelautan',
            'photo_path' => null,
            'status' => 'aktif',
            'address' => 'Bandung, Jawa Barat',
            'motivation' => 'Memiliki kecintaan pada dunia pengajaran dan pendampingan keterampilan industri.'
        ]);

        Volunteer::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@lintasan.org',
            'phone' => '+62 85860423496',
            'role' => 'Relawan Konservasi Hutan Mangrove',
            'photo_path' => null,
            'status' => 'aktif',
            'address' => 'Bekasi, Jawa Barat',
            'motivation' => 'Bertekad menyelamatkan pesisir Muara Gembong dari bencana abrasi pantai.'
        ]);

        // 7. Seed Admin and Contributor Users
        \App\Models\User::create([
            'name' => 'Administrator LINTASAN',
            'email' => 'official@lintasan.or.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Contributor LINTASAN',
            'email' => 'contributor@lintasan.org',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'contributor',
        ]);

        // 8. Seed Dynamic Hero Slider Slides
        HeroImage::create([
            'image_path' => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=1920&q=80',
            'title_id' => 'Untuk Indonesia yang Lebih Tangguh',
            'title_en' => 'For a More Resilient Indonesia',
            'subtitle_id' => 'Yayasan LINTASAN membangun ketangguhan masyarakat melalui pendidikan, kesiapsiagaan bencana, penguatan ekonomi, dan kolaborasi lintas sektor.',
            'subtitle_en' => 'LINTASAN Foundation builds community resilience through education, disaster preparedness, economic empowerment, and cross-sector collaboration.',
            'sort_order' => 1,
            'is_active' => true
        ]);

        HeroImage::create([
            'image_path' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1920&q=80',
            'title_id' => 'Pemberdayaan Sekolah Pesisir',
            'title_en' => 'Empowering Coastal Schools',
            'subtitle_id' => 'Melalui program Sekolah Aman Bencana (SPAB) demi keselamatan guru dan siswa pesisir.',
            'subtitle_en' => 'Through Disaster Preparedness School (SPAB) programs for the safety of coastal teachers and students.',
            'sort_order' => 2,
            'is_active' => true
        ]);

        HeroImage::create([
            'image_path' => 'https://images.unsplash.com/photo-1516715094727-ec48be335d79?auto=format&fit=crop&w=1920&q=80',
            'title_id' => 'Mengangkat Perekonomian Nelayan',
            'title_en' => 'Lifting Fisherman Economies',
            'subtitle_id' => 'Pendampingan kelompok nelayan, penyediaan solar freezer, dan pemasaran digital hasil laut.',
            'subtitle_en' => 'Guiding fishermen communities, solar freezer distribution, and digital marketing of catches.',
            'sort_order' => 3,
            'is_active' => true
        ]);

        // 9. Seed Settings (Dynamic About Page Contents)
        Setting::create([
            'key' => 'about_profile',
            'value_id' => 'berkomitmen untuk membangun kolaborasi yang inklusif dan transparan, meningkatkan edukasi melalui pengetahuan yang dibagikan secara terbuka, dan menciptakan inovasi yang berkelanjutan melalui proses yang jelas dan akuntabel.',
            'value_en' => 'committed to building inclusive and transparent collaboration, improving education through openly shared knowledge, and creating sustainable innovation through clear and accountable processes.',
            'type' => 'textarea'
        ]);

        Setting::create([
            'key' => 'about_pillar_kolaborasi',
            'value_id' => 'Membangun kerja sama lintas sektor antara masyarakat, relawan, lembaga pemerintah, swasta, dan komunitas lokal untuk menciptakan dampak sosial yang lebih luas dan berkelanjutan.',
            'value_en' => 'Building cross-sector cooperation between communities, volunteers, government agencies, private sectors, and local communities to create broader and sustainable social impact.',
            'type' => 'textarea'
        ]);

        Setting::create([
            'key' => 'about_pillar_edukasi',
            'value_id' => 'Memberikan pengetahuan, kesadaran, dan keterampilan kepada anak-anak dan masyarakat desa agar mampu menghadapi tantangan sosial dan bencana secara mandiri dan bijak.',
            'value_en' => 'Providing knowledge, awareness, and skills to children and village communities to enable them to face social and disaster challenges independently and wisely.',
            'type' => 'textarea'
        ]);

        Setting::create([
            'key' => 'about_pillar_inovasi',
            'value_id' => 'Menghadirkan solusi baru dan tepat guna dalam program sosial, pendidikan, dan mitigasi bencana yang kontekstual, kreatif, dan adaptif terhadap perubahan.',
            'value_en' => 'Delivering new and appropriate solutions in social, educational, and disaster mitigation programs that are contextual, creative, and adaptive to change.',
            'type' => 'textarea'
        ]);

        Setting::create([
            'key' => 'about_pillar_transparansi',
            'value_id' => 'Menjunjung tinggi akuntabilitas dalam setiap proses, dari perencanaan, pelaksanaan hingga pelaporan. Informasi terbuka menjadi dasar kepercayaan antara yayasan, masyarakat, dan mitra.',
            'value_en' => 'Upholding accountability in every process, from planning, execution to reporting. Open information is the foundation of trust between the foundation, society, and partners.',
            'type' => 'textarea'
        ]);

        Setting::create([
            'key' => 'about_conclusion',
            'value_id' => "Keempat pilar ini saling berkaitan dan saling menguatkan:\n\nKolaborasi memperkuat jaringan kerja dan dukungan lintas sektor.\nEdukasi memperkuat kapasitas masyarakat dan mendorong kemandirian.\nInovasi memperkuat dampak dan efektivitas program sosial dan kemanusiaan.\nTransparansi memperkuat kepercayaan publik serta integritas lembaga.\n\nDengan empat pilar ini, Yayasan Senyum Anak Negeri hadir sebagai lembaga sosial yang berdaya, terpercaya, dan berdampak nyata dalam melindungi anak dan memperkuat komunitas desa di wilayah rawan bencana.",
            'value_en' => "These four pillars are interrelated and reinforce each other:\n\nCollaboration strengthens networks and cross-sector support.\nEducation strengthens community capacity and encourages independence.\nInnovation strengthens the impact and effectiveness of social and humanitarian programs.\nTransparency strengthens public trust and institutional integrity.\n\nWith these four pillars, Senyum Anak Negeri Foundation stands as an empowered, trusted, and impactful social institution in protecting children and strengthening village communities in disaster-prone areas.",
            'type' => 'textarea'
        ]);

        Setting::create([
            'key' => 'about_visi',
            'value_id' => 'Menjadi yayasan yang berdaya, inklusif, dan berdampak dalam melindungi anak-anak serta memberdayakan komunitas desa di wilayah rawan bencana melalui kolaborasi, edukasi, dan inovasi.',
            'value_en' => 'To be an empowered, inclusive, and impactful foundation in protecting children and empowering village communities in disaster-prone areas through collaboration, education, and innovation.',
            'type' => 'textarea'
        ]);

        Setting::create([
            'key' => 'about_misi',
            'value_id' => "Melindungi dan memberdayakan anak-anak sebagai kelompok paling rentan dalam situasi sosial maupun bencana, melalui program perlindungan, pendidikan, dan pendampingan.\nMembangun kolaborasi aktif dengan pemerintah, masyarakat lokal, relawan, dan mitra strategis dalam pelaksanaan program sosial dan kemanusiaan di desa-desa rawan bencana\nMenyelenggarakan edukasi dan pelatihan yang berfokus pada kesiapsiagaan bencana, kesadaran lingkungan, dan penguatan kapasitas masyarakat desa.\nMeningkatkan kapasitas masyarakat dan merintis solusi inovatif berbasis lokalitas untuk mendukung kehidupan anak dan komunitas.\nMendorong partisipasi komunitas dalam setiap proses program agar tercipta rasa memiliki, keberlanjutan, dan kemandirian masyarakat.",
            'value_en' => "Protect and empower children as the most vulnerable group in social and disaster situations, through protection, education, and mentoring programs.\nBuild active collaboration with government, local communities, volunteers, and strategic partners in implementing social and humanitarian programs in disaster-prone villages.\nOrganize education and training focusing on disaster preparedness, environmental awareness, and village community capacity building.\nIncrease community capacity and pioneer local-based innovative solutions to support the lives of children and communities.\nEncourage community participation in every program process to create a sense of ownership, sustainability, and community independence.",
            'type' => 'textarea'
        ]);

        // Seed Galleries
        Gallery::create([
            'title_id' => 'Sosialisasi Sekolah Aman Bencana (SPAB) Cijayana',
            'title_en' => 'Disaster Preparedness School (SPAB) socialization in Cijayana',
            'type' => 'image',
            'image_path' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=600&q=80',
            'sort_order' => 1
        ]);

        Gallery::create([
            'title_id' => 'Pelatihan Evakuasi Mandiri Siswa Pesisir',
            'title_en' => 'Self-Evacuation Drill for Coastal Students',
            'type' => 'image',
            'image_path' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=600&q=80',
            'sort_order' => 2
        ]);

        Gallery::create([
            'title_id' => 'Video Profil Yayasan LINTASAN',
            'title_en' => 'Yayasan LINTASAN Profile Video',
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'youtube_id' => 'dQw4w9WgXcQ',
            'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'sort_order' => 3
        ]);

        Gallery::create([
            'title_id' => 'Pemberian Cold Storage Solar Bertenaga Surya bagi Nelayan',
            'title_en' => 'Solar Powered Cold Storage Support for Local Fishermen',
            'type' => 'image',
            'image_path' => 'https://images.unsplash.com/photo-1516715094727-ec48be335d79?auto=format&fit=crop&w=600&q=80',
            'sort_order' => 4
        ]);

        Gallery::create([
            'title_id' => 'Penanaman 5000 Pohon Mangrove Bersama Relawan Pesisir',
            'title_en' => 'Planting 5000 Mangrove Trees with Coastal Volunteers',
            'type' => 'image',
            'image_path' => 'https://images.unsplash.com/photo-1530587191325-3db32d826c18?auto=format&fit=crop&w=600&q=80',
            'sort_order' => 5
        ]);

        Gallery::create([
            'title_id' => 'Video Dokumentasi Pelatihan Mitigasi Bencana Sekolah',
            'title_en' => 'Video Documentation of School Disaster Mitigation Training',
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=9xwazD5SyVg',
            'youtube_id' => '9xwazD5SyVg',
            'embed_url' => 'https://www.youtube.com/embed/9xwazD5SyVg',
            'sort_order' => 6
        ]);
    }
}
