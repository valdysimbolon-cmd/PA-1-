<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {

            $table->id();

            $table->string('code', 25)->unique();

            $table->string('name');

            $table->unsignedTinyInteger('semester');

            $table->unsignedTinyInteger('sks');

            $table->text('description')->nullable();

            $table->foreignId('curriculum_id')
                ->constrained('curriculums')
                ->cascadeOnDelete();

            $table->boolean('active')->default(true);

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
        Schema::dropIfExists('subjects');
    }
};