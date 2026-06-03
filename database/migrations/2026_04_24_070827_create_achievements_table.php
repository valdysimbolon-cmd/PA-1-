<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['students', 'lecturers']); // Kategori besar
            $table->string('winner_name'); // Nama Utama (Individu/Tim)
            $table->string('title'); // Nama Kompetisi
            $table->string('rank')->nullable(); // Juara 1, Medali Emas, dll
            $table->enum('level', ['Regional', 'Nasional', 'Internasional']);
            $table->year('year');
            $table->string('image')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
