<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bioproses IT DEL</title>
    
    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #E6FAF1; /* Hijau Mint Lembut */
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background-color: #FFFFFF;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 420px;
            padding: 40px 30px;
        }

        .login-title {
            font-family: 'Merriweather', serif; 
            color: #1a5928; /* Hijau Tua Khas Bioproses */
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: #888;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #555555;
            font-size: 14px;
        }

        .input-group-text {
            background-color: transparent;
            color: #888888;
            border-right: none;
        }

        .form-control {
            border-left: none;
            font-size: 14px;
            height: 45px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .btn-masuk {
            background-color: #2F5D8A; /* Biru Profesional */
            color: white;
            border: none;
            border-radius: 30px;
            height: 48px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-masuk:hover {
            background-color: #1e3d5a;
            transform: translateY(-2px);
        }

        .extra-links {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-top: 15px;
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
        }

        .back-link a {
            color: #1a5928;
            text-decoration: none;
        }

        #togglePassword { cursor: pointer; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center">
            <i class="fas fa-flask fa-2x mb-3" style="color: #1a5928;"></i>
            <h2 class="login-title">Bioproses IT DEL</h2>
            <p class="login-subtitle">Silakan login untuk masuk ke sistem</p>
        </div>

        <!-- Menampilkan Pesan Error Laravel -->
        @if(session('error'))
            <div class="alert alert-danger py-2 small text-center">
                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf <!-- WAJIB: Token Keamanan Laravel -->
            
            <!-- Input Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control" 
                        placeholder="nama@del.ac.id" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <!-- Input Password -->
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" 
                        placeholder="********" style="border-right: none;" required>
                    <span class="input-group-text" id="togglePassword" style="border-left: none;">
                        <i class="fa-regular fa-eye" id="eyeIcon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-masuk">
                Masuk ke Dashboard <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
            </button>

            <div class="extra-links">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>
                <a href="#" class="text-muted text-decoration-none">Lupa Password?</a>
            </div>
        </form>

        <div class="back-link">
            <a href="/"><i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda Utama</a>
        </div>
    </div>

    <!-- Script Mata Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>