<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();

            // Konten utama
            $table->string('title');
            $table->text('subtitle');

            // Media — YouTube URL saja
            $table->string('video_url')->nullable();

            // Tombol CTA
            $table->string('primary_button_text')->nullable()->default('Pelajari Program Kami');
            $table->string('primary_button_url')->nullable();
            $table->string('secondary_button_text')->nullable()->default('Lihat Laboratorium');
            $table->string('secondary_button_url')->nullable();

            // Status — hanya satu hero aktif sekaligus
            $table->boolean('active')->default(false);

            // Blameable
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};