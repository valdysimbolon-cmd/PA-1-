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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20)->unique(); // Menyimpan NIM (Nomor Induk Mahasiswa) dan bersifat unik
            $table->string('name');              // Menyimpan Nama Mahasiswa
            $table->boolean('active')->default(true); // Status keaktifan (digunakan di Controller: where('active', 1))
            $table->timestamps();                // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};