<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    // 1. Rename tabel hanya jika masih bernama 'tools'
    if (Schema::hasTable('tools')) {
        Schema::rename('tools', 'inventory');
    }

    Schema::table('inventory', function (Blueprint $table) {
        // 2. Rename kolom lama ke nama baru (hanya jika kolom lamanya ada)
        if (Schema::hasColumn('inventory', 'name')) {
            $table->renameColumn('name', 'item_name');
        }
        if (Schema::hasColumn('inventory', 'code')) {
            $table->renameColumn('code', 'item_code');
        }

        // 3. Tambah kolom baru HANYA jika belum ada (mencegah error Duplicate Column)
        if (!Schema::hasColumn('inventory', 'unit')) {
            $table->string('unit')->nullable()->after('item_name');
        }
        if (!Schema::hasColumn('inventory', 'price')) {
            $table->decimal('price', 15, 2)->default(0)->after('quantity');
        }
        if (!Schema::hasColumn('inventory', 'gross_weight')) {
            $table->string('gross_weight')->nullable();
        }
        if (!Schema::hasColumn('inventory', 'net_weight')) {
            $table->string('net_weight')->nullable();
        }
        if (!Schema::hasColumn('inventory', 'spesification')) {
            $table->text('spesification')->nullable();
        }
        if (!Schema::hasColumn('inventory', 'chemical_formula')) {
            $table->string('chemical_formula')->nullable();
        }
        if (!Schema::hasColumn('inventory', 'storage')) {
            $table->string('storage')->nullable();
        }
        if (!Schema::hasColumn('inventory', 'expiry_date')) {
            $table->date('expiry_date')->nullable();
        }
        if (!Schema::hasColumn('inventory', 'cupboard_location')) {
            $table->string('cupboard_location')->nullable();
        }
        if (!Schema::hasColumn('inventory', 'year')) {
            $table->year('year')->nullable();
        }
        
        // Mengubah kolom condition yang tadinya Enum menjadi String (agar aman)
        if (Schema::hasColumn('inventory', 'condition')) {
            $table->string('condition')->change();
        }
    });
}

    public function down(): void
    {
        // Kembalikan nama tabel
        if (Schema::hasTable('inventory')) {
            Schema::rename('inventory', 'tools');
        }
        
        // Note: Down untuk renameColumn dan dropColumn bisa ditambahkan jika ingin detail 
        // tapi biasanya rename balik tabel sudah cukup untuk membatalkan status 'inventory'
    }
};