@extends('layouts.admin')

@section('title', 'Tambah Data Dosen & Staff')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal Simpan!</strong> Ada kesalahan pada input:
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="container-fluid">
    <div class="card shadow mb-4 border-bottom-dark">
        <!-- Header Tema Midnight Espresso -->
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-user-plus mr-2"></i>Tambah Dosen atau Staff Baru
            </h6>
        </div>
        
        <div class="card-body">
            <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- 1. PILIHAN TIPE DOSEN/STAFF -->
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <div class="btn-group btn-group-toggle shadow-sm" data-toggle="buttons">
                            <label class="btn btn-outline-dark active px-4">
                                <input type="radio" name="tipe" id="tipeDosen" value="dosen" checked> <i class="fas fa-chalkboard-teacher"></i> DOSEN
                            </label>
                            <label class="btn btn-outline-dark px-4">
                                <input type="radio" name="tipe" id="tipeStaff" value="staff"> <i class="fas fa-user-cog"></i> STAFF / TENDIK
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 2. IDENTITAS UTAMA -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">NIP / NIDN</label>
                            <input type="text" name="nip_nidn" class="form-control" value="{{ old('nip_nidn') }}" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Nama Lengkap & Gelar</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                    </div>
                </div>

                <!-- 3. JABATAN & GOLONGAN -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark" id="labelJabatan">Jabatan Fungsional</label>
                            <select name="academic_position" id="academic_position" class="form-control">
                                <option value="Asisten Ahli">Asisten Ahli</option>
                                <option value="Lektor">Lektor</option>
                                <option value="Lektor Kepala">Lektor Kepala</option>
                                <option value="Guru Besar">Guru Besar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Golongan / Pangkat</label>
                            <select name="academic_level" class="form-control">
                                <option value="III/a - Penata Muda">III/a - Penata Muda</option>
                                <option value="III/b - Penata Muda Tingkat I">III/b - Penata Muda Tingkat I</option>
                                <option value="III/c - Penata">III/c - Penata</option>
                                <option value="IV/a - Pembina">IV/a - Pembina</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Jabatan Struktural</label>
                            <input type="text" name="structural_position" class="form-control" value="{{ old('structural_position') }}" placeholder="Contoh: Ka. Lab">
                        </div>
                    </div>
                </div>

                <!-- 4. RIWAYAT PENDIDIKAN (Dinamis) -->
                <div class="card border-left-success shadow-sm mb-4 mt-3">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-success small">Riwayat Pendidikan (Sesuai ERD)</h6>
                        <button type="button" class="btn btn-success btn-sm" onclick="addEduRow()">+ Tambah Baris</button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="bg-dark text-white small text-center">
                                <tr>
                                    <th>Gelar (Degree)</th>
                                    <th>Kampus (Campus)</th>
                                    <th>Prodi (Study Program)</th>
                                    <th width="40"></th>
                                </tr>
                            </thead>
                            <tbody id="eduContainer">
                                <tr>
                                    <td><input type="text" name="degree[]" class="form-control form-control-sm" placeholder="S1/S2"></td>
                                    <td><input type="text" name="campus[]" class="form-control form-control-sm" placeholder="Nama Univ"></td>
                                    <td><input type="text" name="study_program[]" class="form-control form-control-sm" placeholder="Jurusan"></td>
                                    <td class="text-center"><button type="button" class="btn btn-link text-danger" onclick="this.closest('tr').remove()">&times;</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 5. KONTAK & LOKASI -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Email Institusi</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Lokasi Kantor</label>
                            <input type="text" name="office" class="form-control" value="{{ old('office') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-dark" id="labelHistory">Riwayat Mengajar</label>
                    <textarea name="teaching_history" class="form-control" rows="3">{{ old('teaching_history') }}</textarea>
                </div>

                <!-- 6. ATASAN & FOTO -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Atasan (Organigram)</label>
                            <select name="parent_id" class="form-control">
                                <option value="">-- Pimpinan Tertinggi --</option>
                                @foreach($leaders as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Foto Profil</label>
                            <input type="file" name="image" class="form-control-file">
                        </div>
                    </div>
                </div>

                <!-- 7. TOMBOL ACTIVE (YANG TADI HILANG) -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-white">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                            <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">
                                Personel Aktif (Muncul di Website Publik)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-lg px-5 shadow" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        SIMPAN DATA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addEduRow() {
        $('#eduContainer').append(`<tr>
            <td><input type="text" name="degree[]" class="form-control form-control-sm"></td>
            <td><input type="text" name="campus[]" class="form-control form-control-sm"></td>
            <td><input type="text" name="study_program[]" class="form-control form-control-sm"></td>
            <td class="text-center"><button type="button" class="btn btn-link text-danger" onclick="this.closest('tr').remove()">&times;</button></td>
        </tr>`);
    }

    $('input[name="tipe"]').change(function() {
        if (this.value === 'staff') {
            $('#labelJabatan').text('Kategori Staff');
            $('#labelHistory').text('Job Desk / Deskripsi Pekerjaan');
            $('#academic_position').html('<option value="Staff Administrasi">Staff Administrasi</option><option value="Laboran">Laboran</option><option value="Teknisi">Teknisi</option>');
        } else {
            $('#labelJabatan').text('Jabatan Fungsional');
            $('#labelHistory').text('Riwayat Mengajar');
            $('#academic_position').html('<option value="Asisten Ahli">Asisten Ahli</option><option value="Lektor">Lektor</option><option value="Lektor Kepala">Lektor Kepala</option><option value="Guru Besar">Guru Besar</option>');
        }
    });
</script>
@endpush