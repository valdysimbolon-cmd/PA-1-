@extends('layouts.admin')

@section('title', 'Tambah Testimoni')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Testimoni Baru</h1>
        <a href="{{ route('testimonials.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4 border-bottom-success">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Formulir Testimoni Alumni/Mahasiswa</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="Contoh: Valdy Simbolon" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Angkatan (Tahun)</label>
                            <input type="number" name="batch" class="form-control" 
                                   value="{{ old('batch', date('Y')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Pekerjaan/Posisi Saat Ini</label>
                            <input type="text" name="position" class="form-control" 
                                   value="{{ old('position') }}" placeholder="Contoh: Alumni / Researcher">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="font-weight-bold text-dark">Isi Testimoni</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                              rows="4" placeholder="Tuliskan pengalaman selama kuliah di Bioproses..." required>{{ old('content') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Foto Wajah</label>
                            <input type="file" name="photo" id="imageInput" class="form-control-file border p-1 rounded w-100" accept="image/*">
                            <div id="previewContainer" class="mt-3 d-none">
                                <img id="imagePreview" src="#" alt="Pratinjau" class="img-thumbnail shadow-sm" style="max-height: 150px; border: 2px solid #C5E384;">
                            </div>
                            <small class="text-muted">Gunakan foto formal/semi-formal. Maks: 2MB</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light mt-4">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                            <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">Tampilkan di Beranda Web</label>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">
                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-2"></i>Simpan Testimoni
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Logic Preview Gambar
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) {
            imagePreview.src = URL.createObjectURL(file)
            previewContainer.classList.remove('d-none')
        }
    }
</script>
@endpush