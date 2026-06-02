@extends('layouts.admin')

@section('title', 'Tambah Mitra')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Formulir Mitra Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('cooperations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nama Instansi/Perusahaan</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: PT. Pertamina" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Tipe Kerjasama</label>
                                <select name="type" class="form-select" required>
                                    <option value="Industri">Industri</option>
                                    <option value="Akademik">Akademik</option>
                                    <option value="Pemerintah">Pemerintah</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Berakhir</label>
                                <input type="date" name="end_date" class="form-control">
                                <div class="form-text">Kosongkan jika berlaku selamanya.</div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Deskripsi Kerjasama</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Program magang, riset bersama, dll..."></textarea>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold">Logo Mitra</label>
                            <input type="file" name="logo" id="imageInput" class="form-control" accept="image/*">
                            <div id="previewContainer" class="mt-2 d-none">
                                <img id="preview" src="#" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                            <div class="form-text">Format JPG/PNG, maks 2MB. Ukuran ideal 200x200px.</div>
                        </div>

                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked>
                            <label class="form-check-label fw-semibold text-success" for="active">Tampilkan Logo di Website Publik</label>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Simpan Mitra
                            </button>
                            <a href="{{ route('cooperations.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection