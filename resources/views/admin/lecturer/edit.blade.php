@extends('layouts.admin')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger mb-4 small">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-white">Edit Data: {{ $lecturer->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('lecturers.update', $lecturer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                @php $isStaff = in_array($lecturer->academic_position, ['Staff Administrasi', 'Laboran', 'Teknisi', 'Kebersihan', 'Lainnya']); @endphp
                <div class="row mb-4 text-center">
                    <div class="col-12">
                        <div class="btn-group shadow-sm">
                            <input type="radio" class="btn-check" name="tipe" id="tipeDosen" value="dosen" {{ !$isStaff ? 'checked' : '' }}>
                            <label class="btn btn-outline-dark px-4" for="tipeDosen">DOSEN</label>
                            <input type="radio" class="btn-check" name="tipe" id="tipeStaff" value="staff" {{ $isStaff ? 'checked' : '' }}>
                            <label class="btn btn-outline-dark px-4" for="tipeStaff">STAFF / TENDIK</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-3"><label class="fw-bold">NIP / NIDN</label><input type="text" name="nip_nidn" class="form-control" value="{{ $lecturer->nip_nidn }}" required></div>
                    <div class="col-md-6"><label class="fw-bold">Nama Lengkap</label><input type="text" name="name" class="form-control" value="{{ $lecturer->name }}" required></div>
                    <div class="col-md-3"><label class="fw-bold">Email</label><input type="email" name="email" class="form-control" value="{{ $lecturer->email }}" required></div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6"><label class="fw-bold text-primary">Link SINTA</label><input type="url" name="sinta_url" class="form-control" value="{{ $lecturer->sinta_url }}"></div>
                    <div class="col-md-6"><label class="fw-bold text-primary">Link PDDIKTI</label><input type="url" name="pddikti_url" class="form-control" value="{{ $lecturer->pddikti_url }}"></div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="fw-bold" id="labelJabatan">Jabatan</label>
                        <select name="academic_position" id="academic_position" class="form-select"></select>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Golongan</label>
                        <select name="academic_level" class="form-select">
                            @foreach(['III/a - Penata Muda', 'III/b - Penata Muda Tingkat I', 'III/c - Penata', 'III/d - Penata Tingkat I', 'IV/a - Pembina', 'Lainnya'] as $lvl)
                                <option value="{{ $lvl }}" {{ $lecturer->academic_level == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4"><label class="fw-bold">Lokasi Kantor</label><input type="text" name="office" class="form-control" value="{{ $lecturer->office }}"></div>
                </div>

                <div class="card border mt-4 mb-3">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold small">Update Riwayat Pendidikan</span>
                        <button type="button" class="btn btn-sm btn-success" onclick="addEduRow()">+ Tambah</button>
                    </div>
                    <table class="table table-sm mb-0"><tbody id="eduContainer">
                        @foreach($lecturer->educations as $edu)
                        <tr>
                            <td><input type="text" name="degree[]" class="form-control" value="{{ $edu->degree }}"></td>
                            <td><input type="text" name="campus[]" class="form-control" value="{{ $edu->campus }}"></td>
                            <td><input type="text" name="study_program[]" class="form-control" value="{{ $edu->study_program }}"></td>
                            <td><input type="number" name="graduation_year[]" class="form-control" value="{{ $edu->graduation_year }}"></td>
                            <td><button type="button" class="btn btn-sm text-danger" onclick="this.closest('tr').remove()">×</button></td>
                        </tr>
                        @endforeach
                    </tbody></table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12"><label class="fw-bold">Riwayat Mengajar</label><textarea name="teaching_history" class="form-control" rows="3">{{ $lecturer->teaching_history }}</textarea></div>
                </div>

                <div class="form-check form-switch mt-4 p-3 border rounded bg-light">
                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" {{ $lecturer->active ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-success ms-2" for="active">Tampilkan di Web</label>
                </div>

                <div class="mt-4 text-end"><button type="submit" class="btn btn-primary px-5 shadow-sm">SIMPAN PERUBAHAN</button></div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addEduRow() {
        $('#eduContainer').append(`<tr><td><input type="text" name="degree[]" class="form-control"></td><td><input type="text" name="campus[]" class="form-control"></td><td><input type="text" name="study_program[]" class="form-control"></td><td><input type="number" name="graduation_year[]" class="form-control"></td><td><button type="button" class="btn btn-sm text-danger" onclick="this.closest('tr').remove()">×</button></td></tr>`);
    }

    const currentPos = "{{ $lecturer->academic_position }}";
    function updateOptions() {
        const academicPosition = $('#academic_position');
        if (document.getElementById('tipeStaff').checked) {
            $('#labelJabatan').text('Kategori Staff');
            academicPosition.html(`
                <option value="Laboran" ${currentPos == 'Laboran' ? 'selected' : ''}>Laboran</option>
                <option value="Teknisi" ${currentPos == 'Teknisi' ? 'selected' : ''}>Teknisi</option>
                <option value="Staff Administrasi" ${currentPos == 'Staff Administrasi' ? 'selected' : ''}>Staff Administrasi</option>
                <option value="Lainnya" ${currentPos == 'Lainnya' ? 'selected' : ''}>Lainnya</option>
            `);
        } else {
            $('#labelJabatan').text('Jabatan Fungsional');
            academicPosition.html(`
                <option value="Tenaga Pengajar" ${currentPos == 'Tenaga Pengajar' ? 'selected' : ''}>Tenaga Pengajar</option>
                <option value="Asisten Ahli" ${currentPos == 'Asisten Ahli' ? 'selected' : ''}>Asisten Ahli</option>
                <option value="Lektor" ${currentPos == 'Lektor' ? 'selected' : ''}>Lektor</option>
                <option value="Lektor Kepala" ${currentPos == 'Lektor Kepala' ? 'selected' : ''}>Lektor Kepala</option>
                <option value="Guru Besar" ${currentPos == 'Guru Besar' ? 'selected' : ''}>Guru Besar</option>
            `);
        }
    }
    $('input[name="tipe"]').change(updateOptions);
    updateOptions();
</script>
@endpush