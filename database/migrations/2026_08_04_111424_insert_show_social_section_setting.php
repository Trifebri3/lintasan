<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \DB::table('settings')->insert([
            'key' => 'show_social_section',
            'value_id' => '1', // Default: 1 (Show)
            'value_en' => '1',
            'type' => 'boolean',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('settings')->where('key', 'show_social_section')->delete();
    }
};
