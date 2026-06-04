@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tulis Berita Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row text-dark">
                    <div class="col-md-8 border-right">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Berita</label>
                            <input type="text" name="title" class="form-control" placeholder="Masukkan judul menarik..." value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Isi Berita</label>
                            {{-- ID "editor" digunakan untuk CKEditor --}}
                            <textarea name="content" id="editor" class="form-control" placeholder="Tuliskan cerita lengkap di sini...">{{ old('content') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Kategori</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Tanggal Publikasi</label>
                            <input type="date" name="published_at" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Gambar Sampul</label>
                            <input type="file" name="image" class="form-control-file border p-2 rounded w-100">
                            <small class="text-muted italic">Maksimal 2MB. Format: JPG, PNG.</small>
                        </div>

                        <div class="custom-control custom-switch mt-4 p-3 border rounded shadow-sm bg-white text-center">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                            <label class="custom-control-label text-success font-weight-bold" for="active" style="cursor:pointer;">Terbitkan Sekarang</label>
                        </div>

                        <hr class="mt-5">
                        <button type="submit" class="btn btn-block py-3 shadow" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                            <i class="fas fa-paper-plane mr-2"></i>SIMPAN & PUBLIKASI
                        </button>
                        <a href="{{ route('news.index') }}" class="btn btn-secondary btn-block mt-2">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Memanggil Library CKEditor dari CDN --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    // Inisialisasi CKEditor pada textarea denga id="editor"
    CKEDITOR.replace('editor', {
        height: 500, // Menyesuaikan tinggi editor
        removeButtons: 'PasteFromWord'
    });
</script>
@endpush