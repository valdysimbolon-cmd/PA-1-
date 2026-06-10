<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('achievement_relations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('achievement_id')
                ->constrained('achievements')
                ->cascadeOnDelete();

            $table->enum('member_type', [
                'Student',
                'Lecturer'
            ]);

            $table->unsignedBigInteger('member_id');

            $table->string('role')->nullable();

            $table->timestamps();

            $table->index([
                'member_type',
                'member_id'
            ]);
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_relations');
    }
};
