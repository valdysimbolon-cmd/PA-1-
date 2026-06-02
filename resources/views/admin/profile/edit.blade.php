@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-edit me-2"></i>Edit Konten: {{ $profile->name }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kode Navigasi (Key)</label>
                                <input type="text" name="key" class="form-control bg-light" value="{{ $profile->key }}" readonly>
                                <div class="form-text text-danger">Kode sistem tidak dapat diubah.</div>
                                
                                <!-- BAGIAN TAMBAHAN INFO POSISI SAAT INI -->
                                <div class="mt-2 small fw-bold">
                                    @if(Str::startsWith($profile->key, 'B_'))
                                        <span class="text-warning"><i class="fas fa-home"></i> Penempatan: Halaman Beranda</span>
                                    @elseif(Str::startsWith($profile->key, 'P_'))
                                        <span class="text-info"><i class="fas fa-university"></i> Penempatan: Halaman Profil Bioproses</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Judul Konten</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $profile->name) }}" required>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Isi Konten / Narasi</label>
                            <textarea name="description" class="form-control" rows="10" required>{{ old('description', $profile->description) }}</textarea>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Gambar Saat Ini</label>
                            @if($profile->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$profile->image) }}" class="img-thumbnail" width="150">
                                </div>
                            @else
                                <p class="text-muted small">Belum ada gambar.</p>
                            @endif
                            <label class="form-text">Ganti gambar (kosongkan jika tidak ingin mengubah):</label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                            <div id="previewContainer" class="mt-2 d-none">
                                <img id="imagePreview" src="#" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>

                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ old('active', $profile->active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-success" for="active">Tampilkan di Website Publik</label>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('profiles.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection