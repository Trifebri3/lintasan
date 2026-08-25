<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \DB::table('settings')->insert([
            [
                'key' => 'social_instagram',
                'value_id' => 'https://www.instagram.com/senyum_anaknegeri/',
                'value_en' => 'https://www.instagram.com/senyum_anaknegeri/',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_facebook',
                'value_id' => 'https://facebook.com/',
                'value_en' => 'https://facebook.com/',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_youtube',
                'value_id' => 'https://youtube.com/',
                'value_en' => 'https://youtube.com/',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_linkedin',
                'value_id' => 'https://linkedin.com/',
                'value_en' => 'https://linkedin.com/',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_twitter',
                'value_id' => 'https://twitter.com/',
                'value_en' => 'https://twitter.com/',
                'type' => 'text',
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
        \DB::table('settings')->whereIn('key', [
            'social_instagram',
            'social_facebook',
            'social_youtube',
            'social_linkedin',
            'social_twitter'
        ])->delete();
    }
};
