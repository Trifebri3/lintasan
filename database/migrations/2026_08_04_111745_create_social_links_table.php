<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('name');
            $table->string('url');
            $table->string('description_id')->nullable();
            $table->string('description_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed default social links
        \DB::table('social_links')->insert([
            [
                'platform' => 'instagram',
                'name' => '@senyum_anaknegeri',
                'url' => 'https://www.instagram.com/senyum_anaknegeri/',
                'description_id' => 'Foto kegiatan, cerita menarik, dan Reels langsung dari lokasi desa binaan.',
                'description_en' => 'Photo updates, stories, and reels directly from coastal assisted villages.',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform' => 'youtube',
                'name' => 'Yayasan LINTASAN',
                'url' => 'https://youtube.com/',
                'description_id' => 'Profil yayasan, video dokumentasi program, dan panduan kesiapsiagaan.',
                'description_en' => 'Video profiles, training documentation, and disaster readiness guides.',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform' => 'facebook',
                'name' => 'Yayasan LINTASAN',
                'url' => 'https://facebook.com/',
                'description_id' => 'Rilis pers resmi, agenda kegiatan, dan galeri album aksi kemanusiaan.',
                'description_en' => 'Press releases, event invites, and photo albums of our social acts.',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform' => 'linkedin',
                'name' => 'Yayasan LINTASAN',
                'url' => 'https://linkedin.com/',
                'description_id' => 'Info kelembagaan, kerja sama profesional, dan jejaring relasi korporasi.',
                'description_en' => 'Institutional updates, partnerships, and professional network updates.',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
