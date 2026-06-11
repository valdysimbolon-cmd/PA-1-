<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teknik Bioproses IT Del')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
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
        .dropdown-menu { border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-top: 3px solid var(--dark-forest); border-radius: 0 0 10px 10px; }
        .dropdown-item { padding: 0.7rem 1.5rem; font-weight: 500; color: #444; }
        .dropdown-item:hover { background-color: var(--cream-light); color: var(--dark-forest); }

        /* Button Login */
        .btn-login { background-color: var(--accent-green); color: white !important; font-weight: 700; border-radius: 50px; padding: 0.5rem 1.5rem !important; }
        .btn-login:hover { background-color: var(--dark-forest); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(26, 77, 46, 0.3); }
    </style>
    @stack('styles')
</head>
<body>

    @include('layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    {{-- Footer dipanggil dari file terpisah --}}
    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('guest_assets/js/animations.js') }}"></script>
</body>
</html>