<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel jembatan dulu, baru tabel utama
        Schema::dropIfExists('publication_authors');
        Schema::dropIfExists('publications');
    }

    public function down(): void
    {
        // Kosongkan saja
    }
};