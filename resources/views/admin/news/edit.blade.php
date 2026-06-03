@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-white">Perbarui Berita: {{ Str::limit($news->title, 40) }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row text-dark">
                    <!-- Kiri -->
                    <div class="col-md-8 border-right">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Berita</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Isi Berita</label>
                            <textarea name="content" class="form-control" rows="18" required>{{ old('content', $news->content) }}</textarea>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div class="col-md-4">
                        <div class="form-group text-center mb-4">
                            <label class="font-weight-bold d-block text-left">Gambar Saat Ini</label>
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" class="img-thumbnail shadow-sm" style="max-height: 180px;">
                            @else
                                <p class="text-muted italic small">Tidak ada gambar sampul.</p>
                            @endif
                            <input type="file" name="image" class="form-control-file border p-2 mt-3 rounded w-100 bg-light">
                        </div>

                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Ganti Kategori</label>
                            <select name="category_id" class="form-control">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $news->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Tanggal Terbit</label>
                            <input type="date" name="published_at" class="form-control" value="{{ $news->published_at }}">
                        </div>

                        <div class="custom-control custom-switch mt-4 p-3 border rounded shadow-sm bg-white text-center">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $news->active ? 'checked' : '' }}>
                            <label class="custom-control-label text-success font-weight-bold" for="active" style="cursor:pointer;">Berita Aktif</label>
                        </div>

                        <hr class="mt-5">
                        <button type="submit" class="btn btn-primary btn-block py-3 font-weight-bold shadow">
                            <i class="fas fa-check-circle mr-2"></i>SIMPAN PERUBAHAN
                        </button>
                        <a href="{{ route('news.index') }}" class="btn btn-secondary btn-block mt-2">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection