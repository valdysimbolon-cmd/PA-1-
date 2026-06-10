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
            $table->id();

            // Identitas
            $table->string('nip_nidn', 50)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('image')->nullable();

            // Profil Akademik
            $table->enum('academic_position', [
                'Asisten Ahli',
                'Lektor',
                'Lektor Kepala',
                'Guru Besar',
                'Tenaga Pengajar',
                'Laboran',
                'Teaching Assistant',
                'Staff Administrasi',
                'Teknisi',
                'Lainnya'
            ]);

            $table->string('academic_level')->nullable();

            // Struktur Organisasi
            $table->string('structural_position')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();

            // Informasi Tambahan
            $table->string('office')->nullable();

            // Untuk halaman profil dosen
            $table->longText('teaching_history')->nullable();

            // Link Portofolio Eksternal
            $table->string('sinta_url')->nullable();
            $table->string('pddikti_url')->nullable();

            // Status
            $table->boolean('active')->default(true);

            // Audit Trail
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('lecturers')
                ->nullOnDelete();
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
