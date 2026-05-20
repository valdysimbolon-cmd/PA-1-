@extends('layouts.admin')
@section('title', 'Daftar Kurikulum')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Kurikulum</h1>
    <a href="{{ route('curriculums.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
        <i class="fas fa-plus fa-sm"></i> Tambah Kurikulum
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3" style="background-color: #200F07;">
        <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Versi Kurikulum Prodi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Kurikulum</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculums as $curr)
                    <tr>
                        <td><strong>{{ $curr->name }}</strong></td>
                        <td>
                            <span class="badge {{ $curr->active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $curr->active ? 'Aktif' : 'Arsip' }}
                            </span>
                        </td>
                        <td><small>{{ $curr->creator->name ?? 'System' }}</small></td>
                        <td>
                            <a href="{{ route('curriculums.show', $curr->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail Matkul</a>
                            <a href="{{ route('curriculums.edit', $curr->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection