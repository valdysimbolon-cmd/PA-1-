@extends('layouts.admin')

@section('title', 'Tambah Prestasi Baru')

@section('content')
<div class="container-fluid">
    {{-- PESAN ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;"><i class="fas fa-trophy mr-2"></i>Catat Prestasi Baru</h6>
        </div>
        <div class="card-body text-dark">
            <form action="{{ route('achievements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Judul Prestasi / Nama Lomba</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Pemenang Utama (Tampilan)</label>
                            <input type="text" name="winner_name" class="form-control" value="{{ old('winner_name') }}" placeholder="Contoh: Valdy dkk" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Kategori Utama</label>
                            <select name="category" class="form-control">
                                <option value="students">Mahasiswa</option>
                                <option value="lecturers">Dosen</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Tingkat</label>
                            <select name="level" class="form-control">
                                <option value="Regional">Regional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Tahun</label>
                            <input type="number" name="year" class="form-control" value="{{ date('Y') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-bold">Peringkat</label>
                            <input type="text" name="rank" class="form-control" placeholder="Juara 1 / Emas">
                        </div>
                    </div>
                </div>

                <!-- HUBUNGKAN KE TABEL RELASI -->
                <div class="p-4 border rounded bg-light my-4">
                    <label class="font-weight-bold text-primary"><i class="fas fa-users mr-2"></i>Personel Terkait (Otomatis Masuk ke Profil)</label>
                    <div id="member-container">
                        {{-- Baris akan muncul di sini --}}
                    </div>
                    <button type="button" class="btn btn-sm btn-dark mt-2" id="add-member">+ Tambah Orang</button>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Foto Bukti</label>
                        <input type="file" name="image" id="imageInput" class="form-control-file border p-1 rounded">
                        <img id="preview" src="#" class="mt-2 d-none img-thumbnail" width="150">
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Deskripsi Tambahan</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-lg px-5 shadow" style="background-color: #C5E384; color: #200F07; font-weight: bold;">SIMPAN PRESTASI</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- TEMPLATE UNTUK JS --}}
<template id="member-row-template">
    <div class="row member-row mb-2">
        <div class="col-md-3">
            <select name="member_types[]" class="form-control form-control-sm">
                <option value="Student">Mahasiswa</option>
                <option value="Lecturer">Dosen / Pembimbing</option>
            </select>
        </div>
        <div class="col-md-5">
            <select name="member_ids[]" class="form-control form-control-sm">
                <option value="">-- Pilih Orang --</option>
                <optgroup label="Mahasiswa">@foreach($students as $s) <option value="{{ $s->id }}">{{ $s->nim }} - {{ $s->name }}</option> @endforeach</optgroup>
                <optgroup label="Dosen">@foreach($lecturers as $l) <option value="{{ $l->id }}">{{ $l->name }}</option> @endforeach</optgroup>
            </select>
        </div>
        <div class="col-md-3">
            <select name="roles[]" class="form-control form-control-sm">
                <option value="Ketua">Ketua</option>
                <option value="Anggota">Anggota</option>
                <option value="Pembimbing">Pembimbing</option>
            </select>
        </div>
        <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-member">×</button></div>
    </div>
</template>
@endsection