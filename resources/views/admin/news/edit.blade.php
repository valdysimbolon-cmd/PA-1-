@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Edit Berita: {{ $news->title }}</h6>
        </div>
        <div class="card-body">
            {{-- Form Update dengan Method PUT --}}
            <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row text-dark">
                    <!-- Kiri: Judul dan Konten -->
                    <div class="col-md-8 border-right">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Berita</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Isi Berita</label>
                            <textarea name="content" id="editor" class="form-control">{{ old('content', $news->content) }}</textarea>
                        </div>
                    </div>

                    <!-- Kanan: Pengaturan -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Kategori</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $news->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Tanggal Publikasi</label>
                            <input type="date" name="published_at" class="form-control" value="{{ old('published_at', $news->published_at) }}">
                        </div>

                        <div class="form-group mt-3 text-center">
                            <label class="font-weight-bold d-block text-left">Gambar Sampul</label>
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                                <small class="text-muted d-block mb-2 italic">Gambar saat ini</small>
                            @endif
                            <input type="file" name="image" class="form-control-file border p-2 rounded w-100">
                            <small class="text-muted italic">Maksimal 2MB. Kosongkan jika tidak ingin ganti.</small>
                        </div>

                        <div class="custom-control custom-switch mt-4 p-3 border rounded shadow-sm bg-white text-center">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $news->active ? 'checked' : '' }}>
                            <label class="custom-control-label text-success font-weight-bold" for="active" style="cursor:pointer;">Tampilkan di Web</label>
                        </div>

                        <hr class="mt-5">
                        <button type="submit" class="btn btn-block py-3 shadow" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                            <i class="fas fa-check-circle mr-2"></i>SIMPAN PERUBAHAN
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
{{-- Memanggil Library CKEditor dari CDN (Sama dengan Create) --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 500,
        removeButtons: 'PasteFromWord'
    });
</script>
@endpush