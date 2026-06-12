<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lab_id')
                  ->constrained('labs')
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('code')->nullable();         // nullable — diisi manual atau via import Excel
            $table->integer('quantity')->default(1);
            $table->integer('quantity_available')->default(1);
            $table->enum('condition', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->string('image')->nullable();        // diisi setelah import
            $table->text('description')->nullable();    // diisi setelah import
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

            $table->index('lab_id');
            $table->index('active');
            $table->index(['lab_id', 'active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};