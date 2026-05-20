@extends('layouts.admin')

@section('title', 'Tambah Profil')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3" style="background-color: #200F07;">
        <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Form Tambah Profil Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Key Sistem (Contoh: VISI_MISI)</label>
                        <input type="text" name="key" class="form-control @error('key') is-invalid @enderror" value="{{ old('key') }}" required>
                        <small class="text-muted">Gunakan huruf besar dan underscore. Harus UNIK.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Halaman (Judul)</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi / Isi Konten</label>
                <textarea name="description" class="form-control" rows="10" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Gambar Pendukung</label>
                <input type="file" name="image" class="form-control-file">
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label" for="active">Langsung Aktifkan (Tampilkan di Web)</label>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-success">Simpan Data</button>
            <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection