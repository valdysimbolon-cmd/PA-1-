<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->id();

            // Identitas lab
            $table->string('name');
            $table->enum('category', ['Praktikum', 'Riset', 'Umum']);
            $table->string('location')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);

            // Relasi
            $table->foreignId('staff_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('head_of_lab_id')
                  ->nullable()
                  ->constrained('lecturers')
                  ->nullOnDelete();

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

            // Index
            $table->index('category');
            $table->index('active');
            $table->index(['category', 'active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};