@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 font-weight-bold" style="color:var(--ink)">Dashboard Utama</h1>
</div>

{{-- Welcome Card --}}
<div class="row">
    <div class="col-xl-12 mb-4">
        <div class="card h-100 py-2" style="border-left: 4px solid var(--g200);">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1"
                             style="color:var(--ink3); letter-spacing:.07em; font-size:10px;">
                            Status Sistem
                        </div>
                        <div class="h5 mb-0 font-weight-bold" style="color:var(--ink)">
                            Selamat Datang,
                            <span style="color:var(--g600)">{{ Auth::user()->name }}</span>!
                        </div>
                        <small style="color:var(--ink3)">
                            Sistem Informasi Teknik Bioproses IT Del siap dikelola secara dinamis.
                        </small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-3x" style="color:var(--g200)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Info Row --}}
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Panduan Admin</h6>
            </div>
            <div class="card-body" style="color:var(--ink2); font-size:13.5px; line-height:1.7">
                Gunakan menu di sidebar kiri untuk mengelola konten website publik.
                Anda dapat menambah, mengubah, atau menyembunyikan data secara real-time.
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="row">
            <div class="col-6 mb-3">
                <div class="card py-3 px-3">
                    <div class="text-xs font-weight-bold text-uppercase mb-1"
                         style="color:var(--ink3);font-size:10px;letter-spacing:.06em">
                        Total Artikel
                    </div>
                    <div class="h4 mb-0 font-weight-bold" style="color:var(--ink)">248</div>
                    <small style="color:var(--ink3)">
                        <span style="display:inline-block;width:7px;height:7px;border-radius:50%;
                              background:var(--g200);margin-right:4px;"></span>Aktif
                    </small>
                </div>
            </div>
            <div class="col-6 mb-3">
                <div class="card py-3 px-3">
                    <div class="text-xs font-weight-bold text-uppercase mb-1"
                         style="color:var(--ink3);font-size:10px;letter-spacing:.06em">
                        Draft
                    </div>
                    <div class="h4 mb-0 font-weight-bold" style="color:var(--ink)">33</div>
                    <small style="color:var(--ink3)">
                        <span style="display:inline-block;width:7px;height:7px;border-radius:50%;
                              background:#EF9F27;margin-right:4px;"></span>Menunggu
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection