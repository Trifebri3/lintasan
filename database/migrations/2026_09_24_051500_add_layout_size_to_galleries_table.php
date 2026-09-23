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
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'layout_size')) {
                $table->string('layout_size', 20)->default('normal')->after('type');
            }
        });

        // Set varied sample sizes for existing galleries if available so layout looks interesting immediately
        $items = \App\Models\Gallery::orderBy('id')->get();
        $sampleSizes = ['featured', 'normal', 'tall', 'wide', 'normal', 'normal'];
        foreach ($items as $index => $item) {
            if (empty($item->layout_size) || $item->layout_size === 'normal') {
                $size = $sampleSizes[$index % count($sampleSizes)];
                $item->update(['layout_size' => $size]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'layout_size')) {
                $table->dropColumn('layout_size');
            }
        });
    }
};
