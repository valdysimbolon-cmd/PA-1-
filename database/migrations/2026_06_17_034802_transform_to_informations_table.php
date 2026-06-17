<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. PROSES PEMBUATAN TABEL BARU
        Schema::create('informations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['news', 'announcement']); 
            $table->string('title');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->boolean('active')->default(true);

            // Kolom gabungan
            $table->enum('category', [
                'Kegiatan Mahasiswa', 
                'Kegiatan Dosen', 
                'Kegiatan Umum', 
                'Pengumuman'
            ])->nullable();
            
            $table->timestamp('published_at')->nullable();
            $table->string('attachment_file')->nullable();
            $table->boolean('is_important')->default(false);
            $table->timestamp('expired_at')->nullable();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        // 2. PINDAHKAN DATA DARI TABEL NEWS (BERITA)
        if (Schema::hasTable('news')) {
            $oldNews = DB::table('news')->get();
            foreach ($oldNews as $news) {
                DB::table('informations')->insert([
                    'type'         => 'news',
                    'title'        => $news->title,
                    'content'      => $news->content,
                    'image'        => $news->image,
                    'active'       => $news->active,
                    // Kita samakan kategori 'Informasi Umum' di tabel lama menjadi 'Kegiatan Umum' di tabel baru
                    'category'     => $news->category == 'Informasi Umum' ? 'Kegiatan Umum' : $news->category,
                    'published_at' => $news->published_at,
                    'created_by'   => $news->created_by,
                    'updated_by'   => $news->updated_by,
                    'created_at'   => $news->created_at,
                    'updated_at'   => $news->updated_at,
                ]);
            }
        }

        // 3. PINDAHKAN DATA DARI TABEL ANNOUNCEMENTS (PENGUMUMAN)
        if (Schema::hasTable('announcements')) {
            $oldAnnouncements = DB::table('announcements')->get();
            foreach ($oldAnnouncements as $ann) {
                DB::table('informations')->insert([
                    'type'            => 'announcement',
                    'title'           => $ann->title,
                    'content'         => $ann->content,
                    'image'           => null, 
                    'active'          => $ann->active,
                    'category'        => 'Pengumuman',
                    'attachment_file' => $ann->attachment_file,
                    'is_important'    => $ann->is_important,
                    'expired_at'      => $ann->expired_at,
                    'created_by'      => $ann->created_by,
                    'updated_by'      => $ann->updated_by,
                    'created_at'      => $ann->created_at,
                    'updated_at'      => $ann->updated_at,
                ]);
            }
        }

        // 4. HAPUS TABEL LAMA SETELAH PINDAH
        Schema::dropIfExists('news');
        Schema::dropIfExists('announcements');
    }

    public function down(): void
    {
        Schema::dropIfExists('informations');
    }
};