<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Bioproses IT Del</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #F0F7F2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .lp-card {
            display: flex;
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(26,77,46,.08);
        }

        /* ── Sisi kiri hijau ── */
        .lp-side {
            width: 160px;
            flex-shrink: 0;
            background: #1A4D2E;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
            gap: 1.25rem;
        }
        .lp-side-dot  { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,.2); }
        .lp-side-line { width: 1px; height: 36px; background: rgba(255,255,255,.12); }
        .lp-side-icon { font-size: 26px; color: #4CAF7C; }
        .lp-side-brand { text-align: center; }
        .lp-side-brand strong { display: block; font-size: 13px; font-weight: 700; color: #fff; letter-spacing: .06em; text-transform: uppercase; }
        .lp-side-brand span   { display: block; font-size: 10px; font-weight: 500; color: rgba(255,255,255,.45); letter-spacing: .1em; text-transform: uppercase; line-height: 1.7; margin-top: 2px; }

        /* ── Area form ── */
        .lp-form-area {
            flex: 1;
            padding: 2.25rem 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .lp-title { font-size: 19px; font-weight: 600; color: #0D2A1A; margin-bottom: 4px; }
        .lp-sub   { font-size: 13px; color: #6B8F7A; margin-bottom: 1.75rem; }

        .lp-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #6B8F7A;
            margin-bottom: 6px;
        }

        .lp-field { position: relative; margin-bottom: 1.1rem; }
        .lp-field i {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%); font-size: 14px;
            color: #aaa; pointer-events: none;
        }
        .lp-field input {
            width: 100%; height: 42px;
            border: 1px solid #DFF0E7;
            border-radius: 8px;
            background: #FAFFF8;
            padding: 0 40px 0 36px;
            font-size: 14px; color: #0D2A1A;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .2s, background .2s;
        }
        .lp-field input:focus { border-color: #2E7D52; background: #fff; }
        .lp-field input::placeholder { color: #b0c4b8; }
        .lp-eye {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            font-size: 14px; color: #aaa; cursor: pointer;
        }

        .lp-btn {
            width: 100%; height: 44px;
            background: #1A4D2E; color: #fff;
            border: none; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer; margin-top: .5rem;
            letter-spacing: .02em;
            transition: background .2s, transform .15s;
        }
        .lp-btn:hover  { background: #2E7D52; transform: translateY(-1px); }
        .lp-btn:active { transform: scale(.99); }

        .lp-alert {
            font-size: 13px; color: #991b1b;
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 8px; padding: 10px 14px;
            margin-bottom: 1.1rem;
            display: flex; align-items: center; gap: 8px;
        }

        .lp-back {
            font-size: 12px; color: #6B8F7A;
            text-decoration: none; margin-top: 1.5rem;
            display: inline-flex; align-items: center; gap: 5px;
        }
        .lp-back:hover { color: #2E7D52; }

        @media (max-width: 480px) {
            .lp-side { display: none; }
            .lp-form-area { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="lp-card">

    {{-- Sisi kiri dekoratif --}}
    <div class="lp-side">
        <div class="lp-side-dot"></div>
        <div class="lp-side-line"></div>
        <i class="fas fa-flask lp-side-icon"></i>
        <div class="lp-side-brand">
            <strong>Bioproses</strong>
            <span>Institut<br>Teknologi Del</span>
        </div>
        <div class="lp-side-line"></div>
        <div class="lp-side-dot"></div>
    </div>

    {{-- Area form --}}
    <div class="lp-form-area">
        <p class="lp-title">Selamat datang</p>
        <p class="lp-sub">Masuk ke sistem Bioproses IT Del</p>

        {{-- Pesan error dari Laravel --}}
        @if($errors->any())
            <div class="lp-alert">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif
        @if(session('success'))
            <div class="lp-alert" style="color:#065f46;background:#ecfdf5;border-color:#a7f3d0;">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <label class="lp-label" for="email">USERNAME</label>
            <div class="lp-field">
                <i class="fas fa-user"></i>
                <input type="text" id="email" name="email"
                    placeholder="username"
                    value="{{ old('email') }}" required autofocus>
            </div>

            <label class="lp-label" for="password">Password</label>
            <div class="lp-field">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password"
                    placeholder="••••••••" required>
                <i class="fas fa-eye lp-eye" id="eyeToggle"></i>
            </div>

            <button type="submit" class="lp-btn">Masuk</button>
        </form>

        <a href="{{ route('home') }}" class="lp-back">
            <i class="fas fa-arrow-left"></i> Kembali ke beranda
        </a>
    </div>

</div>

<script>
    const eye  = document.getElementById('eyeToggle');
    const pass = document.getElementById('password');
    eye.addEventListener('click', function () {
        const show = pass.type === 'password';
        pass.type = show ? 'text' : 'password';
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>