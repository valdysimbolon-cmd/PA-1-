@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Dokumen</h1>
        <a href="{{ route('document_archives.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-edit mr-2"></i>Perbarui Dokumen: {{ $documentArchive->title }}
            </h6>
        </div>
        <div class="card-body text-dark">
            <form action="{{ route('document_archives.update', $documentArchive->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="font-weight-bold">Judul Dokumen</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $documentArchive->title) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Kategori</label>
                        <select name="category" class="form-control">
                            @foreach(['Pedoman', 'SOP', 'Formulir', 'Akreditasi', 'Lainnya'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $documentArchive->category) == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Tahun Terbit</label>
                        <input type="number" name="year" class="form-control" value="{{ old('year', $documentArchive->year) }}">
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label class="font-weight-bold d-block">File Dokumen</label>
                    
                    {{-- Menampilkan File yang sudah ada --}}
                    <div class="mb-3 p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                        <div>
                            <i class="fas fa-file-pdf text-danger fa-2x mr-3"></i>
                            <span class="small text-muted">File saat ini: </span>
                            <a href="{{ asset('storage/' . $documentArchive->file_path) }}" target="_blank" class="font-weight-bold text-primary">
                                {{ basename($documentArchive->file_path) }}
                            </a>
                        </div>
                        <span class="badge badge-info">PDF/DOCX</span>
                    </div>

                    <label class="small text-danger font-weight-bold">Ganti File (Kosongkan jika tidak ingin mengubah):</label>
                    <input type="file" name="file" class="form-control-file border p-1 rounded w-100 bg-white">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $documentArchive->description) }}</textarea>
                </div>

                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $documentArchive->active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-success" for="active">Tampilkan Dokumen di Website Publik</label>
                </div>

                <hr>
                <div class="text-right">
                    <button type="submit" class="btn px-5 shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-check-circle mr-1"></i> SIMPAN PERUBAHAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection