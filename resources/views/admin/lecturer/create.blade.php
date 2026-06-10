@extends('layouts.admin')

@section('title', 'Tambah Personel')

@section('content')
<div class="container-fluid px-4 pb-5">
    <div class="mt-4 mb-4 d-flex align-items-center justify-content-between">
        <div>
            <h1 class="h3 text-gray-800 font-weight-bold">Tambah Personel Baru</h1>
            <p class="text-muted mb-0">Input data dosen, tenaga pendidik, atau staf administrasi.</p>
        </div>
        <a href="{{ route('lecturers.index') }}" class="btn btn-light border px-3 fw-bold small text-muted">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 1. SELEKSI TIPE PERSONEL -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; background: #f8f9fc;">
                    <div class="card-body p-3 d-flex justify-content-center">
                        <div class="btn-group p-1 bg-white shadow-sm rounded-pill" role="group" style="width: 100%; max-width: 450px;">
                            <input type="radio" class="btn-check" name="tipe" id="tipeDosen" value="dosen" autocomplete="off" checked>
                            <label class="btn btn-outline-success border-0 rounded-pill py-2 fw-bold" for="tipeDosen">
                                <i class="fas fa-user-graduate me-2"></i>DOSEN
                            </label>
                            <input type="radio" class="btn-check" name="tipe" id="tipeStaff" value="staff" autocomplete="off">
                            <label class="btn btn-outline-success border-0 rounded-pill py-2 fw-bold" for="tipeStaff">
                                <i class="fas fa-user-tie me-2"></i>STAFF / TENDIK
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- KOLOM KIRI: DATA UTAMA -->
                    <div class="col-xl-8">
                        <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                            <div class="card-header bg-white py-3 border-bottom-0">
                                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-id-card me-2"></i>Identitas & Profil Akademik</h6>
                            </div>
                            <div class="card-body p-4 pt-0">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted">NIP / NIDN</label>
                                        <input type="text" name="nip_nidn" class="form-control bg-light border-0 py-2 shadow-none @error('nip_nidn') is-invalid @enderror" value="{{ old('nip_nidn') }}" required>
                                        @error('nip_nidn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold text-muted">Nama Lengkap & Gelar</label>
                                        <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Email Institusi</label>
                                        <input type="email" name="email" class="form-control bg-light border-0 py-2 shadow-none @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mb-4 border-top pt-4">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted" id="labelJabatan">Jabatan Fungsional</label>
                                        <select name="academic_position" id="academic_position" class="form-select bg-light border-0 shadow-none py-2"></select>
                                        @error('academic_position') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Golongan / Pangkat</label>
                                        <select name="academic_level" class="form-select bg-light border-0 shadow-none py-2">
                                            <option value="III/a - Penata Muda">III/a - Penata Muda</option>
                                            <option value="III/b - Penata Muda Tingkat I">III/b - Penata Muda Tingkat I</option>
                                            <option value="III/c - Penata">III/c - Penata</option>
                                            <option value="III/d - Penata Tingkat I">III/d - Penata Tingkat I</option>
                                            <option value="IV/a - Pembina">IV/a - Pembina</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Lokasi Kantor / Ruang Kerja</label>
                                        <input type="text" name="office" class="form-control bg-light border-0 py-2 shadow-none" placeholder="Contoh: Gedung 5 Lantai 2">
                                    </div>
                                </div>

                                <div class="col-12 border-top pt-4">
                                    <label class="form-label small fw-bold text-muted">Deskripsi / Riwayat Singkat</label>
                                    <textarea name="teaching_history" class="form-control bg-light border-0 shadow-none" rows="4">{{ old('teaching_history') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: FOTO & PUBLIKASI -->
                    <div class="col-xl-4">
                        <div class="row g-4">
                            <!-- FOTO PROFIL -->
                            <div class="col-12">
                                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                                    <div class="card-header bg-white py-3 border-bottom-0">
                                        <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-camera me-2"></i>Foto Profil</h6>
                                    </div>
                                    <div class="card-body text-center pt-0">
                                        <div id="previewContainer" class="mb-3 d-none">
                                            <img id="imagePreview" src="#" class="rounded-3 shadow-sm border" width="130" height="150" style="object-fit: cover;">
                                        </div>
                                        <div class="bg-light p-3 rounded-3 mb-2">
                                            <input type="file" name="image" id="imageInput" class="form-control border-0 bg-transparent shadow-none" accept="image/jpeg,image/png,image/webp">
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">Format: JPG, PNG, WEBP (Maks 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <!-- STATUS PUBLIKASI (switch modern) -->
                            <div class="col-12">
                                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                                    <div class="card-header bg-white py-3 border-bottom-0">
                                        <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-bullhorn me-2"></i>Status Publikasi</h6>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between mb-2">
                                            <div>
                                                <p class="mb-0 fw-bold small">Tampilkan Profil</p>
                                                <small class="text-muted" style="font-size: 0.7rem;">Muncul di website publik</small>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                            </div>
                                        </div>
                                        <div class="alert alert-info border-0 mb-0 py-2 px-3" style="font-size: 0.75rem; border-radius: 8px;">
                                            <i class="fas fa-info-circle me-1"></i> Jika dinonaktifkan, data tetap tersimpan namun tidak bisa dilihat oleh pengunjung website.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAUTAN PROFIL -->
                            <div class="col-12">
                                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-weight-bold text-muted small text-uppercase">Tautan Akademik</h6>
                                        <div class="mb-3">
                                            <div class="input-group bg-light rounded-3 px-2 py-1">
                                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-external-link-alt text-success"></i></span>
                                                <input type="url" name="sinta_url" class="form-control bg-transparent border-0 shadow-none px-1" placeholder="Link SINTA">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="input-group bg-light rounded-3 px-2 py-1">
                                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-university text-success"></i></span>
                                                <input type="url" name="pddikti_url" class="form-control bg-transparent border-0 shadow-none px-1" placeholder="Link PDDIKTI">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIWAYAT PENDIDIKAN (FULL WIDTH) -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0 mt-2" style="border-radius: 15px;">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
                                <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-user-graduate me-2"></i>Riwayat Pendidikan</h6>
                                <button type="button" class="btn btn-sm btn-success px-3 shadow-sm" onclick="addEduRow()" style="border-radius: 8px;">
                                    <i class="fas fa-plus me-1"></i> Tambah Gelar
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light small text-secondary">
                                            <tr>
                                                <th class="ps-4">Jenjang & Gelar</th>
                                                <th>Institusi / Kampus</th>
                                                <th>Program Studi</th>
                                                <th width="150">Tahun Lulus</th>
                                                <th width="80"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="eduContainer">
                                            <tr>
                                                <td class="ps-4"><input type="text" name="degree[]" class="form-control border-0 bg-light shadow-none py-2" placeholder="Contoh: S2 - M.T."></td>
                                                <td><input type="text" name="campus[]" class="form-control border-0 bg-light shadow-none py-2" placeholder="Nama Kampus"></td>
                                                <td><input type="text" name="study_program[]" class="form-control border-0 bg-light shadow-none py-2" placeholder="Bidang Studi"></td>
                                                <td><input type="number" name="graduation_year[]" class="form-control border-0 bg-light shadow-none py-2" placeholder="YYYY"></td>
                                                <td><button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()"><i class="fas fa-trash-alt"></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">

                    <button type="submit"
                            class="btn btn-success px-4 py-2 fw-semibold shadow-sm">
                        <i class="fas fa-save me-2"></i>
                        Simpan Data Dosen
                    </button>

                    <a href="{{ route('lecturers.index') }}"
                    class="btn btn-outline-secondary px-4 py-2 fw-semibold">
                        <i class="fas fa-arrow-left me-2"></i>
                        Batal
                    </a>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addEduRow() {
        $('#eduContainer').append(`
            <tr>
                <td class="ps-4"><input type="text" name="degree[]" class="form-control border-0 bg-light shadow-none py-2"></td>
                <td><input type="text" name="campus[]" class="form-control border-0 bg-light shadow-none py-2"></td>
                <td><input type="text" name="study_program[]" class="form-control border-0 bg-light shadow-none py-2"></td>
                <td><input type="number" name="graduation_year[]" class="form-control border-0 bg-light shadow-none py-2"></td>
                <td><button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()"><i class="fas fa-trash-alt"></i></button></td>
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
            `);
        }
    }
    $('input[name="tipe"]').change(updateOptions);
    updateOptions();

    // Preview dan validasi gambar
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowed.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Format Tidak Didukung', text: 'Gunakan JPG, JPEG, PNG, WEBP.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Maksimal 2MB.', confirmButtonColor: '#198754' });
                this.value = '';
                previewContainer.classList.add('d-none');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                imagePreview.src = ev.target.result;
                previewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });
</script>
@endpush