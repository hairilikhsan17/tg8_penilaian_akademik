<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penilaian Akademik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 40%, #24243e 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated background blobs */
        body::before {
            content: '';
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            top: -150px;
            left: -100px;
            border-radius: 50%;
            animation: blobMove1 8s ease-in-out infinite alternate;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.2) 0%, transparent 70%);
            bottom: -200px;
            right: -150px;
            border-radius: 50%;
            animation: blobMove2 10s ease-in-out infinite alternate;
            pointer-events: none;
        }

        @keyframes blobMove1 {
            0%   { transform: translate(0, 0) scale(1); }
            100% { transform: translate(60px, 80px) scale(1.15); }
        }

        @keyframes blobMove2 {
            0%   { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-50px, -70px) scale(1.1); }
        }

        /* Extra floating orb */
        .orb {
            position: fixed;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(34, 211, 238, 0.12) 0%, transparent 70%);
            top: 50%;
            left: 60%;
            border-radius: 50%;
            animation: blobMove1 12s ease-in-out infinite alternate;
            pointer-events: none;
        }

        /* Floating particles */
        .particles {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0%   { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.5; }
            100% { transform: translateY(-100px) rotate(720deg); opacity: 0; }
        }

        /* Wrapper layout */
        .login-wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            width: 900px;
            max-width: 95vw;
            min-height: 560px;
            border-radius: 28px;
            overflow: hidden;
            box-shadow:
                0 30px 80px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.07);
            animation: slideUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            flex: 1;
            background: linear-gradient(160deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            top: -80px; right: -80px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 250px; height: 250px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            bottom: -60px; left: -60px;
        }

        .logo-container {
            position: relative;
            z-index: 2;
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-ring {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow:
                0 0 30px rgba(255,255,255,0.15),
                inset 0 0 30px rgba(255,255,255,0.05);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 30px rgba(255,255,255,0.15), inset 0 0 30px rgba(255,255,255,0.05); }
            50%       { box-shadow: 0 0 50px rgba(255,255,255,0.25), inset 0 0 40px rgba(255,255,255,0.08); }
        }

        .logo-ring i {
            font-size: 3.5rem;
            color: #fff;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));
        }

        .left-title {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            line-height: 1.35;
            text-shadow: 0 2px 8px rgba(0,0,0,0.2);
            position: relative;
            z-index: 2;
        }

        .left-title span {
            display: block;
            font-size: 0.85rem;
            font-weight: 400;
            color: rgba(255,255,255,0.75);
            margin-top: 0.4rem;
            letter-spacing: 0.5px;
        }

        .left-divider {
            width: 50px;
            height: 3px;
            background: rgba(255,255,255,0.5);
            border-radius: 99px;
            margin: 1.25rem auto;
            position: relative;
            z-index: 2;
        }

        .left-tagline {
            color: rgba(255,255,255,0.65);
            font-size: 0.8rem;
            text-align: center;
            line-height: 1.7;
            position: relative;
            z-index: 2;
            max-width: 260px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 1.1;
            background: rgba(15, 12, 41, 0.85);
            backdrop-filter: blur(20px);
            padding: 3rem 2.75rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 0.35rem;
        }

        .form-subtitle {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.45);
            margin-bottom: 2rem;
        }

        /* Alert */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* Form groups */
        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 0.95rem;
            transition: color 0.2s;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.75rem;
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            color: #f1f5f9;
            transition: all 0.25s;
            outline: none;
        }

        .form-input::placeholder {
            color: rgba(255,255,255,0.25);
        }

        .form-input:focus {
            border-color: #818cf8;
            background: rgba(99, 102, 241, 0.12);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .form-input:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: #818cf8;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 0.95rem;
            transition: color 0.2s;
            pointer-events: none;
        }

        /* Make icon react to focus via sibling trick — override with focus-within on wrapper */
        .input-wrapper:focus-within .input-icon {
            color: #818cf8;
        }

        .form-input.is-error {
            border-color: #f87171;
            background: rgba(239, 68, 68, 0.08);
        }

        .error-message {
            color: #f87171;
            font-size: 0.78rem;
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Password toggle */
        .toggle-password {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,0.3);
            font-size: 0.9rem;
            transition: color 0.2s;
            padding: 0.2rem;
        }

        .toggle-password:hover { color: #818cf8; }

        /* Remember me */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .remember-row input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 4px;
            background: rgba(255,255,255,0.05);
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .remember-row input[type="checkbox"]:checked {
            background: #6366f1;
            border-color: #6366f1;
        }

        .remember-row input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 5px; height: 9px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }

        .remember-row label {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.5);
            cursor: pointer;
            user-select: none;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.35);
            margin-bottom: 1.25rem;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(99, 102, 241, 0.5);
        }

        .btn-submit:hover::before { left: 100%; }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-submit i {
            margin-right: 0.4rem;
        }

        /* Register link */
        .register-link {
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.4);
        }

        .register-link a {
            color: #818cf8;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-link a:hover { color: #a5b4fc; }

        /* ── RESPONSIVE ── */
        @media (max-width: 700px) {
            .login-wrapper {
                flex-direction: column;
                min-height: auto;
            }

            .left-panel {
                padding: 2rem 1.5rem 1.5rem;
            }

            .logo-ring {
                width: 100px;
                height: 100px;
            }

            .logo-ring img {
                width: 75px;
                height: 75px;
            }

            .left-title { font-size: 1.15rem; }

            .left-tagline { display: none; }

            .right-panel {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    {{-- Background decoration --}}
    <div class="orb"></div>
    <div class="particles" id="particles"></div>

    <div class="login-wrapper">

        {{-- ── LEFT PANEL ── --}}
        <div class="left-panel">
            <div class="logo-container">
                <div class="logo-ring">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="left-title">
                    Sistem Penilaian Akademik
                    <span>Perguruan Tinggi</span>
                </div>
                <div class="left-divider"></div>
                <p class="left-tagline">Platform digital pengelolaan nilai akademik mahasiswa yang terintegrasi</p>
            </div>
        </div>

        {{-- ── RIGHT PANEL ── --}}
        <div class="right-panel">
            <h2 class="form-title">Selamat Datang 👋</h2>
            <p class="form-subtitle">Masuk untuk mengakses akun Anda</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input id="username" name="username" type="text"
                               class="form-input @error('username') is-error @enderror"
                               placeholder="Masukkan username"
                               value="{{ old('username') }}"
                               autocomplete="username">
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    @error('username')
                        <div class="error-message"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input id="password" name="password" type="password"
                               class="form-input @error('password') is-error @enderror"
                               placeholder="Masukkan password"
                               autocomplete="current-password">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="toggle-password" onclick="togglePassword()" id="toggleBtn" aria-label="Tampilkan password">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-right-to-bracket"></i> Masuk
                </button>
            </form>

            <div class="register-link">
                Belum punya akun? <a href="/register">Daftar di sini</a>
            </div>
        </div>

    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const input   = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Generate floating particles
        (function generateParticles() {
            const container = document.getElementById('particles');
            const count = 18;
            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                p.classList.add('particle');
                const size    = Math.random() * 12 + 4;
                const left    = Math.random() * 100;
                const delay   = Math.random() * 15;
                const duration = Math.random() * 15 + 10;
                p.style.cssText = `
                    width: ${size}px;
                    height: ${size}px;
                    left: ${left}%;
                    bottom: -20px;
                    animation-delay: ${delay}s;
                    animation-duration: ${duration}s;
                `;
                container.appendChild(p);
            }
        })();
    </script>

</body>
</html>
