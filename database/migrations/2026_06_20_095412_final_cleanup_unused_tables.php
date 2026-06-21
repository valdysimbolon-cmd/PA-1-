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
    // Urutan penghapusan (Tabel detail/anak harus dihapus lebih dulu)
    Schema::dropIfExists('borrowing_details');
    Schema::dropIfExists('borrowings');
    Schema::dropIfExists('publication_authors');
    Schema::dropIfExists('publications');
    Schema::dropIfExists('academic_portfolios');
    Schema::dropIfExists('physical_laboratories');
    Schema::dropIfExists('students');
}

public function down(): void
{
    // Biarkan kosong
}
};
