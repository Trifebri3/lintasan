<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hero_images', function (Blueprint $table) {
            $table->string('button_link')->nullable()->default(null);
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->text('related_links')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_images', function (Blueprint $table) {
            $table->dropColumn('button_link');
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('related_links');
        });
    }
};
