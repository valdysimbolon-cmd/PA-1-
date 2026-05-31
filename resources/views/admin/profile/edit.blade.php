@extends('layouts.admin')

@section('title', 'Edit Profil: ' . $profile->name)

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3" style="background-color: #200F07;">
        <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Edit Konten: {{ $profile->name }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Memberitahu Laravel ini adalah proses UPDATE --}}

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Kode Navigasi (Key)</label>
                        {{-- PENTING: Key biasanya tidak boleh diubah karena akan merusak link di web depan --}}
                        <input type="text" name="key" class="form-control bg-light" value="{{ $profile->key }}" readonly>
                        <small class="text-danger">*Kode sistem tidak dapat diubah.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Judul Halaman</label>
                        {{-- PENTING: Menampilkan data lama dengan old() --}}
                        <input type="text" name="name" class="form-control" value="{{ old('name', $profile->name) }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Isi Konten</label>
                {{-- PENTING: Textarea tidak pakai atribut value, isinya ditaruh di tengah tag --}}
                <textarea name="description" id="editor" class="form-control" rows="10" required>{{ old('description', $profile->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Gambar Saat Ini</label><br>
                @if($profile->image)
                    <img src="{{ asset('storage/' . $profile->image) }}" class="img-thumbnail mb-2" width="200">
                @else
                    <p class="text-muted small">Belum ada gambar diunggah.</p>
                @endif
                <input type="file" name="image" class="form-control-file border p-1 rounded w-100">
                <small class="text-muted">Pilih file baru jika ingin mengganti gambar.</small>
            </div>

            <div class="custom-control custom-switch p-3 border rounded bg-light mb-4">
                {{-- PENTING: Logika checked untuk checkbox --}}
                <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', $profile->active) ? 'checked' : '' }}>
                <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">Tampilkan di Website Publik</label>
            </div>

            <hr>
            <button type="submit" class="btn btn-success shadow-sm px-4">
                <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>
            <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection