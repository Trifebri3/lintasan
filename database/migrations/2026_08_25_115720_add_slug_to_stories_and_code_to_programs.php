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
        Schema::table('stories', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique();
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->string('code')->nullable()->unique();
        });

        // Populate existing stories with slugs
        \App\Models\Story::all()->each(function ($story) {
            $slug = \Illuminate\Support\Str::slug($story->title_id);
            $originalSlug = $slug;
            $counter = 1;
            while (\App\Models\Story::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $story->update(['slug' => $slug]);
        });

        // Populate existing programs with random codes
        \App\Models\Program::all()->each(function ($program) {
            do {
                $code = \Illuminate\Support\Str::random(32);
            } while (\App\Models\Program::where('code', $code)->exists());
            $program->update(['code' => $code]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
