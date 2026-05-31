@extends('layouts.admin')

@section('title', 'Daftar Mitra')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mitra Kerja Sama</h1>
        <a href="{{ route('cooperations.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-plus fa-sm"></i> Tambah Mitra Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Instansi Terdaftar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>Logo</th>
                            <th>Nama Instansi</th>
                            <th>Tipe</th>
                            <th>Masa Berlaku</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cooperations as $mitra)
                        <tr>
                            <td class="text-center">
                                @if($mitra->logo)
                                    <img src="{{ asset('storage/' . $mitra->logo) }}" width="60" class="img-thumbnail">
                                @else
                                    <span class="badge badge-light">No Logo</span>
                                @endif
                            </td>
                            <td>
                                <strong title="{{ Str::limit($mitra->description, 100) }}" style="cursor: help;">
                                    {{ $mitra->name }}
                                </strong>
                            </td>
                            <td><span class="badge badge-info">{{ $mitra->type }}</span></td>
                            <td>
                                <small>{{ $mitra->start_date }} s/d {{ $mitra->end_date ?? 'Selamanya' }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $mitra->active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $mitra->active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('cooperations.edit', $mitra->id) }}" class="btn btn-sm btn-info btn-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cooperations.destroy', $mitra->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus mitra ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-circle"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data mitra.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection