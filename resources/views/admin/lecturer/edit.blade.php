@extends('layouts.admin')

@section('title', 'Edit Data Personel')

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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data: {{ $lecturer->name }}</h1>
        <a href="{{ route('lecturers.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4 border-bottom-dark">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-user-edit mr-2"></i>Formulir Pembaruan Data
            </h6>
        </div>
        
        <div class="card-body text-dark">
            <form action="{{ route('lecturers.update', $lecturer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @php 
                    $isStaff = in_array($lecturer->academic_position, ['Staff Administrasi', 'Laboran', 'Teknisi']);
                @endphp
                
                <!-- 1. PILIHAN TIPE -->
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <div class="btn-group btn-group-toggle shadow-sm" data-toggle="buttons">
                            <label class="btn btn-outline-dark {{ !$isStaff ? 'active' : '' }}">
                                <input type="radio" name="tipe" id="tipeDosen" value="dosen" {{ !$isStaff ? 'checked' : '' }}> DOSEN
                            </label>
                            <label class="btn btn-outline-dark {{ $isStaff ? 'active' : '' }}">
                                <input type="radio" name="tipe" id="tipeStaff" value="staff" {{ $isStaff ? 'checked' : '' }}> STAFF / TENDIK
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 2. IDENTITAS & FOTO -->
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        <label class="font-weight-bold d-block">Foto Saat Ini</label>
                        @if($lecturer->image)
                            <img src="{{ asset('storage/' . $lecturer->image) }}" class="img-thumbnail mb-2" style="height:150px; width:150px; object-fit:cover">
                        @else
                            <div class="bg-light border rounded mb-2 d-flex align-items-center justify-content-center" style="height:150px">
                                <span class="text-muted small">Tidak Ada Foto</span>
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control-file small">
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">NIP / NIDN</label>
                                    <input type="text" name="nip_nidn" class="form-control" value="{{ old('nip_nidn', $lecturer->nip_nidn) }}" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Lengkap & Gelar</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $lecturer->name) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Email Institusi</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $lecturer->email) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Lokasi Kantor</label>
                                    <input type="text" name="office" class="form-control" value="{{ old('office', $lecturer->office) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. JABATAN -->
                <div class="row mt-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold" id="labelJabatan">{{ $isStaff ? 'Kategori Staff' : 'Jabatan Fungsional' }}</label>
                            <select name="academic_position" id="academic_position" class="form-control">
                                @if($isStaff)
                                    <option value="Staff Administrasi" {{ $lecturer->academic_position == 'Staff Administrasi' ? 'selected' : '' }}>Staff Administrasi</option>
                                    <option value="Laboran" {{ $lecturer->academic_position == 'Laboran' ? 'selected' : '' }}>Laboran</option>
                                    <option value="Teknisi" {{ $lecturer->academic_position == 'Teknisi' ? 'selected' : '' }}>Teknisi</option>
                                @else
                                    <option value="Asisten Ahli" {{ $lecturer->academic_position == 'Asisten Ahli' ? 'selected' : '' }}>Asisten Ahli</option>
                                    <option value="Lektor" {{ $lecturer->academic_position == 'Lektor' ? 'selected' : '' }}>Lektor</option>
                                    <option value="Lektor Kepala" {{ $lecturer->academic_position == 'Lektor Kepala' ? 'selected' : '' }}>Lektor Kepala</option>
                                    <option value="Guru Besar" {{ $lecturer->academic_position == 'Guru Besar' ? 'selected' : '' }}>Guru Besar</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Golongan</label>
                            <select name="academic_level" class="form-control text-dark">
                                @foreach(['III/a - Penata Muda', 'III/b - Penata Muda Tingkat I', 'III/c - Penata', 'IV/a - Pembina'] as $lvl)
                                    <option value="{{ $lvl }}" {{ $lecturer->academic_level == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Struktural</label>
                            <input type="text" name="structural_position" class="form-control" value="{{ old('structural_position', $lecturer->structural_position) }}">
                        </div>
                    </div>
                </div>

                <!-- 4. RIWAYAT PENDIDIKAN (EDIT) -->
                <div class="card border-left-info shadow-sm mb-4 mt-3">
                    <div class="card-header bg-light py-2 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-info small">Riwayat Pendidikan (ERD)</h6>
                        <button type="button" class="btn btn-info btn-sm" onclick="addEduRow()">+ Tambah</button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered mb-0">
                            <tbody id="eduContainer">
                                @foreach($lecturer->educations as $edu)
                                <tr>
                                    <td><input type="text" name="degree[]" class="form-control" value="{{ $edu->degree }}" placeholder="Gelar"></td>
                                    <td><input type="text" name="campus[]" class="form-control" value="{{ $edu->campus }}" placeholder="Kampus"></td>
                                    <td><input type="text" name="study_program[]" class="form-control" value="{{ $edu->study_program }}" placeholder="Prodi"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">&times;</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" id="labelHistory">{{ $isStaff ? 'Deskripsi Pekerjaan' : 'Riwayat Mengajar' }}</label>
                    <textarea name="teaching_history" class="form-control" rows="3">{{ old('teaching_history', $lecturer->teaching_history) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Atasan Langsung</label>
                    <select name="parent_id" class="form-control">
                        <option value="">-- Pimpinan Tertinggi --</option>
                        @foreach($leaders as $l)
                            <option value="{{ $l->id }}" {{ $lecturer->parent_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 5. SWITCH ACTIVE -->
                <div class="custom-control custom-switch p-3 border rounded bg-white shadow-sm mb-4">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $lecturer->active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">Personel Aktif (Muncul di Website Publik)</label>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-lg px-5 shadow" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        UPDATE DATA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addEduRow() {
        $('#eduContainer').append(`<tr>
            <td><input type="text" name="degree[]" class="form-control" placeholder="Gelar"></td>
            <td><input type="text" name="campus[]" class="form-control" placeholder="Kampus"></td>
            <td><input type="text" name="study_program[]" class="form-control" placeholder="Prodi"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">&times;</button></td>
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
@endsection