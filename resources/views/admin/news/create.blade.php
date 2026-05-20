@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tulis Artikel / Berita Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Judul Berita</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan judul berita yang menarik..." required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kategori</label>
                            <select name="category_id" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold text-dark">Isi Berita</label>
                    <textarea name="content" id="editor" class="form-control">{{ old('content') }}</textarea>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Tanggal Terbit</label>
                            <input type="date" name="published_at" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Gambar Utama</label>
                            <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded w-100">
                            <img id="preview" src="#" class="mt-2 d-none img-thumbnail" width="200">
                        </div>
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light mt-3">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label font-weight-bold text-primary" for="active" style="cursor:pointer;">Terbitkan Sekarang (Dilihat Publik)</label>
                </div>

                <hr class="mt-4">
                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-paper-plane mr-2"></i> Simpan Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview Gambar
    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            preview.src = URL.createObjectURL(file)
            preview.classList.remove('d-none')
        }
    }
</script>
@endpush