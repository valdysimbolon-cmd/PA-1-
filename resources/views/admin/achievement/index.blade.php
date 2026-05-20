@extends('layouts.admin')

@section('title', 'Daftar Prestasi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Prestasi</h1>
        <a href="{{ route('achievements.create') }}" class="btn btn-sm shadow-sm" style="background-color: #C5E384; color: #200F07; font-weight: bold;">
            <i class="fas fa-plus fa-sm"></i> Tambah Prestasi Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Database Hall of Fame Bioproses</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Visual</th>
                            <th>Judul Prestasi</th>
                            <th>Pemenang</th>
                            <th>Level</th>
                            <th>Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achievements as $a)
                        <tr>
                            <td>
                                @if($a->image)
                                    <img src="{{ asset('storage/'.$a->image) }}" width="60" class="rounded shadow-sm">
                                @else
                                    <div class="bg-light rounded text-center small py-2" style="width:60px">No Pic</div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ Str::limit($a->title, 50) }}</strong><br>
                                <span class="badge badge-warning text-dark">{{ $a->rank ?? 'Peserta/Finalis' }}</span>
                            </td>
                            <td>{{ $a->winner_name }}</td>
                            <td><span class="badge badge-light border">{{ $a->level }}</span></td>
                            <td>{{ $a->year }}</td>
                            <td>
                                <a href="{{ route('achievements.edit', $a->id) }}" class="btn btn-sm btn-info btn-circle shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('achievements.destroy', $a->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data prestasi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-circle shadow-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data prestasi yang dicatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection