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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('category_id');
            $table->string('category_en');
            $table->string('category_bg')->nullable();
            $table->string('category_color')->nullable();
            $table->text('description_id'); // summary for cards (ID)
            $table->text('description_en'); // summary for cards (EN)
            $table->longText('content_id')->nullable(); // full article content (ID)
            $table->longText('content_en')->nullable(); // full article content (EN)
            $table->string('impact_number')->nullable(); // optional stat number
            $table->string('impact_label_id')->nullable(); // optional stat label (ID)
            $table->string('impact_label_en')->nullable(); // optional stat label (EN)
            $table->string('image_url');
            $table->string('link')->default('#');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
