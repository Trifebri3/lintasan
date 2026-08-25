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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->string('type'); // 'image' or 'video'
            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('youtube_id')->nullable();
            $table->string('embed_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
