@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Manajemen Hero Banner</h1>
            <p class="text-muted small">
                Desktop menggunakan Video, Mobile menggunakan Poster Image.
            </p>
        </div>

        <a href="{{ route('heroes.create') }}"
           class="btn btn-success">
            <i class="fas fa-plus"></i>
            Banner Baru
        </a>
    </div>

    <div class="card shadow">

        <div class="card-header py-3" style="background-color:#200F07;">
            <h6 class="m-0 fw-bold" style="color:#C5E384;">
                Daftar Hero Banner
            </h6>
        </div>

        <div class="card-body">

            <div class="row g-4">

                @forelse($heroes as $hero)

                    <div class="col-md-6 col-lg-4">

                        <div class="card h-100 border-0 shadow-sm">

                            <img src="{{ asset('storage/'.$hero->poster_image) }}"
                                 class="card-img-top"
                                 style="height:220px;object-fit:cover;"
                                 alt="{{ $hero->title }}">

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-start">

                                    <h5 class="card-title">
                                        {{ Str::limit($hero->title, 50) }}
                                    </h5>

                                    @if($hero->active)
                                        <span class="badge bg-success">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Nonaktif
                                        </span>
                                    @endif

                                </div>

                                <p class="small text-muted">
                                    {{ Str::limit($hero->subtitle, 80) }}
                                </p>

                                <div class="mt-2">

                                    @if($hero->video_url)
                                        <span class="badge bg-primary">
                                            Video Desktop
                                        </span>
                                    @endif

                                    @if($hero->button_text)
                                        <span class="badge bg-info">
                                            {{ $hero->button_text }}
                                        </span>
                                    @endif

                                </div>

                            </div>

                            <div class="card-footer bg-transparent border-0">

                                <div class="d-flex gap-2">

                                    <a href="{{ route('heroes.edit', $hero->id) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('heroes.destroy', $hero->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Hapus Hero Banner ini?')">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            Belum ada Hero Banner.
                        </div>
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>
@endsection