@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Artikel Berita</h1>
        <a href="{{ route('news.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Batal
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Formulir Perbaikan Artikel</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Judul Berita</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kategori</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $news->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold text-dark">Isi Konten</label>
                    <textarea name="content" id="editor" class="form-control">{{ old('content', $news->content) }}</textarea>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Tanggal Terbit</label>
                            <input type="date" name="published_at" class="form-control" value="{{ $news->published_at }}" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Gambar Utama</label>
                            <div class="d-flex align-items-start">
                                <!-- Tampilkan Foto Lama -->
                                <div class="mr-3 text-center">
                                    <small class="d-block text-muted">Foto Lama:</small>
                                    @if($news->image)
                                        <img src="{{ asset('storage/' . $news->image) }}" class="img-thumbnail" width="100">
                                    @else
                                        <span class="badge badge-light border">Tidak ada foto</span>
                                    @endif
                                </div>
                                <!-- Input Foto Baru -->
                                <div class="flex-grow-1">
                                    <small class="d-block text-muted">Ganti Foto Baru (Opsional):</small>
                                    <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded w-100">
                                    <img id="preview" src="#" class="mt-2 d-none img-thumbnail" width="150">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light mt-3">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $news->active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-primary" for="active" style="cursor:pointer;">Terbitkan Artikel</label>
                </div>

                <hr class="mt-4">
                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) { preview.src = URL.createObjectURL(file); preview.classList.remove('d-none'); }
    }
</script>
@endpush