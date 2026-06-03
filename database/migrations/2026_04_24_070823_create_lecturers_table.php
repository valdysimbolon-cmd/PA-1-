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
        Schema::create('lecturers', function (Blueprint $table) {
            // 1. Identitas Utama (BigInt & Auto Increment)
            $table->id();

            // 2. Data Utama (Manual Input)
            $table->string('nip_nidn', 50)->unique();
            $table->string('name'); 
            $table->string('email')->unique();
            $table->string('image')->nullable();
            
            // 3. Jabatan & Pendidikan (ENUM)
            $table->enum('academic_position', ['Asisten Ahli','Lektor','Lektor Kepala','Guru Besar','Tenaga Pengajar','Laboran','Teaching Assistant','Staff Administrasi','Teknisi','Lainnya']);
            $table->string('academic_level')->nullable(); // Contoh: III/c - Penata
            
            // 4. Struktur Organisasi (DINAMIS)
            $table->string('structural_position')->nullable(); // Contoh: Kaprodi
            $table->unsignedBigInteger('parent_id')->nullable(); // Kabel ke Atasan

            // 5. Data Pendukung
            $table->string('office')->nullable();
            $table->text('teaching_history')->nullable();

            // 6. Audit Trail (Hasil Bimbingan)
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->boolean('active')->default(true);

            // 7. Catatan Waktu
            $table->timestamps();

            // 8. Definisi Kabel Relasi Mandiri (Pohon Akar)
            $table->foreign('parent_id')->references('id')->on('lecturers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
