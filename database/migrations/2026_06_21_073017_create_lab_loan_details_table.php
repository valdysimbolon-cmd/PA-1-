<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek jika tabel BELUM ada, baru buat
        if (!Schema::hasTable('lab_loan_details')) {
            Schema::create('lab_loan_details', function (Blueprint $table) {
                $table->id();

                // Relasi ke lab_loan
                $table->foreignId('lab_loan_id')
                    ->constrained('lab_loan')
                    ->cascadeOnDelete();

                // Relasi ke inventory
                $table->foreignId('inventory_id')
                    ->constrained('inventory')
                    ->cascadeOnDelete();

                $table->integer('quantity');
                $table->text('notes')->nullable();

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_loan_details');
    }
};