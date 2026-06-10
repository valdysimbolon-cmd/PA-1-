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
        Schema::create('education_backgrounds', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lecturer_id')
                ->constrained('lecturers')
                ->cascadeOnDelete();

            $table->string('degree', 50);
            $table->string('campus');
            $table->string('study_program');
            $table->year('graduation_year')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_backgrounds');
    }
};
