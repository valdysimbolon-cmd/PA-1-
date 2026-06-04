@extends('layouts.admin')

@section('title', 'Edit Personel')

@section('content')
<div class="container">
    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Gagal Memperbarui:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-edit me-2"></i>Edit Data Personel: {{ $lecturer->name }}
            </h6>
        </div>
        <div class="card-body text-dark">
            <form action="{{ route('lecturers.update', $lecturer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Logic untuk menentukan tipe awal (Dosen/Staff) --}}
                @php 
                    $isStaff = in_array($lecturer->academic_position, ['Staff Administrasi', 'Laboran', 'Teknisi', 'Kebersihan']);
                @endphp

                {{-- 1. Toggle Dosen / Staff --}}
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <div class="btn-group shadow-sm" role="group">
                            <input type="radio" class="btn-check" name="tipe" id="tipeDosen" value="dosen" autocomplete="off" {{ !$isStaff ? 'checked' : '' }}>
                            <label class="btn btn-outline-dark px-4" for="tipeDosen">DOSEN</label>

                            <input type="radio" class="btn-check" name="tipe" id="tipeStaff" value="staff" autocomplete="off" {{ $isStaff ? 'checked' : '' }}>
                            <label class="btn btn-outline-dark px-4" for="tipeStaff">STAFF / TENDIK</label>
                        </div>
                    </div>
                </div>

                {{-- 2. Identitas & Foto --}}
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIP / NIDN</label>
                        <input type="text" name="nip_nidn" class="form-control" value="{{ old('nip_nidn', $lecturer->nip_nidn) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $lecturer->name) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Ganti Foto Profil</label>
                        @if($lecturer->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$lecturer->image) }}" class="img-thumbnail" width="80">
                                <small class="text-muted d-block" style="font-size: 10px;">Foto saat ini</small>
                            </div>
                        @endif
                        <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                    </div>
                </div>

                {{-- 3. Email & Lokasi (YANG SEBELUMNYA HILANG) --}}
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email Institusi</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $lecturer->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Lokasi Kantor / Ruangan</label>
                        <input type="text" name="office" class="form-control" value="{{ old('office', $lecturer->office) }}" placeholder="Contoh: Gedung 5 Lt. 2">
                    </div>
                </div>

                {{-- 4. Jabatan & Golongan --}}
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" id="labelJabatan">{{ $isStaff ? 'Kategori Staff' : 'Jabatan Fungsional' }}</label>
                        <select name="academic_position" id="academic_position" class="form-select">
                            {{-- Opsi diisi otomatis oleh JavaScript di bawah --}}
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Golongan</label>
                        <select name="academic_level" class="form-select">
                            @foreach(['III/a - Penata Muda', 'III/b - Penata Muda Tingkat I', 'III/c - Penata', 'IV/a - Pembina', 'Lainnya'] as $lvl)
                                <option value="{{ $lvl }}" {{ old('academic_level', $lecturer->academic_level) == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jabatan Struktural</label>
                        <input type="text" name="structural_position" class="form-control" value="{{ old('structural_position', $lecturer->structural_position) }}" placeholder="Contoh: Ka. Lab">
                    </div>
                </div>

                {{-- 5. Riwayat Pendidikan (dinamis) --}}
                <div class="card border mt-4 mb-3">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                        <span class="fw-semibold small">Update Riwayat Pendidikan</span>
                        <button type="button" class="btn btn-sm btn-success" onclick="addEduRow()">+ Tambah Baris</button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <thead class="bg-dark text-white small text-center">
                                <tr>
                                    <th>Gelar</th>
                                    <th>Kampus</th>
                                    <th>Prodi</th>
                                    <th width="120">Tahun Lulus</th>
                                    <th width="40"></th>
                                </tr>
                            </thead>
                            <tbody id="eduContainer">
                                @forelse($lecturer->educations as $edu)
                                <tr>
                                    <td><input type="text" name="degree[]" class="form-control form-control-sm" value="{{ $edu->degree }}"></td>
                                    <td><input type="text" name="campus[]" class="form-control form-control-sm" value="{{ $edu->campus }}"></td>
                                    <td><input type="text" name="study_program[]" class="form-control form-control-sm" value="{{ $edu->study_program }}"></td>
                                    <td><input type="number" name="graduation_year[]" class="form-control form-control-sm" value="{{ $edu->graduation_year }}"></td>
                                    <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()">×</button></td>
                                </tr>
                                @empty
                                <tr>
                                    <td><input type="text" name="degree[]" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="campus[]" class="form-control form-control-sm"></td>
                                    <td><input type="text" name="study_program[]" class="form-control form-control-sm"></td>
                                    <td><input type="number" name="graduation_year[]" class="form-control form-control-sm"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()">×</button></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- 6. Riwayat Mengajar --}}
                <div class="mt-3">
                    <label class="form-label fw-semibold" id="labelHistory">{{ $isStaff ? 'Deskripsi Pekerjaan' : 'Riwayat Mengajar' }}</label>
                    <textarea name="teaching_history" class="form-control" rows="3">{{ old('teaching_history', $lecturer->teaching_history) }}</textarea>
                </div>

                {{-- 7. Atasan --}}
                <div class="mt-3">
                    <label class="form-label fw-semibold">Atasan Langsung (Untuk Struktur)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- Pimpinan Tertinggi --</option>
                        @foreach($leaders as $l)
                            <option value="{{ $l->id }}" {{ $lecturer->parent_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 8. Switch Aktif --}}
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ $lecturer->active ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold text-success" for="active">Data Personel Aktif</label>
                </div>

                <hr class="my-4">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('lecturers.index') }}" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">SIMPAN PERUBAHAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addEduRow() {
        const row = `
            <tr>
                <td><input type="text" name="degree[]" class="form-control form-control-sm"></td>
                <td><input type="text" name="campus[]" class="form-control form-control-sm"></td>
                <td><input type="text" name="study_program[]" class="form-control form-control-sm"></td>
                <td><input type="number" name="graduation_year[]" class="form-control form-control-sm"></td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()">×</button></td>
            </tr>
        `;
        document.getElementById('eduContainer').insertAdjacentHTML('beforeend', row);
    }

    // Toggle Dosen/Staff Logic
    const tipeDosen = document.getElementById('tipeDosen');
    const tipeStaff = document.getElementById('tipeStaff');
    const labelJabatan = document.getElementById('labelJabatan');
    const labelHistory = document.getElementById('labelHistory');
    const academicPosition = document.getElementById('academic_position');
    const currentVal = "{{ $lecturer->academic_position }}";

    function updateForm() {
        if (tipeStaff.checked) {
            labelJabatan.innerText = 'Kategori Staff';
            labelHistory.innerText = 'Job Desk / Deskripsi Pekerjaan';
            academicPosition.innerHTML = `
                <option value="Staff Administrasi" ${currentVal == 'Staff Administrasi' ? 'selected' : ''}>Staff Administrasi</option>
                <option value="Laboran" ${currentVal == 'Laboran' ? 'selected' : ''}>Laboran</option>
                <option value="Teknisi" ${currentVal == 'Teknisi' ? 'selected' : ''}>Teknisi</option>
                <option value="Kebersihan" ${currentVal == 'Kebersihan' ? 'selected' : ''}>Kebersihan</option>
            `;
        } else {
            labelJabatan.innerText = 'Jabatan Fungsional';
            labelHistory.innerText = 'Riwayat Mengajar';
            academicPosition.innerHTML = `
                <option value="Asisten Ahli" ${currentVal == 'Asisten Ahli' ? 'selected' : ''}>Asisten Ahli</option>
                <option value="Lektor" ${currentVal == 'Lektor' ? 'selected' : ''}>Lektor</option>
                <option value="Lektor Kepala" ${currentVal == 'Lektor Kepala' ? 'selected' : ''}>Lektor Kepala</option>
                <option value="Guru Besar" ${currentVal == 'Guru Besar' ? 'selected' : ''}>Guru Besar</option>
            `;
        }
    }

    tipeDosen.addEventListener('change', updateForm);
    tipeStaff.addEventListener('change', updateForm);
    window.onload = updateForm; // Jalankan saat pertama kali buka halaman
</script>
@endpush
@endsection