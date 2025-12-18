<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penilaian Akademik</title>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .login-header p {
            color: #6b7280;
            font-size: 0.95rem;
        }
        .alert {
            padding: 0.875rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            background-color: white;
            cursor: pointer;
            transition: all 0.2s;
            outline: none;
        }
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .border-red-500 {
            border-color: #ef4444 !important;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }
        /* Style untuk text error yang muncul langsung setelah input */
        .form-group .form-input + *,
        .form-group .form-select + * {
            color: #ef4444 !important;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }
        .form-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 1.25rem;
        }
        .form-checkbox input {
            width: 1.125rem;
            height: 1.125rem;
            margin-right: 0.5rem;
            cursor: pointer;
        }
        .form-checkbox label {
            color: #374151;
            font-size: 0.9rem;
            cursor: pointer;
        }
        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1rem;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-submit:active {
            transform: translateY(0);
        }
        .register-link {
            text-align: center;
            margin-top: 1rem;
            color: #6b7280;
            font-size: 0.9rem;
        }
        .register-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .register-link a:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>Selamat Datang</h1>
            <p>Masuk ke akun Anda</p>
        </div>

        @if(session('success'))
            <div class="alert" style="background-color: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; padding: 0.875rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 0.875rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input id="username" name="username" type="text" 
                       class="form-input @error('username') border-red-500 @enderror" 
                       placeholder="Masukkan username"
                       value="{{ old('username') }}">
                @error('username')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password" 
                       class="form-input @error('password') border-red-500 @enderror" 
                       placeholder="Masukkan password">
                @error('password')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-checkbox">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-submit">
                Masuk
            </button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="/register">Daftar di sini</a>
        </div>
    </div>

</body>
</html>
