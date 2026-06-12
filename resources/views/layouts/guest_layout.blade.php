<!-- resources/views/guest/layouts/master.blade.php -->
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
    <link href="{{ asset('guest_assets/css/guest-style.css') }}" rel="stylesheet">

    <style>
        /* Anda bisa memindahkan style CSS ini ke file guest-style.css agar lebih bersih lagi */
        :root {
            --dark-forest: #1A4D2E;
            --cream-light: #E6F5EC;
            --accent-green: #4CAF7C;
            --teal-accent: #1D9E75;
            --text-main: #2E7D52;
        }
        body { font-family: 'Inter', sans-serif; color: #333; background-color: #fdfdfd; }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Memanggil Navbar --}}
    @include('guest.partials.navbar')

    <main>
        @yield('content')
    </main>

    {{-- Memanggil Footer yang sudah dipisah --}}
    @include('guest.partials.footer')

    {{-- Memanggil Scripts yang sudah dipisah --}}
    @include('guest.partials.scripts')

</body>
</html>