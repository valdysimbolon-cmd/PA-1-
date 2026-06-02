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
        Schema::create('education_backgrounds', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel lecturers
            $table->foreignId('lecturer_id')->constrained('lecturers')->onDelete('cascade');
            
            // Kolom sesuai rancangan Anda
            $table->string('campus');         // Nama Universitas
            $table->string('study_program');  // Program Studi
            $table->string('degree');         // Gelar (S1, S2, S3)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_backgrounds');
    }
};
