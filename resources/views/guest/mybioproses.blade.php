<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBioproses — Login CIS Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --forest: #1A4D2E;
            --forest-mid: #2E7D52;
            --accent: #4CAF7C;
            --cream: #F0F7F2;
            --white: #FFFFFF;
            --ink: #0D2A1A;
            --muted: #6B8F7A;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'DM Sans', sans-serif; }
        body { background: var(--cream); display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .auth-container { background: var(--white); width: 100%; max-width: 400px; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(26,77,46,0.08); border: 1px solid rgba(46,125,82,0.1); }
        .auth-logo { text-align: center; margin-bottom: 2rem; }
        .auth-logo h1 { font-size: 1.5rem; color: var(--forest); font-weight: 700; letter-spacing: -0.02em; }
        .auth-logo p { font-size: 0.85rem; color: var(--muted); margin-top: 0.2rem; }
        
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--ink); margin-bottom: 0.4rem; }
        .form-group input { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; border: 1px solid #DFF0E7; background: #FAFFF8; border-radius: 6px; outline: none; transition: border-color 0.2s; }
        .form-group input:focus { border-color: var(--accent); }
        
        .auth-btn { width: 100%; padding: 0.8rem; background: var(--forest); color: var(--white); border: none; border-radius: 6px; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; }
        .auth-btn:hover { background: var(--forest-mid); }
        
        .alert-error { background: #FDF2F2; color: #EC5B5B; padding: 0.75rem; border-radius: 6px; font-size: 0.82rem; margin-bottom: 1.5rem; list-style: none; }
        .cis-info { margin-top: 1.5rem; text-align: center; font-size: 0.75rem; color: var(--muted); line-height: 1.4; }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-logo">
        <h1>MyBioproses</h1>
        <p>Institut Teknologi Del</p>
    </div>

    {{-- Pesan Error --}}
    @if ($errors->any() || session('error'))
        <div class="alert-error">
            {{ $errors->first() ?: session('error') }}
        </div>
    @endif

    {{-- FORM LOGIN CIS --}}
    <form action="{{ route('mybioproses.login.submit') }}" method="POST">
        @csrf
            <div class="form-group">
                <label for="username">Nomor Induk Mahasiswa (NIM)</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                    required autofocus placeholder="Contoh: 11421001">
            </div>
        <div class="form-group">
            <label for="password">Kata Sandi CIS</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="auth-btn">MASUK DENGAN CIS</button>
    </form>

    <div class="cis-info">
        Gunakan akun <b>Central Integrated System (CIS)</b> Anda untuk masuk. <br>
        Sistem ini tidak menyimpan kata sandi Anda.
    </div>
</div>

</body>
</html>