<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek jika tabel BELUM ada, baru buat
        if (!Schema::hasTable('lab_loan')) {
            Schema::create('lab_loan', function (Blueprint $table) {
                $table->id();

                // Data peminjam
                $table->string('nim');
                $table->string('borrower_name');
                $table->string('study_program');
                $table->string('research_title');

                // Tanggal
                $table->date('planned_borrow_date');
                $table->date('planned_return_date');
                $table->date('return_date')->nullable();
                $table->date('returned_date')->nullable();

                // Nomor resi
                $table->string('receipt_number')->unique();

                // Status
                $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])
                      ->default('pending');

                $table->text('admin_notes')->nullable();

                // Relasi
                $table->foreignId('lab_id')
                    ->nullable()
                    ->constrained('labs') // Pastikan nama tabel referensinya 'labs' atau 'lab' sesuai database Anda
                    ->nullOnDelete();

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_loan');
    }
};