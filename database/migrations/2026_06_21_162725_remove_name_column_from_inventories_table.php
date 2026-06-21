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
    Schema::table('inventory', function (Blueprint $table) {  // ganti 'inventories' → 'inventory'
        $table->dropColumn('name');
    });
}

public function down(): void
{
    Schema::table('inventory', function (Blueprint $table) {
        $table->string('name')->after('item_name');
    });
}
};
