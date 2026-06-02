@extends('layouts.admin')

@section('title', 'Manajemen Profil')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Manajemen Profil</h1>
            <p class="text-muted small">Kelola konten sejarah, visi, misi, dan informasi prodi</p>
        </div>
        <a href="{{ route('profiles.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Profil Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #200F07;">
            <h6 class="m-0 font-weight-bold" style="color: #C5E384;">Daftar Konten Profil</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode (Key)</th>
                            <th>Judul Konten</th>
                            <th style="width: 100px">Status</th>
                            <th style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profiles as $profile)
                        <tr>
                            <td>
                                @if(Str::startsWith($profile->key, 'B_'))
                                    <span class="badge badge-warning">Beranda</span>
                                @elseif(Str::startsWith($profile->key, 'P_'))
                                    <span class="badge badge-info">Profil</span>
                                @else
                                    <span class="badge badge-secondary">Lainnya</span>
                                @endif
                                <code class="ml-2">{{ $profile->key }}</code>
                            </td>
                            <td>
                                <strong>{{ $profile->name }}</strong>
                                @if($profile->description)
                                    <br><small class="text-muted">{{ Str::limit(strip_tags($profile->description), 60) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($profile->active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus konten ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                                Belum ada konten profil. <a href="{{ route('profiles.create') }}">Tambah sekarang</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(method_exists($profiles, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $profiles->links() }}
        </div>
    @endif
</div>
@endsection