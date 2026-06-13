<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->longText('content');

            /*
            |--------------------------------------------------------------------------
            | Lampiran
            |--------------------------------------------------------------------------
            */
            $table->string('attachment_file')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Pengumuman Penting
            |--------------------------------------------------------------------------
            */
            $table->boolean('is_important')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Tanggal Kadaluarsa
            |--------------------------------------------------------------------------
            */
            $table->date('expired_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */
            $table->boolean('active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Audit Trail
            |--------------------------------------------------------------------------
            */
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('is_important');
            $table->index('expired_at');
            $table->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};