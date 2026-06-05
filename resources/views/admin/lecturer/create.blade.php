@extends('layouts.admin')

@section('title', 'Tambah Personel')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger mb-4 small">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;"><i class="fas fa-plus-circle me-2"></i>Tambah Dosen atau Staff Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4 text-center">
                    <div class="col-12">
                        <div class="btn-group shadow-sm">
                            <input type="radio" class="btn-check" name="tipe" id="tipeDosen" value="dosen" checked>
                            <label class="btn btn-outline-dark px-4" for="tipeDosen">DOSEN</label>
                            <input type="radio" class="btn-check" name="tipe" id="tipeStaff" value="staff">
                            <label class="btn btn-outline-dark px-4" for="tipeStaff">STAFF / TENDIK</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-3"><label class="fw-bold">NIP / NIDN</label><input type="text" name="nip_nidn" class="form-control" value="{{ old('nip_nidn') }}" required></div>
                    <div class="col-md-6"><label class="fw-bold">Nama Lengkap & Gelar</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
                    <div class="col-md-3"><label class="fw-bold">Email Institusi</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6"><label class="fw-bold text-primary">Link SINTA</label><input type="url" name="sinta_url" class="form-control" value="{{ old('sinta_url') }}"></div>
                    <div class="col-md-6"><label class="fw-bold text-primary">Link PDDIKTI</label><input type="url" name="pddikti_url" class="form-control" value="{{ old('pddikti_url') }}"></div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="fw-bold" id="labelJabatan">Jabatan Fungsional</label>
                        <select name="academic_position" id="academic_position" class="form-select"></select>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Golongan</label>
                        <select name="academic_level" class="form-select">
                            <option value="III/a - Penata Muda">III/a - Penata Muda</option>
                            <option value="III/b - Penata Muda Tingkat I">III/b - Penata Muda Tingkat I</option>
                            <option value="III/c - Penata">III/c - Penata</option>
                            <option value="III/d - Penata Tingkat I">III/d - Penata Tingkat I</option>
                            <option value="IV/a - Pembina">IV/a - Pembina</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-4"><label class="fw-bold">Lokasi Kantor</label><input type="text" name="office" class="form-control" value="{{ old('office') }}"></div>
                </div>

                <div class="card border mt-4 mb-3">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                        <span class="fw-semibold small">Riwayat Pendidikan</span>
                        <button type="button" class="btn btn-sm btn-success" onclick="addEduRow()">+ Tambah</button>
                    </div>
                    <table class="table table-sm mb-0"><tbody id="eduContainer">
                        <tr>
                            <td><input type="text" name="degree[]" class="form-control" placeholder="Gelar"></td>
                            <td><input type="text" name="campus[]" class="form-control" placeholder="Kampus"></td>
                            <td><input type="text" name="study_program[]" class="form-control" placeholder="Prodi"></td>
                            <td><input type="number" name="graduation_year[]" class="form-control" placeholder="Tahun"></td>
                            <td><button type="button" class="btn btn-sm text-danger" onclick="this.closest('tr').remove()">×</button></td>
                        </tr>
                    </tbody></table>
                </div>

                <div class="form-group"><label class="fw-bold">Riwayat Mengajar / Deskripsi</label><textarea name="teaching_history" class="form-control" rows="3">{{ old('teaching_history') }}</textarea></div>
                
                <div class="row mt-3">
                    <div class="col-md-6"><label class="fw-bold">Foto Profil</label><input type="file" name="image" class="form-control-file"></div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked>
                            <label class="form-check-label fw-bold text-success" for="active">Aktif di Web</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end"><button type="submit" class="btn btn-success px-5">SIMPAN DATA</button></div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addEduRow() {
        $('#eduContainer').append(`<tr>
            <td><input type="text" name="degree[]" class="form-control"></td>
            <td><input type="text" name="campus[]" class="form-control"></td>
            <td><input type="text" name="study_program[]" class="form-control"></td>
            <td><input type="number" name="graduation_year[]" class="form-control"></td>
            <td><button type="button" class="btn btn-sm text-danger" onclick="this.closest('tr').remove()">×</button></td>
        </tr>`);
    }

    function updateOptions() {
        const academicPosition = $('#academic_position');
        if (document.getElementById('tipeStaff').checked) {
            $('#labelJabatan').text('Kategori Staff');
            academicPosition.html(`
                <option value="Laboran">Laboran</option>
                <option value="Teknisi">Teknisi</option>
                <option value="Staff Administrasi">Staff Administrasi</option>
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
</script>
@endpush