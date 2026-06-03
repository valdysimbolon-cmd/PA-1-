@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tambah Dosen atau Staff Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-dark active px-4">
                                <input type="radio" name="tipe" value="dosen" checked> DOSEN
                            </label>
                            <label class="btn btn-outline-dark px-4">
                                <input type="radio" name="tipe" value="staff"> STAFF
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4"><label>NIP / NIDN</label><input type="text" name="nip_nidn" class="form-control" required></div>
                    <div class="col-md-8"><label>Nama Lengkap & Gelar</label><input type="text" name="name" class="form-control" required></div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label id="labelJabatan">Jabatan Fungsional</label>
                        <select name="academic_position" id="academic_position" class="form-control">
                            <option value="Asisten Ahli">Asisten Ahli</option>
                            <option value="Lektor">Lektor</option>
                            <option value="Lektor Kepala">Lektor Kepala</option>
                            <option value="Guru Besar">Guru Besar</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Golongan</label>
                        <select name="academic_level" class="form-control">
                            <option value="III/a - Penata Muda">III/a - Penata Muda</option>
                            <option value="III/b - Penata Muda Tingkat I">III/b - Penata Muda Tingkat I</option>
                            <option value="III/c - Penata">III/c - Penata</option>
                            <option value="IV/a - Pembina">IV/a - Pembina</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-4"><label>Struktural</label><input type="text" name="structural_position" class="form-control"></div>
                </div>

                <!-- RIWAYAT PENDIDIKAN -->
                <div class="card border-left-success shadow-sm my-4">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-success small">Riwayat Pendidikan</h6>
                        <button type="button" class="btn btn-success btn-sm" onclick="addEduRow()">+ Tambah</button>
                    </div>
                    <table class="table table-sm mb-0">
                        <tbody id="eduContainer">
                            <tr>
                                <td><input type="text" name="degree[]" class="form-control" placeholder="Gelar"></td>
                                <td><input type="text" name="campus[]" class="form-control" placeholder="Kampus"></td>
                                <td><input type="text" name="study_program[]" class="form-control" placeholder="Prodi"></td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">&times;</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="col-md-6"><label>Kantor</label><input type="text" name="office" class="form-control"></div>
                </div>

                <div class="form-group mt-3"><label id="labelHistory">Riwayat Mengajar</label><textarea name="teaching_history" class="form-control" rows="3"></textarea></div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Atasan (Organigram)</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Pimpinan Tertinggi --</option>
                            @foreach($leaders as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6"><label>Foto Profil</label><input type="file" name="image" class="form-control-file"></div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded mt-4">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label text-success font-weight-bold" for="active">Tampilkan di Website</label>
                </div>

                <div class="mt-4 text-right">
                    <button type="submit" class="btn btn-lg px-5 shadow" style="background-color: #C5E384; color: #200F07; font-weight: bold;">SIMPAN DATA DOSEN</button>
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
            <td><input type="text" name="degree[]" class="form-control"></td>
            <td><input type="text" name="campus[]" class="form-control"></td>
            <td><input type="text" name="study_program[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">&times;</button></td>
        </tr>`);
    }

    $('input[name="tipe"]').change(function() {
        if (this.value === 'staff') {
            $('#labelJabatan').text('Kategori Staff');
            $('#labelHistory').text('Job Desk');
            $('#academic_position').html('<option value="Staff Administrasi">Staff Administrasi</option><option value="Laboran">Laboran</option><option value="Teknisi">Teknisi</option>');
        } else {
            $('#labelJabatan').text('Jabatan Fungsional');
            $('#labelHistory').text('Riwayat Mengajar');
            $('#academic_position').html('<option value="Asisten Ahli">Asisten Ahli</option><option value="Lektor">Lektor</option><option value="Lektor Kepala">Lektor Kepala</option><option value="Guru Besar">Guru Besar</option>');
        }
    });
</script>
@endpush