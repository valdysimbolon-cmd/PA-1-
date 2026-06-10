<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBioproses — Autentikasi Portal</title>
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
        .auth-container { background: var(--white); width: 100%; max-width: 450px; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(26,77,46,0.08); border: 1px solid rgba(46,125,82,0.1); }
        .auth-logo { text-align: center; margin-bottom: 1.5rem; }
        .auth-logo h1 { font-size: 1.5rem; color: var(--forest); font-weight: 700; letter-spacing: -0.02em; }
        .auth-logo p { font-size: 0.85rem; color: var(--muted); margin-top: 0.2rem; }
        
        .auth-tabs { display: flex; border-bottom: 2px solid var(--cream); margin-bottom: 2rem; }
        .tab-btn { flex: 1; text-align: center; padding: 0.75rem; font-size: 0.9rem; font-weight: 600; color: var(--muted); cursor: pointer; border: none; background: none; transition: all 0.2s; }
        .tab-btn.active { color: var(--forest); border-bottom: 2px solid var(--forest); margin-bottom: -2px; }
        
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--ink); margin-bottom: 0.4rem; }
        .form-group input { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; border: 1px solid #DFF0E7; background: #FAFFF8; border-radius: 6px; outline: none; transition: border-color 0.2s; }
        .form-group input:focus { border-color: var(--accent); }
        
        .auth-btn { width: 100%; padding: 0.8rem; background: var(--forest); color: var(--white); border: none; border-radius: 6px; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; }
        .auth-btn:hover { background: var(--forest-mid); }
        
        .auth-form { display: none; }
        .auth-form.active { display: block; }
        
        .alert-error { background: #FDF2F2; color: #EC5B5B; padding: 0.75rem; border-radius: 6px; font-size: 0.82rem; margin-bottom: 1rem; list-style: none; }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-logo">
        <h1>MyBioproses</h1>
        <p>Institut Teknologi Del</p>
    </div>

    <div class="auth-tabs">
        <button class="tab-btn active" onclick="switchTab('login')">Masuk</button>
        <button class="tab-btn" onclick="switchTab('register')">Daftar</button>
    </div>

    {{-- Alert Error jika validasi gagal --}}
    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    {{-- FORM LOGIN --}}
    <form id="loginForm" class="auth-form active" action="{{ route('mybioproses.login.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="login_email">Alamat Email</label>
            <input type="email" id="login_email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@mahasiswa.del.ac.id">
        </div>
        <div class="form-group">
            <label for="login_password">Kata Sandi</label>
            <input type="password" id="login_password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="auth-btn">MASUK SEKARANG</button>
    </form>

    {{-- FORM REGISTER --}}
    <form id="registerForm" class="auth-form" action="{{ route('mybioproses.register.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="reg_name">Nama Lengkap</label>
            <input type="text" id="reg_name" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap Anda">
        </div>
        <div class="form-group">
            <label for="reg_email">Alamat Email</label>
            <input type="email" id="reg_email" name="email" value="{{ old('email') }}" required placeholder="nama@mahasiswa.del.ac.id">
        </div>
        <div class="form-group">
            <label for="reg_password">Kata Sandi Baru</label>
            <input type="password" id="reg_password" name="password" required placeholder="Minimal 6 karakter">
        </div>
        <div class="form-group">
            <label for="reg_password_confirmation">Konfirmasi Kata Sandi</label>
            <input type="password" id="reg_password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi">
        </div>
        <button type="submit" class="auth-btn">BUAT AKUN</button>
    </form>
</div>

<script>
    function switchTab(type) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.auth-form').forEach(form => form.classList.remove('active'));
        
        if(type === 'login') {
            document.querySelector('.tab-btn:nth-child(1)').classList.add('active');
            document.getElementById('loginForm').classList.add('active');
        } else {
            document.querySelector('.tab-btn:nth-child(2)').classList.add('active');
            document.getElementById('registerForm').classList.add('active');
        }
    }

    // Otomatis pindah ke tab daftar jika errornya berasal dari proses registrasi gais
    @if ($errors->any() && (old('name') || request()->is('*register*')))
        switchTab('register');
    @endif
</script>

</body>
</html>