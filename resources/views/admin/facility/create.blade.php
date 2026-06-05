@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        {{-- Header warna Midnight Espresso (Sama denga Lab) --}}
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tambah Fasilitas Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('facilities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row text-dark">
                    <div class="col-md-8">
                        <label class="font-weight-bold">Nama Fasilitas / Ruangan</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Ruang Kelas 512" required>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">Kategori / Tipe (Input Bebas)</label>
                        {{-- Input Text agar kategori bisa diisi sendiri oleh Admin --}}
                        <input type="text" name="type" class="form-control" placeholder="Contoh: Laboratorium / Kelas" required>
                    </div>
                </div>

                <div class="row mt-3 text-dark">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Lokasi (Gedung / Lantai)</label>
                        <input type="text" name="location" class="form-control" placeholder="Gedung 5, Lt 2" required>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Kapasitas (Orang)</label>
                        <input type="number" name="capacity" class="form-control" placeholder="30">
                    </div>
                </div>

                {{-- Bagian Deskripsi denga ID "editor" (SAMA DENGAN MODEL LAB) --}}
                <div class="form-group mt-3 text-dark">
                    <label class="font-weight-bold">Deskripsi & Penjelasan Fasilitas</label>
                    <textarea name="description" id="editor" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="form-group text-dark">
                    <label class="font-weight-bold">Foto Fasilitas</label>
                    <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded w-100">
                    <div id="previewContainer" class="mt-2 d-none"><img id="imagePreview" src="#" class="img-thumbnail" width="150"></div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded bg-light">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label text-success font-weight-bold" for="active" style="cursor:pointer;">Aktifkan Fasilitas</label>
                </div>

                <button type="submit" class="btn mt-4 shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
                    Simpan Fasilitas
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 400,
        extraPlugins: 'justify',
        allowedContent: true
    });

    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            imagePreview.src = URL.createObjectURL(file)
            previewContainer.classList.remove('d-none')
        }
    }
</script>
@endpush