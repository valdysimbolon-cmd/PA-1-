@extends('layouts.admin')

@section('title', 'Tambah Profil Baru')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Konten Profil</h1>
        <a href="{{ route('profiles.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- 1. PESAN ERROR GLOBAL -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-left-danger" role="alert">
            <h6 class="font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Ada beberapa masalah pada inputan Anda:</h6>
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

    <div class="card shadow mb-4 border-bottom-dark">
        <!-- Header dengan warna Midnight Espresso -->
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-plus-circle mr-2"></i>Formulir Pembuatan Konten Baru
            </h6>
        </div>
        
        <div class="card-body">
            <form action="{{ route('profiles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Kolom Kode Konten (Key) -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kode Navigasi (Sistem)</label>
                            <input type="text" name="key" 
                                   class="form-control @error('key') is-invalid @enderror" 
                                   placeholder="Contoh: VISI_MISI" 
                                   value="{{ old('key') }}" required>
                            @error('key')
                                <div class="invalid-feedback font-weight-bold">{{ $message }}</div>
                            @enderror
                            <small class="text-muted italic">Gunakan huruf besar & underscore. Kode ini digunakan oleh programmer untuk memanggil data.</small>
                        </div>
                    </div>

                    <!-- Kolom Judul Halaman -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Judul Konten (Tampil di Web)</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Contoh: Visi dan Misi Teknik Bioproses" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback font-weight-bold">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Deskripsi dengan Textarea Luas -->
                <div class="form-group mt-3">
                    <label class="font-weight-bold text-dark">Isi Konten / Narasi</label>
                    <div class="@error('description') border border-danger rounded @enderror">
                        <textarea name="description" id="editor" 
                                  class="form-control" 
                                  rows="12" placeholder="Tuliskan sejarah, visi, atau misi secara detail di sini..." 
                                  >{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <div class="text-danger small font-weight-bold mt-1">{{ $message }}</div>
                    @enderror
                </div>

               <!-- Baris Upload Gambar dengan Preview -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Gambar/Foto Pendukung</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="imageInput" accept="image/*">
                                    <label class="custom-file-label" for="imageInput">Pilih file gambar...</label>
                                </div>
                            </div>
                            <!-- Wadah Pratinjau Gambar -->
                            <div id="previewContainer" class="mt-3 d-none">
                                <label class="d-block small font-weight-bold text-muted">Pratinjau Gambar:</label>
                                <img id="imagePreview" src="#" alt="Preview" 
                                     class="img-thumbnail shadow-sm" 
                                     style="max-height: 200px; border: 2px solid #C5E384;">
                            </div>
                            @error('image')
                                <div class="text-danger small font-weight-bold mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">Format: JPG, PNG, JPEG. Maksimal: 2MB.</small>
                        </div>
                    </div>
                </div>

                <!-- Baris Status Terbit -->
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-light">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="active" style="color: #200F07; cursor:pointer;">
                                <i class="fas fa-globe-asia mr-1"></i> Terbitkan Konten ini ke Website Publik
                            </label>
                            <p class="small text-muted mb-0 ml-4">Jika dinonaktifkan, konten hanya tersimpan di database sebagai draf.</p>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end mb-4">
                    <button type="reset" id="resetBtn" class="btn btn-light border mr-2">
                        <i class="fas fa-undo"></i> Bersihkan Form
                    </button>
                    <button type="submit" class="btn shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-1"></i> Simpan Konten Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 1. Logika Menampilkan Nama File & Preview Gambar
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Tampilkan nama file di label
            let fileName = file.name;
            this.nextElementSibling.innerText = fileName;

            // Proses Preview Gambar
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // 2. Logika Tombol Reset (Sembunyikan preview saat form di-reset)
    document.getElementById('resetBtn').addEventListener('click', function() {
        previewContainer.classList.add('d-none');
        document.querySelector('.custom-file-label').innerText = "Pilih file gambar...";
    });
</script>
@endpush