@extends('layouts.admin')

@section('title', 'Tambah Kurikulum Baru')

@section('content')
<div class="container-fluid px-4 pb-5">
    <!-- Judul + Tombol Kembali (Posisi Kanan Atas sesuai Kerjasama) -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1 font-weight-bold">Tambah Kurikulum Baru</h1>
            <p class="text-muted small mb-0">Input Nama dan seluruh Mata Kuliah Semester 1-8 sekaligus.</p>
        </div>
        <a href="{{ route('curriculums.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <form action="{{ route('curriculums.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <!-- KOLOM KIRI: DATA UTAMA -->
                    <div class="col-xl-8">
                        <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                            <div class="card-header bg-white py-3 border-bottom-0">
                                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-book me-2"></i>Informasi Utama Kurikulum</h6>
                            </div>
                            <div class="card-body p-4 pt-0">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted">Nama Versi Kurikulum</label>
                                    <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none" 
                                           placeholder="Contoh: Kurikulum OBE 2024" required>
                                </div>
                                
                                <!-- Tabel Semester (Input Terintegrasi) -->
                                <div class="mt-4 pt-3 border-top">
                                    <h6 class="mb-3 font-weight-bold text-success small text-uppercase">Daftar Mata Kuliah per Semester</h6>
                                    <div class="card shadow-none border-0" style="border-radius: 12px; overflow: hidden;">
                                        <div class="card-header bg-light p-0 border">
                                            <ul class="nav nav-tabs border-0" id="curriculumTab" role="tablist">
                                                @for($i = 1; $i <= 8; $i++)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $i == 1 ? 'active' : '' }} py-2 px-3 fw-bold border-0" 
                                                       data-toggle="tab" href="#sem-{{ $i }}" role="tab" style="font-size: 0.8rem;">Smt {{ $i }}</a>
                                                </li>
                                                @endfor
                                            </ul>
                                        </div>
                                        <div class="card-body p-0 pt-3">
                                            <div class="tab-content">
                                                @for($i = 1; $i <= 8; $i++)
                                                <div class="tab-pane fade {{ $i == 1 ? 'show active' : '' }}" id="sem-{{ $i }}" role="tabpanel">
                                                    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                                                        <span class="fw-bold small text-dark">Mata Kuliah Semester {{ $i }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="addRow({{ $i }})">+ Baris</button>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered align-middle">
                                                            <thead class="bg-light text-secondary small text-center">
                                                                <tr><th>Kode MK</th><th>Nama MK</th><th width="80">SKS</th><th>Deskripsi</th><th width="40"></th></tr>
                                                            </thead>
                                                            <tbody id="box-{{ $i }}">
                                                                <tr>
                                                                    <input type="hidden" name="subject_semester[]" value="{{ $i }}">
                                                                    <td><input type="text" name="subject_code[]" class="form-control form-control-sm border-0 bg-light" placeholder="Kode"></td>
                                                                    <td><input type="text" name="subject_name[]" class="form-control form-control-sm border-0 bg-light" placeholder="Nama MK"></td>
                                                                    <td><input type="number" name="subject_sks[]" class="form-control form-control-sm border-0 bg-light text-center" value="2"></td>
                                                                    <td><textarea name="subject_description[]" class="form-control form-control-sm border-0 bg-light" rows="1"></textarea></td>
                                                                    <td><button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()"><i class="fas fa-trash-alt"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: PENGATURAN STATUS (Mirroring Kerjasama) -->
                    <div class="col-xl-4">
                        <div class="card shadow-sm border-0" style="border-radius: 15px;">
                            <div class="card-header bg-white py-3 border-bottom-0">
                                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-cog me-2"></i>Status Kurikulum</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <p class="mb-0 fw-bold small">Aktifkan Utama</p>
                                        <small class="text-muted" style="font-size: 0.7rem;">Sebagai kurikulum aktif program studi</small>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked 
                                               style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                    </div>
                                </div>
                                <div class="alert alert-info border-0 mb-0 py-2 px-3 mt-3" style="font-size: 0.75rem; border-radius: 8px;">
                                    <i class="fas fa-info-circle me-1"></i> Kurikulum yang aktif akan menjadi rujukan utama pada semua daftar mata kuliah publik.
                                </div>
                            </div>
                        </div>

<div class="d-flex justify-content-end align-items-center gap-3 mt-4 pt-3 border-top">

    <button type="submit"
            class="btn btn-success px-4 py-2 fw-semibold shadow-sm">
        <i class="fas fa-save me-2"></i>
        Simpan Kurikulum
    </button>

    <a href="{{ route('curriculums.index') }}"
       class="btn btn-outline-secondary px-4 py-2 fw-semibold">
        <i class="fas fa-times me-2"></i>
        Batal
    </a>

</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addRow(smt) {
        const html = `<tr>
            <input type="hidden" name="subject_semester[]" value="${smt}">
            <td><input type="text" name="subject_code[]" class="form-control form-control-sm border-0 bg-light" placeholder="Kode"></td>
            <td><input type="text" name="subject_name[]" class="form-control form-control-sm border-0 bg-light" placeholder="Nama MK"></td>
            <td><input type="number" name="subject_sks[]" class="form-control form-control-sm border-0 bg-light text-center" value="2"></td>
            <td><textarea name="subject_description[]" class="form-control form-control-sm border-0 bg-light" rows="1"></textarea></td>
            <td><button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()"><i class="fas fa-trash-alt"></i></button></td>
        </tr>`;
        document.getElementById('box-' + smt).insertAdjacentHTML('beforeend', html);
    }
</script>
<style>
    .nav-tabs .nav-link { color: #6c757d; }
    .nav-tabs .nav-link.active { color: #198754 !important; background-color: transparent !important; border-bottom: 2px solid #198754 !important; }
</style>
@endpush
@endsection