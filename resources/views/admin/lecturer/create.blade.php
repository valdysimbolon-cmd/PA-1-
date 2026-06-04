@extends('layouts.admin')

@section('content')
<div class="container">
    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Tambah Dosen Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Bagian Atas (Tipe, NIP, Nama, Email, Kantor) tetap sama denga sebelumnya --}}
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">NIP / NIDN</label>
                        <input type="text" name="nip_nidn" class="form-control" value="{{ old('nip_nidn') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Foto Profil</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email Institusi</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Lokasi Kantor</label>
                        <input type="text" name="office" class="form-control" value="{{ old('office') }}">
                    </div>
                </div>

                {{-- RIWAYAT PENDIDIKAN --}}
                <div class="card border mt-4 mb-3">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                        <span class="fw-semibold small">Riwayat Pendidikan</span>
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
                                <tr>
                                    <td><input type="text" name="degree[]" class="form-control form-control-sm" placeholder="S1/S2"></td>
                                    <td><input type="text" name="campus[]" class="form-control form-control-sm" placeholder="Nama Univ"></td>
                                    <td><input type="text" name="study_program[]" class="form-control form-control-sm" placeholder="Jurusan"></td>
                                    <td><input type="number" name="graduation_year[]" class="form-control form-control-sm" placeholder="2015"></td>
                                    <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()">×</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label fw-semibold">Riwayat Mengajar</label>
                    <textarea name="teaching_history" class="form-control" rows="3"></textarea>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-5">SIMPAN DATA DOSEN</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // PERBAIKAN: JS harus menyertakan kolom graduation_year agar sinkron denga database
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
</script>
@endpush
@endsection