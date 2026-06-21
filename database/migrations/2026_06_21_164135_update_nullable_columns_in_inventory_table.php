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
    Schema::table('inventory', function (Blueprint $table) {
        $table->string('unit', 50)->nullable()->change();
        $table->bigInteger('lab_id')->unsigned()->nullable()->change();
        $table->string('condition', 100)->nullable()->change();
        $table->decimal('price', 15, 2)->nullable()->change();
        // Kolom berikut sudah nullable di DB kamu, pastikan saja:
        // expiry_date, chemical_formula, gross_weight, net_weight,
        // storage, year, cupboard_location, spesification sudah NULL ✅
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory', function (Blueprint $table) {
            //
        });
    }
};
