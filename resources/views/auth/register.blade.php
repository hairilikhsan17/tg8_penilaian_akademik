<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - Sistem Penilaian Akademik</title>
    
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .register-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .register-header p {
            color: #6b7280;
            font-size: 0.95rem;
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
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }
        /* Styling untuk error message */
        .form-group {
            position: relative;
        }
        /* Style untuk text error yang muncul langsung setelah input */
        .form-group .form-input + *,
        .form-group .form-select + * {
            color: #ef4444 !important;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
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
            margin-top: 0.5rem;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-submit:active {
            transform: translateY(0);
        }
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
            font-size: 0.9rem;
        }
        .login-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-link a:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-header">
            <h1 id="main-title">Registrasi Akun</h1>
            <p id="sub-title">Buat akun untuk mengakses sistem</p>
        </div>
        <form method="POST" action="/register" novalidate>
            @csrf
            
            <!-- Alert Success/Error -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 0.875rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input id="name" name="name" type="text" 
                       value="{{ old('name') }}" 
                       class="form-input @error('name') border-red-500 @enderror" 
                       placeholder="Masukkan nama lengkap"
                       required>
                @error('name')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                <input id="email" name="email" type="email" 
                       value="{{ old('email') }}" 
                       class="form-input @error('email') border-red-500 @enderror" 
                       placeholder="contoh@email.com"
                       required>
                @error('email')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Daftar Sebagai <span class="text-red-500">*</span></label>
                <select id="role" name="role" class="form-select @error('role') border-red-500 @enderror" required onchange="toggleRoleFields()">
                    <option value="">Pilih peran</option>
                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
                @error('role')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Field untuk Mahasiswa -->
            <div id="mahasiswa-fields" style="display: {{ old('role') === 'mahasiswa' ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="nim" class="form-label">NIM (Nomor Induk Mahasiswa) <span class="text-red-500">*</span></label>
                    <input id="nim" name="nim" type="text" 
                           value="{{ old('nim') }}" 
                           class="form-input @error('nim') border-red-500 @enderror" 
                           placeholder="Masukkan NIM"
                           required>
                    @error('nim')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="semester" class="form-label">Semester <span class="text-red-500">*</span></label>
                    <input id="semester" name="semester" type="number" min="1" max="14"
                           value="{{ old('semester') }}" 
                           class="form-input @error('semester') border-red-500 @enderror" 
                           placeholder="Masukkan semester (1-14)"
                           required>
                    @error('semester')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jurusan" class="form-label">Jurusan <span class="text-red-500">*</span></label>
                    <input id="jurusan" name="jurusan" type="text" 
                           value="{{ old('jurusan') }}" 
                           class="form-input @error('jurusan') border-red-500 @enderror" 
                           placeholder="Masukkan jurusan"
                           required>
                    @error('jurusan')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Field untuk Dosen -->
            <div id="dosen-fields" style="display: {{ old('role') === 'dosen' ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="nip" class="form-label">NIP (Nomor Induk Pegawai) <span class="text-red-500">*</span></label>
                    <input id="nip" name="nip" type="text" 
                           value="{{ old('nip') }}" 
                           class="form-input @error('nip') border-red-500 @enderror" 
                           placeholder="Masukkan NIP"
                           required>
                    @error('nip')
                        <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                <input id="password" name="password" type="password" 
                       class="form-input @error('password') border-red-500 @enderror" 
                       placeholder="Masukkan password"
                       required>
                @error('password')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input id="password_confirmation" name="password_confirmation" type="password" 
                       class="form-input @error('password_confirmation') border-red-500 @enderror" 
                       placeholder="Ulangi password"
                       required>
                @error('password_confirmation')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="/login">Masuk di sini</a>
        </div>
    </div>

    <script>
        function toggleRoleFields() {
            const role = document.getElementById('role').value;
            const mahasiswaFields = document.getElementById('mahasiswa-fields');
            const dosenFields = document.getElementById('dosen-fields');
            const mainTitle = document.getElementById('main-title');
            const subTitle = document.getElementById('sub-title');
            
            // Reset required attributes
            const mahasiswaInputs = mahasiswaFields.querySelectorAll('input');
            const dosenInputs = dosenFields.querySelectorAll('input');
            
            mahasiswaInputs.forEach(input => {
                input.removeAttribute('required');
            });
            dosenInputs.forEach(input => {
                input.removeAttribute('required');
            });
            
            if (role === 'mahasiswa') {
                mahasiswaFields.style.display = 'block';
                dosenFields.style.display = 'none';
                mahasiswaInputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
                if (mainTitle) mainTitle.textContent = 'Daftar Akun Mahasiswa';
                if (subTitle) subTitle.textContent = 'Buat akun mahasiswa untuk mengakses sistem';
            } else if (role === 'dosen') {
                mahasiswaFields.style.display = 'none';
                dosenFields.style.display = 'block';
                dosenInputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
                if (mainTitle) mainTitle.textContent = 'Daftar Akun Dosen';
                if (subTitle) subTitle.textContent = 'Buat akun dosen untuk mengakses sistem';
            } else {
                mahasiswaFields.style.display = 'none';
                dosenFields.style.display = 'none';
                if (mainTitle) mainTitle.textContent = 'Registrasi Akun';
                if (subTitle) subTitle.textContent = 'Buat akun untuk mengakses sistem';
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleRoleFields();
        });
    </script>

</body>
</html>
