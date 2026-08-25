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
        Schema::table('volunteers', function (Blueprint $table) {
            $table->string('role')->default('Relawan')->after('phone');
            $table->string('photo_path')->nullable()->after('role');
            $table->enum('status', ['pending', 'aktif'])->default('pending')->after('photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn(['role', 'photo_path', 'status']);
        });
    }
};
