@extends('layouts.admin')

@section('title', 'Tambah Prestasi Baru')

@section('content')
<div class="container-fluid">
    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Gagal Menyimpan:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-trophy me-2"></i> Tambah Prestasi Baru
            </h6>
        </div>
        <div class="card-body text-dark">
            <form action="{{ route('achievements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori Pemenang <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="students" {{ old('category') == 'students' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="lecturers" {{ old('category') == 'lecturers' ? 'selected' : '' }}>Dosen</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Prestasi / Nama Kompetisi <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Juara 1 Nasional Lomba Karya Tulis">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pemenang (Tampilan Web) <span class="text-danger">*</span></label>
                            <input type="text" name="winner_name" class="form-control" value="{{ old('winner_name') }}" required placeholder="Contoh: Tim Biopro A / Nama Individu">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tingkat <span class="text-danger">*</span></label>
                            <select name="level" class="form-select" required>
                                <option value="Regional">Regional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Peringkat / Rank</label>
                    <input type="text" name="rank" class="form-control" value="{{ old('rank') }}" placeholder="Contoh: Juara 1 / Gold Medal">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan / Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Foto Dokumentasi</label>
                    <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                    <img id="preview" class="img-thumbnail mt-2 d-none" width="200">
                </div>

                <hr>
                <div class="border rounded p-4 bg-light mb-4">
                    <h6 class="fw-bold text-primary"><i class="fas fa-link me-2"></i>Personel Terkait (Link ke Profil)</h6>
                    <p class="text-muted small">Hubungkan denga database mahasiswa/dosen agar prestasi ini muncul di profil mereka.</p>
                    
                    <div id="member-container"></div>

                    <button type="button" class="btn btn-outline-dark btn-sm mt-2" id="add-member">
                        <i class="fas fa-plus"></i> Tambah Personel
                    </button>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked>
                    <label class="form-check-label fw-bold text-success" for="active">Aktif (Tampilkan di Web Publik)</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-5 shadow-sm">SIMPAN DATA</button>
                    <a href="{{ route('achievements.index') }}" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Template Baris Personel --}}
<template id="member-row-template">
    <div class="row member-row mb-2">
        <div class="col-md-3">
            <select name="member_types[]" class="form-select form-select-sm">
                <option value="Student">Mahasiswa</option>
                <option value="Lecturer">Dosen / Pembimbing</option>
            </select>
        </div>
        <div class="col-md-5">
            <select name="member_ids[]" class="form-select form-select-sm">
                <option value="">-- Pilih Nama --</option>
                <optgroup label="Mahasiswa">
                    @foreach($students as $s) <option value="{{ $s->id }}">{{ $s->nim }} - {{ $s->name }}</option> @endforeach
                </optgroup>
                <optgroup label="Dosen">
                    @foreach($lecturers as $l) <option value="{{ $l->id }}">{{ $l->name }}</option> @endforeach
                </optgroup>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="roles[]" class="form-control form-control-sm" placeholder="Contoh: Ketua/Anggota">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-member">×</button>
        </div>
    </div>
</template>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('member-container');
        const template = document.getElementById('member-row-template');

        document.getElementById('add-member').addEventListener('click', () => {
            container.appendChild(template.content.cloneNode(true));
        });

        container.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-member')) e.target.closest('.member-row').remove();
        });

        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        imageInput.addEventListener('change', function() {
            const [file] = this.files;
            if (file) { preview.src = URL.createObjectURL(file); preview.classList.remove('d-none'); }
        });
    });
</script>
@endpush
@endsection