@extends('layouts.guest_layout')

@section('title', 'Pencarian: ' . $query)

@section('content')
<div class="container py-5" style="min-height: 60vh;">
    {{-- Header Hasil Pencarian --}}
    <div class="mb-5">
        <h6 class="text-uppercase fw-bold text-success" style="letter-spacing: 1px;">Hasil Pencarian</h6>
        <h2 class="display-6 fw-bold">Menampilkan hasil untuk: <span class="text-secondary italic">"{{ $query }}"</span></h2>
        <div style="width: 50px; height: 3px; background: #1A4D2E;" class="mt-2"></div>
    </div>

    @if(count($results) > 0)
        @foreach($results as $kategori => $items)
            <div class="mb-5">
                <h4 class="mb-3 d-flex align-items-center">
                    <span class="badge bg-success me-2" style="background-color: #1A4D2E !important;">{{ count($items) }}</span> 
                    {{ $kategori }}
                </h4>
                <div class="row g-3">
                    @foreach($items as $item)
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm p-3">
                                <div class="card-body p-0">
                                    <h5 class="card-title mb-1">
                                        {{-- Link Dinamis berdasarkan kategori --}}
                                        @php
                                            $link = '#';
                                            if($kategori == 'Berita') $link = route('public.news.show', $item->id);
                                            elseif($kategori == 'Dosen / Staff') $link = url('/staff-detail/'.$item->id);
                                            elseif($kategori == 'Mitra') $link = route('public.mitra.show', $item->id);
                                            elseif($kategori == 'Dokumen') $link = asset('storage/'.$item->file_path);
                                        @endphp
                                        
                                        <a href="{{ $link }}" class="text-decoration-none text-dark hover-success" style="transition: 0.3s;">
                                            {{ $item->title ?? $item->name }}
                                        </a>
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        <p>{{ strip_tags($item->description ?? $item->content ?? '') }}</p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        {{-- Jika Tidak Ada Hasil --}}
        <div class="text-center py-5 shadow-sm rounded-4 bg-light">
            <i class="bi bi-search display-1 text-muted opacity-25"></i>
            <h4 class="mt-3 text-muted">Maaf, kami tidak dapat menemukan apa pun.</h4>
            <p class="text-muted">Coba gunakan kata kunci lain yang lebih umum.</p>
            <a href="/" class="btn btn-success px-4 mt-2" style="background-color: #1A4D2E;">Kembali ke Beranda</a>
        </div>
    @endif
</div>

<style>
    .hover-success:hover { color: #1A4D2E !important; }
    .card { transition: transform 0.2s; border-left: 4px solid #1A4D2E !important; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endsection