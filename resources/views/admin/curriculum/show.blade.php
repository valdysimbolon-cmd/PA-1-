@extends('layouts.admin')
@section('content')
<div class="mb-4">
    <a href="{{ route('curriculums.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow mb-4 border-left-success">
    <div class="card-body">
        <h4 class="font-weight-bold text-dark">{{ $curriculum->name }}</h4>
        <p class="mb-0">Status: <span class="badge {{ $curriculum->active ? 'badge-success' : 'badge-secondary' }}">{{ $curriculum->active ? 'Aktif' : 'Arsip' }}</span></p>
    </div>
</div>

<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background-color: #200F07;">
        <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Mata Kuliah di Kurikulum Ini</h6>
        <a href="{{ route('subjects.create', ['curriculum_id' => $curriculum->id]) }}" class="btn btn-sm btn-light">
            <i class="fas fa-plus"></i> Tambah Matkul ke Versi Ini
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Matakuliah</th>
                    <th>SKS</th>
                    <th>SMT</th>
                </tr>
            </thead>
            <tbody>
                @forelse($curriculum->subjects as $sub)
                <tr>
                    <td><code>{{ $sub->code }}</code></td>
                    <td>{{ $sub->name }}</td>
                    <td>{{ $sub->sks }}</td>
                    <td>{{ $sub->semester }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Belum ada mata kuliah terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection