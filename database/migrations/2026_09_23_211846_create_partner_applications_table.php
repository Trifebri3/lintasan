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
        Schema::create('partner_applications', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->string('pic_name');
            $table->string('email');
            $table->string('phone');
            $table->string('partnership_type')->nullable(); // CSR, Pemerintah, Pendidikan, Media, Komunitas, dll
            $table->string('logo_path')->nullable();
            $table->text('address');
            $table->text('proposal'); // Ide / Rencana Kolaborasi
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_applications');
    }
};
