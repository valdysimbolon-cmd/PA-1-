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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['Students', 'Lecturers']);
            $table->string('title'); // Judul Prestasi
            $table->string('winner_name'); // Pemenang Utama (Bisa individu/tim)
            $table->enum('level', ['Regional', 'Nasional', 'Internasional']);
            $table->year('year');
            $table->string('rank')->nullable(); // Juara 1, Best Paper, dll
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->boolean('active')->default(true);
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
