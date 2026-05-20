@extends('layouts.admin')

@section('title', 'Tambah Mitra')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Formulir Mitra Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('cooperations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Instansi/Perusahaan</label>
                            <input type="text" name="name" class="form-control" required placeholder="Contoh: PT. Pertamina">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Tipe Kerjasama</label>
                            <select name="type" class="form-control" required>
                                <option value="Industri">Industri</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Pemerintah">Pemerintah</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Berakhir</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Website Resmi (URL)</label>
                    <input type="url" name="website_url" class="form-control" placeholder="https://example.com">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Deskripsi Singkat Kerjasama</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Logo Mitra</label>
                    <input type="file" name="logo" class="form-control-file border p-1 rounded w-100" id="imageInput">
                    <img id="preview" src="#" class="mt-2 d-none img-thumbnail" width="120">
                </div>

                <div class="custom-control custom-switch p-3 border rounded mb-4 bg-light">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                    <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">Tampilkan Logo di Website Publik</label>
                </div>

                <button type="submit" class="btn shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
                    <i class="fas fa-save mr-1"></i> Simpan Data Mitra
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            preview.src = URL.createObjectURL(file)
            preview.classList.remove('d-none')
        }
    }
</script>
@endpush