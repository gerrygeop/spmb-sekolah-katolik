<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registration_batches', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Gelombang 1 Tahun Ajaran 2026/2027
            $table->string('slug')->unique();
            $table->dateTime('registration_start');
            $table->dateTime('registration_end');
            $table->json('timeline');
            $table->boolean('is_active')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_batch_id')->constrained('registration_batches')->cascadeOnDelete();
            $table->string('registration_code')->unique();
            $table->string('school_level');
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_batches');
        Schema::dropIfExists('registrations');
    }
};
