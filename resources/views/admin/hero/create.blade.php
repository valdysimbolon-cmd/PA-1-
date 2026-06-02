@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3" style="background-color: #200F07;">
                    <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Banner Video Baru
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('heroes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slogan Utama</label>
                            <input type="text" name="title" class="form-control" placeholder="Contoh: Engineering the Future" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sub-Slogan</label>
                            <textarea name="subtitle" class="form-control" rows="2" placeholder="Teks kecil di bawah judul..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Link Video YouTube</label>
                            <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
                            <div class="form-text">Masukkan URL lengkap video YouTube.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Teks Tombol</label>
                                <input type="text" name="button_1_text" class="form-control" value="Daftar Sekarang">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Link Tombol</label>
                                <input type="url" name="button_1_url" class="form-control" placeholder="https://...">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked>
                            <label class="form-check-label fw-semibold" for="active">Aktifkan banner</label>
                            <div class="form-text">Hanya satu banner aktif yang akan ditampilkan di halaman utama.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> Simpan Banner
                            </button>
                            <a href="{{ route('heroes.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection