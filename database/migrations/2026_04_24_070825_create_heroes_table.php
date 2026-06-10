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

            $table->string('title');
            $table->text('subtitle');

            // Video untuk Desktop
            $table->string('video_url')->nullable();

            // Wajib untuk Mobile & Fallback
            $table->string('poster_image');

            // Tombol Join Us
            $table->string('button_text')->default('Join Us');
            $table->text('button_url')->nullable();

            // Hero aktif
            $table->boolean('active')
                ->default(false)
                ->index();

            // Audit Trail
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

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