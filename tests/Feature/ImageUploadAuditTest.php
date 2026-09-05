<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\HeroImage;
use App\Models\Village;
use App\Models\Volunteer;
use App\Helpers\ImageHelper;

class ImageUploadAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /**
     * Test 1: ImageHelper error code translation to Indonesian.
     */
    public function test_image_helper_error_translations(): void
    {
        $iniSizeError = ImageHelper::getUploadErrorMessage(UPLOAD_ERR_INI_SIZE, 'foto_besar.jpg');
        $this->assertStringContainsString('Ukuran berkas', $iniSizeError);
        $this->assertStringContainsString('melebihi batas maksimal server PHP', $iniSizeError);

        $noFileError = ImageHelper::getUploadErrorMessage(UPLOAD_ERR_NO_FILE, 'foto.jpg');
        $this->assertStringContainsString('Tidak ada berkas yang dipilih untuk diunggah', $noFileError);
    }

    /**
     * Test 2: ImageHelper compress, save and delete.
     */
    public function test_image_helper_compress_save_and_delete(): void
    {
        $file = UploadedFile::fake()->image('test_banner.jpg', 600, 400);
        $savedPath = ImageHelper::compressAndSave($file, 'testing', 'banner');

        $this->assertNotEmpty($savedPath);
        $this->assertStringContainsString('/storage/testing/', $savedPath);
        $this->assertStringContainsString('_banner_', $savedPath);

        $relative = str_replace('/storage/', '', $savedPath);
        Storage::disk('public')->assertExists($relative);

        // Delete test
        $deleted = ImageHelper::deleteFile($savedPath);
        $this->assertTrue($deleted);
        Storage::disk('public')->assertMissing($relative);
    }

    /**
     * Test 3: Public Volunteer Registration with Indonesian Validation Messages.
     */
    public function test_public_volunteer_validation_errors_in_indonesian(): void
    {
        $response = $this->post('/relawan/register', []);

        $response->assertSessionHasErrors([
            'name' => 'Nama lengkap wajib diisi.',
            'email' => 'Alamat email wajib diisi.',
            'phone' => 'Nomor WhatsApp / telepon wajib diisi.',
            'address' => 'Alamat tinggal saat ini wajib diisi.',
            'bio' => 'Cerita singkat / ide kolaborasi wajib diisi.',
        ]);
    }

    /**
     * Test 4: Public Volunteer Registration with invalid file type.
     */
    public function test_public_volunteer_invalid_file_type(): void
    {
        $pdfFile = UploadedFile::fake()->create('dokumen.pdf', 500, 'application/pdf');

        $response = $this->post('/relawan/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Kebon Jeruk No. 12',
            'bio' => 'Ingin berbagi',
            'photo' => $pdfFile,
        ]);

        $response->assertSessionHasErrors([
            'photo' => 'Berkas foto harus berupa gambar.',
        ]);
    }

    /**
     * Test 5: Public Volunteer Registration successful upload and save.
     */
    public function test_public_volunteer_successful_registration(): void
    {
        $photo = UploadedFile::fake()->image('relawan.jpg', 400, 400);

        $response = $this->post('/relawan/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 45 Bandung',
            'bio' => 'Ingin berbagi dengan anak-anak dan petani',
            'photo' => $photo,
        ]);

        $response->assertSessionHas('success');

        $volunteer = Volunteer::where('email', 'budi@example.com')->first();
        $this->assertNotNull($volunteer);
        $this->assertNotEmpty($volunteer->photo_path);

        $relative = str_replace('/storage/', '', $volunteer->photo_path);
        Storage::disk('public')->assertExists($relative);
    }

    /**
     * Test 6: Admin HeroImage creation, validation, and update fix.
     */
    public function test_admin_hero_image_crud_and_image_path_fix(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin_test@lintasan.org',
            'role' => 'admin',
        ]);

        // Validation test
        $response = $this->actingAs($admin)->post('/admin/hero-images', []);
        $response->assertSessionHasErrors([
            'image' => 'File gambar slide hero wajib diunggah.',
            'title_id' => 'Judul utama slogan (Bahasa Indonesia) wajib diisi.',
        ]);

        // Create with image
        $image = UploadedFile::fake()->image('hero1.jpg', 1200, 600);
        $storeResponse = $this->actingAs($admin)->post('/admin/hero-images', [
            'title_id' => 'Selamat Datang di Lintasan',
            'title_en' => 'Welcome to Lintasan',
            'subtitle_id' => 'Membangun masa depan bersama',
            'subtitle_en' => 'Building the future together',
            'sort_order' => 1,
            'is_active' => 1,
            'image' => $image,
        ]);

        $storeResponse->assertRedirect('/admin/hero-images');
        $storeResponse->assertSessionHas('success');

        $hero = HeroImage::first();
        $this->assertNotNull($hero);
        $this->assertNotEmpty($hero->image_path);
        $firstPath = $hero->image_path;

        // Verify update replaces image_path and cleans up old image
        $newImage = UploadedFile::fake()->image('hero2.png', 1200, 600);
        $updateResponse = $this->actingAs($admin)->put('/admin/hero-images/' . $hero->id, [
            'title_id' => 'Selamat Datang Diperbarui',
            'title_en' => 'Welcome Updated',
            'subtitle_id' => 'Subjudul baru',
            'subtitle_en' => 'New subtitle',
            'sort_order' => 2,
            'is_active' => 1,
            'image' => $newImage,
        ]);

        $updateResponse->assertRedirect('/admin/hero-images');
        $hero->refresh();

        $this->assertEquals('Selamat Datang Diperbarui', $hero->title_id);
        $this->assertNotEquals($firstPath, $hero->image_path);
        $this->assertNotEmpty($hero->image_path);

        $newRelative = str_replace('/storage/', '', $hero->image_path);
        Storage::disk('public')->assertExists($newRelative);
    }

    /**
     * Test 7: Admin VillageController creation and validation.
     */
    public function test_admin_village_creation_and_custom_validation(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/villages', []);
        $response->assertSessionHasErrors([
            'name' => 'Nama desa wajib diisi.',
            'image_path' => 'Foto utama desa wajib diunggah.',
        ]);

        $image = UploadedFile::fake()->image('desa.jpg', 800, 600);
        $storeResponse = $this->actingAs($admin)->post('/admin/villages', [
            'name' => 'Desa Makmur',
            'location' => 'Kabupaten Sukabumi',
            'description' => 'Desa percontohan pertanian organik.',
            'narrative' => 'Kisah sukses para petani membudidayakan padi ramah lingkungan.',
            'image_path' => $image,
        ]);

        $storeResponse->assertRedirect('/admin/villages');
        $village = Village::where('name', 'Desa Makmur')->first();
        $this->assertNotNull($village);
        $this->assertNotEmpty($village->image_path);

        $relative = str_replace('/storage/', '', $village->image_path);
        Storage::disk('public')->assertExists($relative);
    }

    /**
     * Test 8: Admin Story creation with main image, gallery images, and custom validation.
     */
    public function test_admin_story_creation_with_gallery_and_validation(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Validation test
        $response = $this->actingAs($admin)->post('/admin/stories', []);
        $response->assertSessionHasErrors([
            'title_id' => 'Judul artikel (Bahasa Indonesia) wajib diisi.',
            'image_url' => 'Foto utama (thumbnail) artikel wajib diunggah.',
        ]);

        $mainImage = UploadedFile::fake()->image('main.jpg', 800, 600);
        $gallery1 = UploadedFile::fake()->image('g1.webp', 800, 600);
        $gallery2 = UploadedFile::fake()->image('g2.png', 800, 600);

        $storeResponse = $this->actingAs($admin)->post('/admin/stories', [
            'title_id' => 'Panen Melimpah di Desa Sukamaju',
            'title_en' => 'Abundant Harvest in Sukamaju Village',
            'category_id' => 'Pertanian',
            'category_en' => 'Agriculture',
            'description_id' => 'Petani desa binaan berhasil meningkatkan hasil panen.',
            'description_en' => 'Farmers in the assisted village successfully boosted crop yields.',
            'content_id' => 'Narasi lengkap mengenai kegiatan panen raya...',
            'content_en' => 'Full story about the harvest festival...',
            'image_url' => $mainImage,
            'gallery' => [$gallery1, $gallery2],
        ]);

        $storeResponse->assertRedirect('/admin/stories');
        $storeResponse->assertSessionHas('success');

        $story = \App\Models\Story::where('title_id', 'Panen Melimpah di Desa Sukamaju')->first();
        $this->assertNotNull($story);
        $this->assertNotEmpty($story->image_url);

        $mainRel = str_replace('/storage/', '', $story->image_url);
        Storage::disk('public')->assertExists($mainRel);

        $this->assertIsArray($story->gallery);
        $this->assertCount(2, $story->gallery);
        foreach ($story->gallery as $item) {
            $this->assertEquals('image', $item['type']);
            $galRel = str_replace('/storage/', '', $item['path']);
            Storage::disk('public')->assertExists($galRel);
        }
    }

    /**
     * Test 9: Storage fallback route correctly serves files from public storage.
     */
    public function test_storage_fallback_route_serves_files(): void
    {
        // Write a test image to storage disk
        Storage::disk('public')->put('audit_test/photo.jpg', 'fake-image-content-for-test');

        $response = $this->get('/storage/audit_test/photo.jpg');
        $response->assertStatus(200);
        $this->assertEquals('fake-image-content-for-test', file_get_contents($response->getFile()->getPathname()));
    }
}
