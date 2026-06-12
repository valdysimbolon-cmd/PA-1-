<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator | Teknik Bioproses IT Del</title>
    
    <!-- Bootstrap 5 + Font Awesome + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest-deep: #0D2A1A;
            --forest-main: #1A4D2E;
            --pistachio: #C5E384;
            --soft-white: #F8FAFC;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 1050px;
            border: none;
        }

        /* --- Sisi Kiri: Branding --- */
        .brand-panel {
            background: linear-gradient(145deg, var(--forest-main) 0%, var(--forest-deep) 100%);
            padding: 60px;
            color: white;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        /* Dekorasi Lingkaran Halus */
        .brand-panel::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(197, 227, 132, 0.05);
            border-radius: 50%;
        }

        .brand-panel i.main-icon {
            font-size: 3.5rem;
            color: var(--pistachio);
            margin-bottom: 25px;
        }

        .brand-panel h2 {
            font-weight: 800;
            font-size: 2.2rem;
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .brand-panel p {
            opacity: 0.7;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        /* Kotak Logo Agar Terang & Jelas */
        .logo-box {
            background: white;
            padding: 20px;
            border-radius: 16px;
            display: inline-flex;
            gap: 25px;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .logo-box img {
            height: 45px;
            width: auto;
            object-fit: contain;
        }

        /* --- Sisi Kanan: Form --- */
        .form-panel {
            padding: 70px 60px;
            background: white;
        }

        .access-label {
            display: inline-block;
            background: #E8F5E9;
            color: var(--forest-main);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 25px;
        }

        .form-panel h3 {
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .form-panel p.sub-text {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 35px;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }

        .form-control {
            border: 2px solid #f1f5f9;
            background: #f8fafc;
            border-radius: 12px;
            padding: 14px 16px 14px 45px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: white;
            border-color: var(--forest-main);
            box-shadow: 0 0 0 4px rgba(26, 77, 46, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 5;
        }

        .toggle-pass {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            z-index: 5;
        }

        .btn-login {
            background-color: var(--forest-main);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            background-color: #24663d;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 77, 46, 0.2);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .back-link:hover { color: var(--forest-main); }

        /* Responsif */
        @media (max-width: 991px) {
            .brand-panel { display: none; }
            .form-panel { padding: 45px 30px; }
            .login-card { max-width: 450px; }
        }
    </style>
</head>
<body>

<div class="login-card container-fluid p-0">
    <div class="row g-0">
        <!-- Kolom Kiri: Branding -->
        <div class="col-lg-6">
            <div class="brand-panel">
                <i class="fas fa-flask-vial main-icon"></i>
                <h2>Admin Central<br>Teknik Bioproses</h2>
                <p>Kelola kurikulum, operasional laboratorium, dan publikasi program studi dalam satu dashboard terintegrasi.</p>
                
                <!-- Logo Institusi dalam kotak putih terang -->
                <div class="logo-box">
                    <img src="{{ asset('guest_assets/img/logo-del.png') }}" alt="Logo IT Del">
                    <img src="{{ asset('guest_assets/img/yayasan-del.png') }}" alt="Logo Yayasan Del">
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form -->
        <div class="col-lg-6">
            <div class="form-panel">
                <span class="access-label">Protected Access</span>
                <h3>Login Administrator</h3>
                <p class="sub-text">Silahkan masuk menggunakan akun resmi Anda.</p>

                @if(session('error'))
                    <div class="alert alert-danger border-0 small mb-4 py-2" style="background:#fff1f2; color:#e11d48">
                        <i class="fas fa-circle-exclamation me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="mb-1"><label class="form-label">Email Institusi</label></div>
                    <div class="input-group-custom">
                        <i class="far fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" 
                               placeholder="nama@del.ac.id" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-1"><label class="form-label">Kata Sandi</label></div>
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" 
                               placeholder="••••••••" required>
                        <i class="far fa-eye-slash toggle-pass" id="togglePassword"></i>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span>Masuk ke Dashboard</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <a href="/" class="back-link">
                    <i class="fas fa-long-arrow-left me-2"></i> Kembali ke Website Utama
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Password
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    // Loading Effect
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');

    loginForm.addEventListener('submit', function() {
        loginBtn.disabled = true;
        loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengotentikasi...';
    });
</script>

</body>
</html>