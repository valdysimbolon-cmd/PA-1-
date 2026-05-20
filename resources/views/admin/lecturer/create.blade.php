@extends('layouts.admin')

@section('title', 'Tambah Data Dosen & Staff')

@section('content')
<div class="container-fluid">
    <!-- Header Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Dosen & Staff</h1>
        <a href="{{ route('lecturers.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- 1. ALERT ERROR GLOBAL -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-left-danger" role="alert">
            <h6 class="font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Ada kesalahan pada pengisian form:</h6>
            <ul class="mb-0 small">
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
        <!-- Header dengan tema Midnight Espresso -->
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-user-plus mr-2"></i>Formulir Tambah Personel Prodi
            </h6>
        </div>
        
        <div class="card-body">
            <form action="{{ route('lecturers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- NIP / NIDN -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">NIP / NIDN</label>
                            <input type="text" name="nip_nidn" 
                                   class="form-control @error('nip_nidn') is-invalid @enderror" 
                                   value="{{ old('nip_nidn') }}" required placeholder="Contoh: 19880101...">
                            @error('nip_nidn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Nama Lengkap & Gelar</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required placeholder="Dr. John Doe, S.T., M.T.">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <!-- Jabatan Fungsional (ENUM) -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Jabatan Fungsional (Akademik)</label>
                            <select name="academic_position" class="form-control @error('academic_position') is-invalid @enderror">
                                <option value="" disabled {{ old('academic_position') == '' ? 'selected' : '' }}>-- Pilih Jabatan --</option>
                                <option value="Asisten Ahli" {{ old('academic_position') == 'Asisten Ahli' ? 'selected' : '' }}>Asisten Ahli</option>
                                <option value="Lektor" {{ old('academic_position') == 'Lektor' ? 'selected' : '' }}>Lektor</option>
                                <option value="Lektor Kepala" {{ old('academic_position') == 'Lektor Kepala' ? 'selected' : '' }}>Lektor Kepala</option>
                                <option value="Guru Besar" {{ old('academic_position') == 'Guru Besar' ? 'selected' : '' }}>Guru Besar</option>
                                <option value="Tenaga Pengajar" {{ old('academic_position') == 'Tenaga Pengajar' ? 'selected' : '' }}>Tenaga Pengajar (Staff)</option>
                            </select>
                            @error('academic_position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Golongan (Sesuai gambar yang tadi) -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Golongan Kepangkatan</label>
                            <select name="academic_level" class="form-control @error('academic_level') is-invalid @enderror">
                                <option value="" disabled {{ old('academic_level') == '' ? 'selected' : '' }}>-- Pilih Golongan --</option>
                                <option value="III/a - Penata Muda" {{ old('academic_level') == 'III/a - Penata Muda' ? 'selected' : '' }}>III/a - Penata Muda</option>
                                <option value="III/b - Penata Muda Tingkat I" {{ old('academic_level') == 'III/b - Penata Muda Tingkat I' ? 'selected' : '' }}>III/b - Penata Muda Tingkat I</option>
                                <option value="III/c - Penata" {{ old('academic_level') == 'III/c - Penata' ? 'selected' : '' }}>III/c - Penata</option>
                                <option value="IV/a - Pembina" {{ old('academic_level') == 'IV/a - Pembina' ? 'selected' : '' }}>IV/a - Pembina</option>
                            </select>
                        </div>
                    </div>

                    <!-- Jabatan Struktur (DINAMIS) -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Jabatan Struktur (Dinamis)</label>
                            <input type="text" name="structural_position" 
                                   class="form-control" value="{{ old('structural_position') }}" 
                                   placeholder="Contoh: Kepala Lab, Sekretaris Prodi">
                        </div>
                    </div>
                </div>

                <!-- RELASI HIERARKI (POHON AKAR) -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="p-3 border rounded shadow-sm" style="border-left: 5px solid #C5E384 !important; background-color: #f8f9fc;">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-primary">
                                    <i class="fas fa-sitemap mr-2"></i>Atasan Langsung (Penyusun Organogram)
                                </label>
                                <select name="parent_id" class="form-control select2">
                                    <option value="">-- Tidak Ada (Pimpinan Tertinggi) --</option>
                                    @foreach($leaders as $leader)
                                        <option value="{{ $leader->id }}" {{ old('parent_id') == $leader->id ? 'selected' : '' }}>
                                            {{ $leader->name }} ({{ $leader->structural_position ?? 'Dosen' }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Gunakan ini untuk membangun bagan organisasi secara otomatis.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Email Institusi</label>
                            <input type="email" name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required placeholder="name@del.ac.id">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Lokasi Ruangan / Office</label>
                            <input type="text" name="office" class="form-control" value="{{ old('office') }}" placeholder="Gedung 5, Ruang 512">
                        </div>
                    </div>
                </div>

                <!-- Riwayat Mengajar (Bisa muat banyak) -->
                <div class="form-group mt-2">
                    <label class="font-weight-bold text-dark">Riwayat Mengajar / Deskripsi Singkat</label>
                    <textarea name="teaching_history" class="form-control" rows="4" placeholder="Sebutkan mata kuliah yang diampu...">{{ old('teaching_history') }}</textarea>
                </div>

                <!-- Foto Profil dengan Preview -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Foto Profil Resmi</label>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="imageInput" accept="image/*">
                                <label class="custom-file-label" for="imageInput">Pilih file foto...</label>
                            </div>
                            <div id="previewContainer" class="mt-3 d-none">
                                <img id="imagePreview" src="#" alt="Pratinjau" 
                                     class="img-thumbnail shadow-sm" 
                                     style="max-height: 180px; border: 2px solid #C5E384;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Aktif (Switch) -->
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-white">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">
                                Personel Aktif (Muncul di Website Publik)
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">

                <div class="d-flex justify-content-end mb-4">
                    <button type="reset" id="resetBtn" class="btn btn-light border mr-2">Reset Form</button>
                    <button type="submit" class="btn shadow-sm px-4" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-2"></i>Simpan Data Personel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 1. Script Pratinjau Gambar & Nama File
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Tampilkan nama file
            this.nextElementSibling.innerText = file.name;
            // Proses Preview
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // 2. Tombol Reset
    document.getElementById('resetBtn').addEventListener('click', function() {
        previewContainer.classList.add('d-none');
        document.querySelector('.custom-file-label').innerText = "Pilih file foto...";
    });
</script>
@endpush