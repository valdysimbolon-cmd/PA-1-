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
        Schema::create('facilities', function (Blueprint $table) {

            $table->id();

            // Informasi Fasilitas
            $table->string('name');

            $table->string('type');

            $table->integer('capacity')->nullable();

            $table->string('location');

            $table->text('description')->nullable();

            // Foto fasilitas
            $table->string('image')->nullable();

            // Status tampil di website
            $table->boolean('active')
                ->default(true)
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};