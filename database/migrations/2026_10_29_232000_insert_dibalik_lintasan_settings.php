<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            $settings = [
                [
                    'key' => 'bg_photo_dibalik_lintasan',
                    'value_id' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1920&q=80',
                    'value_en' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1920&q=80',
                    'type' => 'image',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'title_dibalik_lintasan',
                    'value_id' => 'Di Balik LINTASAN',
                    'value_en' => 'Behind LINTASAN',
                    'type' => 'text',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'subtitle_dibalik_lintasan',
                    'value_id' => 'Mengenal figur pendiri, pembina, pengawas, pengurus, dan penggerak di balik langkah nyata Yayasan LINTASAN.',
                    'value_en' => 'Get to know the founders, trustees, leadership, and dedicated team behind Yayasan LINTASAN.',
                    'type' => 'text',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'badge_dibalik_lintasan',
                    'value_id' => 'BOARD, LEADERSHIP & TEAM',
                    'value_en' => 'BOARD, LEADERSHIP & TEAM',
                    'type' => 'text',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($settings as $setting) {
                if (!DB::table('settings')->where('key', $setting['key'])->exists()) {
                    DB::table('settings')->insert($setting);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('settings')) {
            DB::table('settings')->whereIn('key', [
                'bg_photo_dibalik_lintasan',
                'title_dibalik_lintasan',
                'subtitle_dibalik_lintasan',
                'badge_dibalik_lintasan',
            ])->delete();
        }
    }
};

