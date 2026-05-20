@extends('layouts.admin')

@section('title', 'Tambah Prestasi Baru')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">
                <i class="fas fa-trophy mr-2"></i>Catat Prestasi Baru
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('achievements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- 1. DATA INDUK PRESTASI -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Judul Prestasi / Nama Lomba</label>
                            <input type="text" name="title" class="form-control" placeholder="Contoh: Juara 1 Nasional Lomba Karya Tulis Ilmiah" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Pemenang Utama (Label Tampilan)</label>
                            <input type="text" name="winner_name" class="form-control" placeholder="Contoh: Tim Bioproses A / Nama Individu" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Kategori</label>
                            <select name="category" class="form-control" required>
                                <option value="Students">Mahasiswa</option>
                                <option value="Lecturers">Dosen</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Tingkat</label>
                            <select name="level" class="form-control" required>
                                <option value="Regional">Regional / Lokal</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Tahun</label>
                            <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Peringkat (Rank)</label>
                            <input type="text" name="rank" class="form-control" placeholder="Contoh: Juara 1 / Emas">
                        </div>
                    </div>
                </div>

                <!-- 2. DATA RELASI (ANGGOTA TIM) -->
                <div class="p-3 border rounded shadow-sm bg-light mt-4 mb-4">
                    <label class="font-weight-bold text-primary"><i class="fas fa-users mr-2"></i>Hubungkan Personel (Mahasiswa & Dosen Pembimbing)</label>
                    <hr class="mt-1">
                    
                    <div id="member-container">
                        <!-- Baris anggota akan muncul di sini via JavaScript -->
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-member">
                        <i class="fas fa-plus"></i> Tambah Anggota / Pembimbing
                    </button>
                    <small class="d-block text-muted mt-2">*Gunakan ini agar prestasi muncul otomatis di profil Dosen/Mahasiswa terkait.</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Foto / Bukti Prestasi</label>
                            <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded w-100">
                            <img id="preview" src="#" class="mt-2 d-none img-thumbnail" width="150">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Keterangan Singkat</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Ceritakan singkat tentang prestasi ini..."></textarea>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="text-right">
                    <button type="submit" class="btn shadow-sm px-5" style="background-color: #C5E384; color: #200F07; font-weight: bold; border: 1px solid #200F07;">
                        <i class="fas fa-save mr-2"></i>Simpan Prestasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- TEMPLATE BARIS ANGGOTA (HIDDEN) -->
<template id="member-row-template">
    <div class="row member-row mb-3 animated fadeIn">
        <div class="col-md-3">
            <select name="member_types[]" class="form-control form-control-sm" required>
                <option value="Student">Mahasiswa</option>
                <option value="Lecturer">Dosen / Pembimbing</option>
            </select>
        </div>
        <div class="col-md-5">
            <select name="member_ids[]" class="form-control form-control-sm select-person" required>
                <option value="">-- Pilih Orang --</option>
                <optgroup label="Mahasiswa">
                    @foreach($students as $s) <option value="{{ $s->id }}">{{ $s->nim }} - {{ $s->name }}</option> @endforeach
                </optgroup>
                <optgroup label="Dosen">
                    @foreach($lecturers as $l) <option value="{{ $l->id }}">{{ $l->name }}</option> @endforeach
                </optgroup>
            </select>
        </div>
        <div class="col-md-3">
            <select name="roles[]" class="form-control form-control-sm">
                <option value="Ketua">Ketua Kelompok</option>
                <option value="Anggota">Anggota</option>
                <option value="Pembimbing">Dosen Pembimbing</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-member"><i class="fas fa-times"></i></button>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    const container = document.getElementById('member-container');
    const template = document.getElementById('member-row-template').content;

    document.getElementById('add-member').addEventListener('click', () => {
        const clone = template.cloneNode(true);
        container.appendChild(clone);
    });

    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-member')) {
            e.target.closest('.member-row').remove();
        }
    });

    // Preview Gambar
    imageInput.onchange = evt => {
        const [file] = imageInput.files
        if (file) { preview.src = URL.createObjectURL(file); preview.classList.remove('d-none'); }
    }
</script>
@endpush