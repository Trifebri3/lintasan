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
        Schema::table('programs', function (Blueprint $table) {
            if (!Schema::hasColumn('programs', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('link');
            }
        });

        // Initialize sort_order sequentially for existing programs
        $programs = \App\Models\Program::orderBy('id')->get();
        foreach ($programs as $index => $program) {
            $program->update(['sort_order' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            if (Schema::hasColumn('programs', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
