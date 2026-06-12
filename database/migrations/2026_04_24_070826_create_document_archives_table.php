<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_archives', function (Blueprint $table) {
            $table->id();

            // Konten utama
            $table->string('title');
            $table->json('tags')->nullable();           // ["SOP","Pedoman"] — bisa lebih dari satu
            $table->string('file_path')->nullable();    // nullable: dokumen bisa tanpa file dulu
            $table->year('year')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);

            // Blameable — nullable agar seeder/system process tidak error
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();

            // Index untuk query yang sering dipakai
            $table->index('year');
            $table->index('active');
            $table->index(['active', 'year']);  // composite: filter aktif per tahun
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_archives');
    }
};