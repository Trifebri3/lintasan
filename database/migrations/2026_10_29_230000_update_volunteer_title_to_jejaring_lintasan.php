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
            DB::table('settings')
                ->where('key', 'volunteer_title')
                ->update([
                    'value_id' => 'Menjadi Jejaring Lintasan',
                    'value_en' => 'Join the LINTASAN Network',
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('settings')) {
            DB::table('settings')
                ->where('key', 'volunteer_title')
                ->update([
                    'value_id' => 'Menjadi Relawan LINTASAN',
                    'value_en' => 'Become a LINTASAN Volunteer',
                    'updated_at' => now(),
                ]);
        }
    }
};
