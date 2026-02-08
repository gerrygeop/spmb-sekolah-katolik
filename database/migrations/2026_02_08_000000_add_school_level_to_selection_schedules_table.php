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
        Schema::table('selection_schedules', function (Blueprint $table) {
            $table->string('school_level', 10)->nullable()->after('registration_batch_id');
            $table->index(['registration_batch_id', 'school_level'], 'selection_schedules_batch_level_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selection_schedules', function (Blueprint $table) {
            $table->dropIndex('selection_schedules_batch_level_index');
            $table->dropColumn('school_level');
        });
    }
};
