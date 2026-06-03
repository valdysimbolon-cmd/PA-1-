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
        Schema::create('achievement_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained('achievements')->onDelete('cascade');
            $table->enum('member_type', ['Student', 'Lecturer']); // Tipe orang
            $table->unsignedBigInteger('member_id'); // ID Mahasiswa atau Dosen
            $table->string('role')->nullable(); // Ketua, Anggota, Pembimbing
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
