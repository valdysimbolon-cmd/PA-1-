@extends('layouts.admin')

@section('title', 'Edit Data Dosen: ' . $lecturer->name)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Personel: {{ $lecturer->name }}</h1>
        <a href="{{ route('lecturers.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Batal & Kembali
        </a>
    </div>

    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-user-edit mr-2"></i>Formulir Pembaruan Data
            </h6>
        </div>
        
        <div class="card-body">
            <!-- PENTING: Gunakan @method('PUT') untuk proses update -->
            <form action="{{ route('lecturers.update', $lecturer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">NIP / NIDN</label>
                            <input type="text" name="nip_nidn" class="form-control @error('nip_nidn') is-invalid @enderror" 
                                   value="{{ old('nip_nidn', $lecturer->nip_nidn) }}" required>
                            @error('nip_nidn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Nama Lengkap & Gelar</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $lecturer->name) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Jabatan Fungsional</label>
                            <select name="academic_position" class="form-control">
                                @foreach(['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar', 'Tenaga Pengajar'] as $pos)
                                    <option value="{{ $pos }}" {{ old('academic_position', $lecturer->academic_position) == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Golongan Kepangkatan</label>
                            <select name="academic_level" class="form-control">
                                @foreach(['III/a - Penata Muda', 'III/b - Penata Muda Tingkat I', 'III/c - Penata', 'IV/a - Pembina'] as $lvl)
                                    <option value="{{ $lvl }}" {{ old('academic_level', $lecturer->academic_level) == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Jabatan Struktur (Dinamis)</label>
                            <input type="text" name="structural_position" class="form-control" 
                                   value="{{ old('structural_position', $lecturer->structural_position) }}">
                        </div>
                    </div>
                </div>

                <!-- RELASI HIERARKI (Update Atasan) -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="p-3 border rounded shadow-sm" style="border-left: 5px solid #C5E384; background-color: #f8f9fc;">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-primary"><i class="fas fa-sitemap mr-2"></i>Ubah Atasan Langsung</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">-- Tidak Ada (Pimpinan Tertinggi) --</option>
                                    @foreach($leaders as $leader)
                                        <option value="{{ $leader->id }}" {{ old('parent_id', $lecturer->parent_id) == $leader->id ? 'selected' : '' }}>
                                            {{ $leader->name }} ({{ $leader->structural_position ?? 'Dosen' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto dengan Preview Foto Lama -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Foto Profil</label>
                            <div class="d-flex align-items-start">
                                <div class="mr-4 text-center">
                                    <p class="small text-muted mb-1">Foto Saat Ini:</p>
                                    @if($lecturer->image)
                                        <img src="{{ asset('storage/' . $lecturer->image) }}" class="img-thumbnail" width="120">
                                    @else
                                        <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="width:120px; height:120px;">
                                            <span class="small text-muted">Tanpa Foto</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <p class="small text-muted mb-1">Ganti Foto Baru:</p>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="imageInput">
                                        <label class="custom-file-label" for="imageInput">Pilih file baru...</label>
                                    </div>
                                    <div id="previewContainer" class="mt-3 d-none">
                                        <img id="imagePreview" src="#" alt="Pratinjau" class="img-thumbnail" style="max-height: 150px; border: 2px solid #C5E384;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Switch Active -->
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="custom-control custom-switch p-3 border rounded shadow-sm bg-white">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" {{ old('active', $lecturer->active) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-success" for="active" style="cursor:pointer;">
                                Personel Aktif (Tampil di Website)
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">
                <div class="text-right mb-4">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-check-circle mr-2"></i>Simpan Perubahan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            this.nextElementSibling.innerText = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush