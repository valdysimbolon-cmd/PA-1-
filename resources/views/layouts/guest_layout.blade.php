<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teknik Bioproses IT Del')</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Di dalam <head> guest_layout.blade.php -->
    <link href="{{ asset('guest_assets/css/guest-style.css') }}" rel="stylesheet">


    <style>
        :root {
            --dark-forest: #1A4D2E;   /* Hijau Tua IT Del */
            --cream-light: #E6F5EC;   /* Latar Konten */
            --accent-green: #4CAF7C;  /* Tombol */
            --teal-accent: #1D9E75;   /* Ikon */
            --text-main: #2E7D52;
        }

        body { font-family: 'Inter', sans-serif; color: #333; background-color: #fdfdfd; }

        /* Navbar Styling */
        .navbar { background-color: #ffffff; padding: 1rem 0; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .navbar-brand .brand-title { color: var(--dark-forest); font-weight: 800; font-size: 1.2rem; line-height: 1; }
        .nav-link { color: #444 !important; font-weight: 600; font-size: 0.95rem; padding: 0.5rem 1rem !important; transition: 0.3s; }
        .nav-link:hover { color: var(--teal-accent) !important; }
        
        /* Dropdown Styling */
        .dropdown-menu { border: none; shadow: 0 10px 30px rgba(0,0,0,0.1); border-top: 3px solid var(--dark-forest); border-radius: 0 0 10px 10px; }
        .dropdown-item { padding: 0.7rem 1.5rem; font-weight: 500; color: #444; }
        .dropdown-item:hover { background-color: var(--cream-light); color: var(--dark-forest); }

        /* Button Login */
        .btn-login { background-color: var(--accent-green); color: white !important; font-weight: 700; border-radius: 50px; padding: 0.5rem 1.5rem !important; }
        .btn-login:hover { background-color: var(--dark-forest); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(26, 77, 46, 0.3); }

        footer { background-color: var(--dark-forest); color: var(--cream-light); }
    </style>
    @stack('styles')
</head>
<body>

    @include('layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

<footer class="py-5 mt-5" style="background-color: #008243; color: white;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">CONTACT US</h5>
                <p class="small mb-1">Institut Teknologi Del</p>
                <p class="small mb-1">Jl. Sisingamangaraja, Desa Sitoluama,</p>
                <p class="small mb-1">Kecamatan Laguboti, Kabupaten Toba</p>
                <p class="small mb-1">Provinsi Sumatera Utara, Indonesia</p>
                <p class="small mb-1">Kode Pos: 22381</p>
                <p class="small mb-1">Telp: +62 632 331234</p>
                <p class="small mb-1">Fax: +62 632 331116</p>
                <p class="small mb-1">Website: https://www.del.ac.id</p>
                <p class="small mb-0">Email: info@del.ac.id</p>
            </div>

            <div class="col-md-4">
                <h5 class="fw-bold mb-3">FIND US ON</h5>
                <ul class="list-unstyled">
<li class="mb-2">
    <a href="https://web.facebook.com/Institut.Teknologi.Del/" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none">
        <i class="bi bi-facebook me-2"></i> Facebook
    </a>
</li>
<li class="mb-2">
    <a href="https://twitter.com/institut_del" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none">
        <i class="bi bi-twitter me-2"></i> Twitter
    </a>
</li>
<li class="mb-2">
    <a href="https://www.youtube.com/@institutteknologidel1337" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none">
        <i class="bi bi-youtube me-2"></i> Youtube
    </a>

    <li class="mb-2">
    <a href="https://www.instagram.com/bp.itdel/" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none">
        <i class="bi bi-instagram me-2"></i> Instagram
    </a>
</li>

</li>
                </ul>
            </div>

            <div class="col-md-4">
                <h5 class="fw-bold mb-3">AKSES CEPAT</h5>
                <ul class="list-unstyled">
                    <li class="mb-1"><a href="/" class="text-warning text-decoration-none">Home</a></li>
                    <li class="mb-1"><a href="https://cis.del.ac.id/user/login" target="_blank" class="text-warning text-decoration-none">Campus Information System</a></li>
                    <li class="mb-1"><a href="https://ecourse.del.ac.id/login/index.php" target="_blank" class="text-warning text-decoration-none">E-Course Learning Management System</a></li>
                    <li class="mb-1"><a href="#" target="_blank" class="text-warning text-decoration-none">Online Library Information System</a></li>
                </ul>
                <div class="mt-3">
                    <form action="#" method="GET" class="d-flex">
                        <input type="text" class="form-control form-control-sm me-2" placeholder="Search">
                        <button class="btn btn-warning btn-sm fw-bold" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <hr class="mt-4 border-light">

        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="small mb-0">Copyright SDI-IT Del © {{ date('Y') }} Institut Teknologi Del. All Rights Reserved</p>
            </div>
            <div class="col-md-6 text-md-end">
                <img src="{{ asset('guest_assets/img/logo-del-footer.png') }}" alt="Logo Footer" style="height: 40px;">
            </div>
        </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('guest_assets/js/animations.js') }}"></script>
</body>
</html>