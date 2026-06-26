@extends('layouts.admin')

@section('title', 'Edit Kurikulum')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Edit Struktur Kurikulum</h1>
            <p class="text-muted small mb-0">Sedang mengelola: <strong>{{ $curriculum->name }}</strong></p>
        </div>
        <a href="{{ route('curriculums.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('curriculums.update', $curriculum->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-edit me-2"></i>Data Kurikulum & Mata Kuliah</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Nama Kurikulum -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Versi Kurikulum <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror"
                                   value="{{ old('name', $curriculum->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Daftar Mata Kuliah per Semester -->
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-3 fw-bold text-success small text-uppercase">
                                <i class="fas fa-list-ul me-2"></i>Daftar Mata Kuliah per Semester
                            </h6>
                            <div class="card shadow-none border" style="border-radius: 12px; overflow: hidden;">
                                <!-- Tab navigasi dengan scroll horizontal -->
                                <div class="card-header bg-light p-0 border-0 overflow-auto" style="overflow-x: auto; white-space: nowrap;">
                                    <ul class="nav nav-tabs border-0 d-flex flex-nowrap" id="curriculumTab" role="tablist">
                                        @for($i = 1; $i <= 8; $i++)
                                        <li class="nav-item flex-shrink-0">
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
                                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-2 px-1">
                                                <span class="fw-bold small text-dark">Mata Kuliah Semester {{ $i }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="addRow({{ $i }})">
                                                    <i class="fas fa-plus me-1"></i> Baris
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered align-middle mb-0">
                                                    <thead class="bg-light text-secondary small text-center">
                                                        <tr>
                                                            <th>Kode MK</th>
                                                            <th>Nama MK</th>
                                                            <th width="80">SKS</th>
                                                            <th>Deskripsi</th>
                                                            <th width="40"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="box-{{ $i }}">
                                                        @php $subjects = $curriculum->subjects->where('semester', $i); @endphp
                                                        @forelse($subjects as $sub)
                                                        <tr>
                                                            <input type="hidden" name="subject_id[]" value="{{ $sub->id }}">
                                                            <input type="hidden" name="subject_semester[]" value="{{ $i }}">
                                                            <td><input type="text" name="subject_code[]" class="form-control form-control-sm border-0 bg-light" value="{{ old('subject_code.'.$loop->index, $sub->code) }}" required></td>
                                                            <td><input type="text" name="subject_name[]" class="form-control form-control-sm border-0 bg-light" value="{{ old('subject_name.'.$loop->index, $sub->name) }}" required></td>
                                                            <td><input type="number" name="subject_sks[]" class="form-control form-control-sm border-0 bg-light text-center" value="{{ old('subject_sks.'.$loop->index, $sub->sks) }}" required></td>
                                                            <td><textarea name="subject_description[]" class="form-control form-control-sm border-0 bg-light" rows="1" placeholder="Deskripsi singkat">{{ old('subject_description.'.$loop->index, $sub->description) }}</textarea></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted small py-2">Belum ada mata kuliah</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Setiap semester minimal memiliki satu mata kuliah.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: STATUS & AKSI -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Status & Publikasi</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Aktifkan Utama -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Status Kurikulum</label>
                            <div class="publish-toggle">
                                <div>
                                    <p class="mb-0 fw-bold small">Aktifkan Utama</p>
                                    <small class="text-muted" style="font-size:0.7rem;">Sebagai kurikulum aktif program studi</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active"
                                           {{ old('active', $curriculum->active) ? 'checked' : '' }} style="width:2.5em;height:1.25em;cursor:pointer;">
                                </div>
                            </div>
                            <div class="alert alert-info border-0 mt-2 py-2 px-3 small" style="border-radius: 8px; font-size: 0.75rem;">
                                <i class="fas fa-info-circle me-1"></i> Kurikulum yang aktif akan menjadi rujukan utama pada semua daftar mata kuliah publik.
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" class="btn-submit-main">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('curriculums.index') }}" class="btn btn-outline-secondary py-2 text-center" style="border-radius: 9px; font-size: 0.9rem; font-weight: 600;">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function addRow(smt) {
        const html = `<tr>
            <input type="hidden" name="subject_semester[]" value="${smt}">
            <td><input type="text" name="subject_code[]" class="form-control form-control-sm border-0 bg-light" placeholder="Kode"></td>
            <td><input type="text" name="subject_name[]" class="form-control form-control-sm border-0 bg-light" placeholder="Nama MK"></td>
            <td><input type="number" name="subject_sks[]" class="form-control form-control-sm border-0 bg-light text-center" value="2"></td>
            <td><textarea name="subject_description[]" class="form-control form-control-sm border-0 bg-light" rows="1" placeholder="Deskripsi singkat"></textarea></td>
            <td class="text-center"><button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()"><i class="fas fa-trash-alt"></i></button></td>
        </tr>`;
        document.getElementById('box-' + smt).insertAdjacentHTML('beforeend', html);
    }

    @if($errors->any())
        Swal.fire({
            icon: 'error', title: 'Gagal Menyimpan',
            html: '<ul style="text-align:left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Gaya seragam dengan Hero Banner dan Profil */
    .form-control-custom {
        border: 1.5px solid #dee2e6; border-radius: 8px; font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), inset 0 1px 2px rgba(255,255,255,0.9);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control-custom:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,0.12); outline: none; }

    .publish-toggle {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 14px; background: #f8f9fa; border: 1.5px solid #dee2e6; border-radius: 10px;
    }

    .btn-submit-main {
        width: 100%; padding: 11px; border-radius: 9px; border: none;
        background: linear-gradient(135deg, #198754, #20c997); color: #fff;
        font-size: 0.9rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 3px 8px rgba(25,135,84,0.3); transition: all 0.2s;
    }
    .btn-submit-main:hover { opacity: 0.93; transform: translateY(-1px); }

    .sticky-top { top: 80px; }
    @media (max-width: 991px) { .sticky-top { position: relative; top: 0; } }

    .nav-tabs .nav-link { color: #6c757d; }
    .nav-tabs .nav-link.active {
        color: #198754 !important;
        background-color: transparent !important;
        border-bottom: 2px solid #198754 !important;
    }
    .table td, .table th { vertical-align: middle; }
    @media (max-width: 576px) {
        .table td, .table th { white-space: nowrap; }
        .table input, .table textarea { font-size: 0.75rem; }
    }
</style>
@endpush