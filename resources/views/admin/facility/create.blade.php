@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;"><i class="fas fa-plus-circle mr-2"></i>Tambah Fasilitas Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('facilities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Fasilitas / Ruangan</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Ruang Kelas 512" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Tipe Fasilitas</label>
                            <select name="type" class="form-control" required>
                                <option value="Classroom">Ruang Kelas</option>
                                <option value="Meeting Room">Ruang Rapat</option>
                                <option value="Library">Perpustakaan</option>
                                <option value="Other">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Kapasitas (Orang)</label>
                            <input type="number" name="capacity" class="form-control" placeholder="Contoh: 30">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Lokasi (Gedung/Lantai)</label>
                            <input type="text" name="location" class="form-control" placeholder="Contoh: Gedung 5, Lantai 2" required>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold">Deskripsi Fasilitas</label>
                    <textarea name="description" id="editor" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Foto Fasilitas</label>
                    <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded w-100">
                    <div id="previewContainer" class="mt-3 d-none">
                        <img id="imagePreview" src="#" class="img-thumbnail" style="max-height: 200px; border: 2px solid #C5E384;">
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded bg-light mt-4">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label font-weight-bold text-success" for="active">Aktifkan (Tampilkan di Web)</label>
                </div>

                <hr>
                <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold;">Simpan Fasilitas</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            imagePreview.src = URL.createObjectURL(file)
            previewContainer.classList.remove('d-none')
        }
    }
</script>
@endpush