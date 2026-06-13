<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {

            $table->id();

            $table->enum('category', [
                'Mahasiswa',
                'Dosen',
                'Umum'
            ]);

            $table->string('title');

            $table->longText('content');

            $table->string('image')->nullable();

            $table->date('published_at');

            $table->boolean('active')
                ->default(true);

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('category');
            $table->index('published_at');
            $table->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};