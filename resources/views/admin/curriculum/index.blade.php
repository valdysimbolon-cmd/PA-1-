@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kurikulum</h1>
        <a href="{{ route('curriculums.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">+ Tambah Kurikulum</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;"><h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Kurikulum</h6></div>
        <div class="card-body text-dark">
            <table class="table table-hover">
                <thead><tr><th>Nama Kurikulum</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($curriculums as $c)
                    <tr>
                        <td>{{ $c->name }}</td>
                        <td><span class="badge {{ $c->active ? 'badge-success' : 'badge-secondary' }}">{{ $c->active ? 'Aktif' : 'Non-Aktif' }}</span></td>
                        <td>
                            <a href="{{ route('curriculums.edit', $c->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('curriculums.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kurikulum ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection