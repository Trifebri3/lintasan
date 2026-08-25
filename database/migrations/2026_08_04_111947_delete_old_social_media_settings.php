<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \DB::table('settings')->whereIn('key', [
            'social_instagram',
            'social_facebook',
            'social_youtube',
            'social_linkedin',
            'social_twitter',
            'show_social_section'
        ])->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
