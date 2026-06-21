<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peminjaman Laboratorium')</title>
</head>
<body>
    <header>
        <h2>Sistem Peminjaman Alat Laboratorium</h2>

        <nav>
            <a href="{{ route('laboratorium.pinjam') }}">Peminjaman</a>
        </nav>

        <hr>
    </header>

    <main>
        @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>