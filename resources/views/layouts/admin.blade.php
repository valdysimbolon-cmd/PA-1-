<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Teknik Bioproses</title>
    <link rel="icon" type="image/png" href="{{ asset('guest_assets/img/logo-del.png') }}">
    <!-- Font & Style Standar -->
    <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/klorofil.css') }}" rel="stylesheet">
    
    <!-- TAMBAHKAN INI (Untuk Laravel 12/Vite agar Echo aktif) -->
    @vite(['resources/js/app.js'])
    <!-- ------------------------------------------------------ -->
    
    <style>
        .bg-gradient-success {
            background-color: #200F07 !important;
            background-image: linear-gradient(180deg, #200F07 10%, #351a0d 100%) !important;
        }
        .text-pistachio { color: #C5E384 !important; }
        .text-espresso { color: #200F07 !important; }
        .sidebar-dark .nav-item.active .nav-link,
        .sidebar-dark .nav-item.active .nav-link i { color: #C5E384 !important; font-weight: bold; }
        .sidebar-dark .nav-item .nav-link:hover,
        .sidebar-dark .nav-item .nav-link:hover i { color: #C5E384 !important; }
        footer.sticky-footer { padding: 2rem 0; flex-shrink: 0; }
        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        @media (max-width: 576px) {
            .table td .btn-sm,
            .table th .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            .btn-sm {
                margin-bottom: 0.2rem;
            }
        }
    </style>
    
    @stack('styles')
</head>

<body id="page-top">
    <div id="wrapper">
        @include('admin.partials.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.partials.topbar')

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('admin.partials.footer')
        </div>
    </div>

    @include('admin.partials.scripts')

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // 1. Notifikasi Sukses (Melayang Profesional)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1200, 
                    timerProgressBar: true
                });
            @endif

            // 2. Notifikasi Error
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Tutup' 
                });
            @endif

            // 3. Konfirmasi Hapus Global
            document.addEventListener('click', function (e) {
                if (e.target.closest('.btn-delete-custom') || e.target.closest('.btn-konfirmasi-hapus')) {
                    e.preventDefault();
                    const button = e.target.closest('.btn-delete-custom') || e.target.closest('.btn-konfirmasi-hapus');
                    const form = button.closest('form');
                    
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>

    <!-- TAMBAHKAN SCRIPT INI DI SINI (Notifikasi Real-time) -->
    @auth
    <script type="module">
        window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
            .notification((notification) => {
                // Tampilkan SweetAlert yang BISA DIKLIK
                Swal.fire({
                    icon: 'info',
                    title: 'Peminjaman Baru!',
                    text: notification.message,
                    showCancelButton: true,
                    confirmButtonColor: '#200F07',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Cek Sekarang',
                    cancelButtonText: 'Nanti Saja',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ARAHKAN KE HALAMAN DETAIL
                        window.location.href = notification.url;
                    }
                });

                // Update angka di lonceng (agar tidak perlu refresh)
                let countElement = document.getElementById('notif-count');
                if (countElement) {
                    let currentCount = parseInt(countElement.innerText) || 0;
                    countElement.innerText = currentCount + 1;
                }
            });
    </script>
    @endauth
    <!-- ------------------------------------------------------ -->

    @stack('scripts')
</body>
</html>