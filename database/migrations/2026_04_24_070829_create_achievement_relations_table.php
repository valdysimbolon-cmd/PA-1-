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
        Schema::create('achievement_relations', function (Blueprint $table) {
            $table->id();
            // Kabel ke Piala
            $table->foreignId('achievement_id')->constrained('achievements')->onDelete('cascade');
            
            // Kabel ke Orang (Bisa Dosen/Mhs)
            $table->unsignedBigInteger('member_id'); 
            $table->enum('member_type', ['Student', 'Lecturer']);
            $table->enum('role', ['Ketua', 'Anggota', 'Pembimbing']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_relations');
    }
};
