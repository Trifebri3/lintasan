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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Annual Report'); // Annual Report, Laporan Tahunan, Laporan Keuangan, Riset & Panduan, Dokumen Kebijakan, Lainnya
            $table->string('year', 10)->nullable(); // e.g. 2024, 2025
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type', 20)->default('pdf'); // pdf, docx, doc, xlsx, pptx
            $table->unsignedBigInteger('file_size')->default(0); // bytes
            $table->string('cover_path')->nullable();
            $table->unsignedInteger('downloads_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->date('published_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
