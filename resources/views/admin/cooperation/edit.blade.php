@extends('layouts.admin')

@section('title', 'Edit Mitra: ' . $cooperation->name)

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-edit mr-2"></i>Edit Data Mitra: {{ $cooperation->name }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('cooperations.update', $cooperation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Nama Instansi/Perusahaan</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $cooperation->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Tipe Kerjasama</label>
                            <select name="type" class="form-control" required>
                                <option value="Industri" {{ $cooperation->type == 'Industri' ? 'selected' : '' }}>Industri</option>
                                <option value="Akademik" {{ $cooperation->type == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="Pemerintah" {{ $cooperation->type == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $cooperation->start_date }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Tanggal Berakhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $cooperation->end_date }}">
                        </div>
                    </div>
                </div>

                <!-- PENGGANTI WEBSITE URL: DESKRIPSI -->
                <div class="form-group">
                    <label class="font-weight-bold text-dark">Deskripsi Kerjasama</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="4" placeholder="Jelaskan detail kerjasama, misalnya: Program Magang, Riset Bersama, dll...">{{ old('description', $cooperation->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-dark">Logo Saat Ini</label><br>
                    <div class="mb-3">
                        @if($cooperation->logo)
                            <img src="{{ asset('storage/' . $cooperation->logo) }}" width="120" class="img-thumbnail shadow-sm" style="border: 2px solid #C5E384;">
                        @else
                            <span class="badge badge-secondary p-2">Belum ada logo</span>
                        @endif
                    </div>
                    <label class="small text-muted">Ganti Logo Baru (Kosongkan jika tidak ingin mengubah):</label>
                    <input type="file" name="logo" class="form-control-file border p-1 rounded w-100" id="imageInput">
                    <div id="previewContainer" class="mt-2 d-none">
                        <img id="preview" src="#" class="img-thumbnail" width="120" style="border: 2px solid #4CAF7C;">
                    </div>
                </div>

                <div class="custom-control custom-switch p-3 border rounded mb-4 bg-light">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ $cooperation->active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">Tampilkan di Website</label>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('cooperations.index') }}" class="btn btn-secondary border mr-2">Batal</a>
                    <button type="submit" class="btn shadow-sm px-4" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
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
            document.getElementById('previewContainer').classList.remove('d-none')
        }
    }
</script>
@endpush