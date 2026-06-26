@extends('layouts.admin')

@section('title', 'Tambah Personel')

@section('content')
<div class="container-fluid px-3 px-md-4 pb-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-4 mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-1">Tambah Personel Baru</h1>
            <p class="text-muted small mb-0">Input data dosen, tenaga pendidik, atau staf administrasi.</p>
        </div>
        <a href="{{ route('lecturers.index') }}" class="btn btn-light border px-3 fw-bold small text-muted shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- KOLOM KIRI: DATA UTAMA -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-id-card me-2"></i>Identitas & Profil</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Tipe Personel (Radio) -->
                        <div class="mb-4 p-2 bg-light rounded-3 d-flex justify-content-center">
                            <div class="btn-group w-100 w-sm-auto p-1 bg-white shadow-sm rounded-pill flex-wrap justify-content-center" role="group" style="max-width: 450px;">
                                <input type="radio" class="btn-check" name="tipe" id="tipeDosen" value="dosen" autocomplete="off" checked>
                                <label class="btn btn-outline-success border-0 rounded-pill py-2 fw-bold flex-grow-1" for="tipeDosen">
                                    <i class="fas fa-user-graduate me-2"></i>DOSEN
                                </label>
                                <input type="radio" class="btn-check" name="tipe" id="tipeStaff" value="staff" autocomplete="off">
                                <label class="btn btn-outline-success border-0 rounded-pill py-2 fw-bold flex-grow-1" for="tipeStaff">
                                    <i class="fas fa-user-tie me-2"></i>STAFF / TENDIK
                                </label>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-bold text-dark">NIP / NIDN <span class="text-danger">*</span></label>
                                <input type="text" name="nip_nidn" class="form-control form-control-custom @error('nip_nidn') is-invalid @enderror"
                                       value="{{ old('nip_nidn') }}" placeholder="NIP/NIDN" required>
                                @error('nip_nidn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-8">
                                <label class="form-label fw-bold text-dark">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Nama dengan gelar" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Email Institusi <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="email@institusi.ac.id" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4 border-top pt-4">
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-bold text-dark" id="labelJabatan">Jabatan Fungsional <span class="text-danger">*</span></label>
                                <select name="academic_position" id="academic_position" class="form-select form-control-custom" required></select>
                                @error('academic_position') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-bold text-dark">Golongan / Pangkat</label>
                                <select name="academic_level" class="form-select form-control-custom">
                                    <option value="III/a - Penata Muda">III/a - Penata Muda</option>
                                    <option value="III/b - Penata Muda Tingkat I">III/b - Penata Muda Tingkat I</option>
                                    <option value="III/c - Penata">III/c - Penata</option>
                                    <option value="III/d - Penata Tingkat I">III/d - Penata Tingkat I</option>
                                    <option value="IV/a - Pembina">IV/a - Pembina</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Lokasi Kantor / Ruang Kerja</label>
                                <input type="text" name="office" class="form-control form-control-custom" placeholder="Contoh: Gedung 5 Lantai 2" value="{{ old('office') }}">
                            </div>
                        </div>

                        <div class="border-top pt-4">
                            <label class="form-label fw-bold text-dark">Deskripsi / Riwayat Singkat</label>
                            <textarea name="teaching_history" class="form-control form-control-custom" rows="4" placeholder="Riwayat akademik, pengalaman mengajar, dll.">{{ old('teaching_history') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pendidikan (Full width di bawah) -->
                <div class="card shadow-sm border-0">
                    <div class="card-header py-3 bg-success text-white d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-user-graduate me-2"></i>Riwayat Pendidikan</h6>
                        <button type="button" class="btn btn-sm btn-light fw-bold text-success px-3" onclick="addEduRow()" style="border-radius: 8px;">
                            <i class="fas fa-plus me-1"></i> Tambah Gelar
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="bg-light text-secondary small text-center">
                                    <tr>
                                        <th class="ps-4">Jenjang & Gelar</th>
                                        <th>Institusi / Kampus</th>
                                        <th>Program Studi</th>
                                        <th width="150">Tahun Lulus</th>
                                        <th width="60"></th>
                                    </tr>
                                </thead>
                                <tbody id="eduContainer">
                                    <tr>
                                        <td class="ps-4"><input type="text" name="degree[]" class="form-control form-control-sm border-0 bg-light" placeholder="S2 - M.T."></td>
                                        <td><input type="text" name="campus[]" class="form-control form-control-sm border-0 bg-light" placeholder="Nama Kampus"></td>
                                        <td><input type="text" name="study_program[]" class="form-control form-control-sm border-0 bg-light" placeholder="Bidang Studi"></td>
                                        <td><input type="number" name="graduation_year[]" class="form-control form-control-sm border-0 bg-light text-center" placeholder="YYYY"></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: FOTO & PUBLIKASI -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                    <div class="card-header bg-success py-3">
                        <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-cog me-2"></i>Foto & Publikasi</h6>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <!-- Upload Foto -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark"><i class="fas fa-camera me-1 text-success"></i> Foto Profil</label>
                            <div id="previewContainer" class="d-none mb-3 text-center">
                                <img id="imagePreview" src="#" class="rounded shadow-sm border border-success" width="120" height="140" style="object-fit: cover;">
                                <small class="text-success fw-bold d-block mt-1" style="font-size:0.72rem;"><i class="fas fa-check-circle me-1"></i> Gambar siap</small>
                            </div>

                            <div id="uploadPlaceholder" class="upload-area">
                                <i class="fas fa-cloud-upload-alt upload-icon text-success"></i>
                                <span class="upload-text">Pilih foto</span>
                                <span class="upload-hint">JPG, JPEG, PNG, WEBP (maks 2MB)</span>
                                <input type="file" name="image" id="imageInput" class="upload-input" accept="image/jpeg,image/png,image/webp">
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Ukuran ideal: 400x500px.
                            </div>
                        </div>

                        <!-- Status Publikasi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Publikasi</label>
                            <div class="publish-toggle">
                                <div>
                                    <p class="mb-0 fw-bold small">Tampilkan Profil</p>
                                    <small class="text-muted" style="font-size:0.7rem;">Muncul di website publik</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked style="width:2.5em;height:1.25em;cursor:pointer;">
                                </div>
                            </div>
                            <div class="alert alert-info border-0 mt-2 py-2 px-3 small" style="border-radius: 8px; font-size:0.75rem;">
                                <i class="fas fa-info-circle me-1"></i> Jika dinonaktifkan, data tetap tersimpan namun tidak tampil di publik.
                            </div>
                        </div>

                        <!-- Tautan Akademik -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Tautan Akademik</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-external-link-alt text-success"></i></span>
                                <input type="url" name="sinta_url" class="form-control form-control-custom border-start-0 ps-0" placeholder="Link SINTA" value="{{ old('sinta_url') }}">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-university text-success"></i></span>
                                <input type="url" name="pddikti_url" class="form-control form-control-custom border-start-0 ps-0" placeholder="Link PDDIKTI" value="{{ old('pddikti_url') }}">
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="d-flex flex-column gap-2">
                            <button type="submit" class="btn-submit-main">
                                <i class="fas fa-save me-2"></i> Simpan Personel
                            </button>
                            <a href="{{ route('lecturers.index') }}" class="btn btn-outline-secondary py-2 text-center" style="border-radius: 9px; font-size: 0.9rem; font-weight: 600;">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addEduRow() {
        $('#eduContainer').append(`
            <tr>
                <td class="ps-4"><input type="text" name="degree[]" class="form-control form-control-sm border-0 bg-light" placeholder="S2 - M.T."></td>
                <td><input type="text" name="campus[]" class="form-control form-control-sm border-0 bg-light" placeholder="Nama Kampus"></td>
                <td><input type="text" name="study_program[]" class="form-control form-control-sm border-0 bg-light" placeholder="Bidang Studi"></td>
                <td><input type="number" name="graduation_year[]" class="form-control form-control-sm border-0 bg-light text-center" placeholder="YYYY"></td>
                <td class="text-center"><button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()"><i class="fas fa-trash-alt"></i></button></td>
            </tr>
        `);
    }

    function updateOptions() {
        const academicPosition = $('#academic_position');
        if (document.getElementById('tipeStaff').checked) {
            $('#labelJabatan').text('Kategori Staff');
            academicPosition.html(`
                <option value="Staff Administrasi">Staff Administrasi</option>
                <option value="Laboran">Laboran</option>
                <option value="Teknisi">Teknisi</option>
                <option value="Lainnya">Lainnya</option>
            `);
        } else {
            $('#labelJabatan').text('Jabatan Fungsional');
            academicPosition.html(`
                <option value="Tenaga Pengajar">Tenaga Pengajar</option>
                <option value="Asisten Ahli">Asisten Ahli</option>
                <option value="Lektor">Lektor</option>
                <option value="Lektor Kepala">Lektor Kepala</option>
                <option value="Guru Besar">Guru Besar</option>
                <option value="Teaching Assistant">Teaching Assistant</option>
            `);
        }
    }
    $('input[name="tipe"]').change(updateOptions);
    updateOptions();

    // Image preview
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowed.includes(file.type) || file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Tidak Valid',
                    text: 'Gunakan JPG/PNG/WEBP maks 2MB.',
                    confirmButtonColor: '#198754'
                });
                this.value = '';
                previewContainer.classList.add('d-none');
                uploadPlaceholder.classList.remove('d-none');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                imagePreview.src = ev.target.result;
                previewContainer.classList.remove('d-none');
                uploadPlaceholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
            uploadPlaceholder.classList.remove('d-none');
        }
    });

    @if($errors->any())
        Swal.fire({
            icon: 'error', title: 'Gagal Menyimpan',
            html: '<ul style="text-align:left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>

<style>
    /* Gaya seragam */
    .form-control-custom {
        border: 1.5px solid #dee2e6; border-radius: 8px; font-size: 0.875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), inset 0 1px 2px rgba(255,255,255,0.9);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control-custom:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,0.12); outline: none; }

    .upload-area {
        position: relative;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 4px; padding: 30px 20px; border: 2px dashed #dee2e6; border-radius: 10px;
        background: #f8f9fa; text-align: center; cursor: pointer;
        transition: background 0.2s;
    }
    .upload-area:hover { background: #f1f3f5; }
    .upload-icon { font-size: 2rem; margin-bottom: 5px; }
    .upload-text { font-size: 0.85rem; font-weight: 600; color: #444; }
    .upload-hint { font-size: 0.72rem; color: #888; }
    .upload-input {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }

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

    .table td, .table th { vertical-align: middle; }
    @media (max-width: 576px) {
        .table td, .table th { white-space: nowrap; }
        .table input, .table textarea { font-size: 0.75rem; }
    }
</style>
@endpush