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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('url', 1000);
            $table->string('path', 255)->index();
            $table->string('page_title', 255)->nullable();
            $table->string('referer', 1000)->nullable();
            $table->string('referer_domain', 150)->nullable()->index();
            $table->string('keyword', 255)->nullable()->index();
            $table->string('device_type', 30)->default('Desktop')->index(); // Desktop, Mobile, Tablet
            $table->string('browser', 50)->nullable()->index(); // Chrome, Safari, Firefox, Edge, etc.
            $table->string('operating_system', 50)->nullable()->index(); // Windows, Android, iOS, macOS, Linux
            $table->string('country', 100)->default('Indonesia')->index();
            $table->string('province', 100)->nullable()->index(); // e.g. Jawa Barat, DKI Jakarta
            $table->string('city', 100)->nullable()->index(); // e.g. Bandung, Jakarta, Sukabumi
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->timestamp('visited_at')->useCurrent()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
