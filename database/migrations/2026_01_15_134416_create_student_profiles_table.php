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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained('registrations')->onDelete('cascade');
            $table->string('full_name');
            $table->string('nisn')->unique();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->text('address');
            $table->string('previous_school')->nullable();
            $table->timestamps();

            $table->index('full_name');
            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
