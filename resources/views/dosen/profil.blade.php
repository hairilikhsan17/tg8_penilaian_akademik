<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Dosen - SPA Sistem Penilaian Akademik</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/mahasiswas.css">
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .rotate-180 {
            transform: rotate(180deg);
        }
        
        /* Edit/View Mode Toggle dengan CSS :target */
        .profile-content #viewMode {
            display: block;
        }
        .profile-content #editMode {
            display: none;
        }
        .profile-content #editBtn {
            display: inline-flex;
        }
        .profile-content #cancelEditBtn {
            display: none;
        }
        
        /* Anchor untuk target */
        #edit {
            position: absolute;
            visibility: hidden;
        }
        
        /* Ketika URL memiliki hash #edit, tampilkan edit mode dan sembunyikan view mode */
        #edit:target ~ .profile-content #viewMode {
            display: none;
        }
        #edit:target ~ .profile-content #editMode {
            display: block;
        }
        #edit:target ~ .profile-content .button-wrapper #editBtn {
            display: none;
        }
        #edit:target ~ .profile-content .button-wrapper #cancelEditBtn {
            display: inline-flex;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Left side: Logo & Menu Toggle -->
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggle" class="text-gray-600 hover:text-gray-900 focus:outline-none lg:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-lg">
                            <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">SPA Sistem Penilaian Akademik</h1>
                            <p class="text-xs text-gray-500">Dashboard Dosen</p>
                        </div>
                    </div>
                </div>

                <!-- Right side: User Menu -->
                <div class="flex items-center space-x-4">
                    <div class="relative" id="userDropdown">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($nama ?? $user->nama_user ?? 'D', 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-700">{{ $nama ?? $user->nama_user ?? 'Dosen' }}</p>
                                <p class="text-xs text-gray-500">{{ $nip ?? $user->nip ?? '-' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 text-sm"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50 hidden">
                            <a href="/dosen/profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil Saya
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="/logout" class="block w-full">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-black text-white pt-20 z-40 sidebar-transition transform lg:translate-x-0 -translate-x-full overflow-y-auto">
        <div class="px-4 py-6 space-y-2">
            <a href="/dosen/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="dashboard">
                <i class="fas fa-home text-lg w-5"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="/dosen/mahasiswas" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="mahasiswas">
                <i class="fas fa-user-graduate text-lg w-5"></i>
                <span class="font-medium">Kelola Data Mahasiswa</span>
            </a>
            <a href="/dosen/matakuliahs" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="matakuliahs">
                <i class="fas fa-book text-lg w-5"></i>
                <span class="font-medium">Kelola Mata Kuliah</span>
            </a>
            <a href="/dosen/komponen-penilaian" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="komponen-penilaian">
                <i class="fas fa-clipboard-check text-lg w-5"></i>
                <span class="font-medium">Komponen Penilaian</span>
            </a>
            <a href="/dosen/nilai-mahasiswa" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="nilai-mahasiswa">
                <i class="fas fa-pen-to-square text-lg w-5"></i>
                <span class="font-medium">Input Nilai</span>
            </a>
            <a href="/dosen/laporan-nilai" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="laporan-nilai">
                <i class="fas fa-file-alt text-lg w-5"></i>
                <span class="font-medium">Laporan Nilai</span>
            </a>
            <hr class="my-4 border-gray-700">
            <a href="/dosen/profil" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors menu-item bg-blue-600 hover:bg-blue-700" data-menu="profil">
                <i class="fas fa-user-circle text-lg w-5"></i>
                <span class="font-medium">Profil Saya</span>
            </a>
            <form method="POST" action="/logout" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-600 transition-colors text-left">
                    <i class="fas fa-sign-out-alt text-lg w-5"></i>
                    <span class="font-medium">Dosen Keluar</span>
                </button>
            </form>
        </div>

        <div class="mx-4 my-6 bg-gray-900 bg-opacity-50 rounded-lg p-4 border border-gray-700">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center text-white font-bold text-xl" style="aspect-ratio: 1/1; min-width: 4rem; min-height: 4rem;">
                    {{ strtoupper(substr($nama ?? $user->nama_user ?? 'D', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white whitespace-nowrap">{{ $nama ?? $user->nama_user ?? 'Dosen' }}</p>
                    <p class="text-xs text-gray-300 mt-1">{{ $nip ?? $user->nip ?? '-' }}</p>
                </div>
            </div>
            <div class="text-xs space-y-1">
                <div class="flex justify-between">
                    <span class="text-gray-300">Mata Kuliah:</span>
                    <span class="text-white font-semibold">{{ $totalMatakuliah ?? '0' }}</span>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 border-t border-gray-700">
            <div class="text-xs text-gray-400 text-center">
                <p> 2025 SIAKAD</p>
                <p class="mt-1">Version 1.0</p>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden lg:hidden"></div>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div class="p-6">
            <!-- Page Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Profil Saya</h2>
                <p class="text-gray-600 text-sm mt-1">Lihat dan kelola informasi profil dosen Anda</p>
            </div>

            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="/dosen/dashboard" class="hover:text-blue-600"><i class="fas fa-home"></i></a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li class="text-gray-700">Profil</li>
                </ol>
            </nav>

            <div class="space-y-6">
                <!-- Profile Information Card -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <!-- Anchor untuk target -->
                    <span id="edit"></span>
                    
                    <div class="profile-content">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Informasi Profil</h3>
                            <div class="button-wrapper">
                                <a href="#edit" id="editBtn" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center">
                                    <i class="fas fa-edit mr-1"></i> 
                                    <span>Edit Profil</span>
                                </a>
                                <a href="/dosen/profil" id="cancelEditBtn" class="text-gray-600 hover:text-gray-700 text-sm font-medium flex items-center">
                                    <i class="fas fa-times mr-1"></i> 
                                    <span>Batal Edit</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- View Mode -->
                        <div id="viewMode">
                        <!-- Profile Avatar -->
                        <div class="flex items-center space-x-6 pb-6 border-b border-gray-200 mb-6">
                            <div class="relative group">
                                <label for="upload-foto-empty-view" class="cursor-pointer">
                                    <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold border-4 border-blue-500 relative group">
                                        A
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-full flex items-center justify-center transition-all duration-200">
                                            <i class="fas fa-camera text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                        </div>
                                    </div>
                                </label>
                                
                                <!-- Form untuk upload foto (hidden) -->
                                <form id="upload-form-empty-view" method="POST" action="/dosen/profil" enctype="multipart/form-data" class="hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="nama" value="Amirawati">
                                    <input type="hidden" name="nip" value="NIP-1234567">
                                    <input type="hidden" name="email" value="mira@gmail.com">
                                    <input type="hidden" name="user_email" value="mira@gmail.com">
                                    <input type="file" id="upload-foto-empty-view" name="foto_profil" accept="image/*" onchange="this.form.submit()">
                                </form>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800">{{ $nama ?? $user->nama_user }}</h4>
                                <p class="text-gray-500 mt-1">Dosen</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i> Klik avatar untuk upload foto profil
                                </p>
                            </div>
                        </div>

                        <!-- Form Fields in 2 Columns -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom Kiri -->
                            <div class="space-y-6">
                                <!-- NIP -->
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-600">NIP</label>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-gray-800">{{ $nip ?? '-' }}</p>
                                    </div>
                                </div>

                                <!-- Email Dosen -->
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-600">Email Dosen</label>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-gray-800">{{ $email ?? $user->username }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="space-y-6">
                                <!-- Nama -->
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-gray-800">{{ $nama ?? $user->nama_user }}</p>
                                    </div>
                                </div>

                                <!-- Email Login -->
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-600">Email Login</label>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-gray-800">{{ $user_email ?? $user->username }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Edit Mode -->
                    <form method="POST" action="/dosen/profil" enctype="multipart/form-data" id="editMode">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Profile Avatar Upload -->
                            <div class="md:col-span-2 flex items-center space-x-6 pb-6 border-b border-gray-200">
                                <div class="relative">
                                    <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold border-4 border-blue-500">
                                        {{ strtoupper(substr($nama ?? $user->nama_user, 0, 1)) }}
                                    </div>
                                    <label for="foto_profil" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 cursor-pointer hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-camera text-sm"></i>
                                    </label>
                                    <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="hidden">
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800">{{ $nama ?? $user->nama_user }}</h4>
                                    <p class="text-gray-500 mt-1">Dosen</p>
                                    <p class="text-xs text-gray-400 mt-1">Klik ikon kamera untuk mengganti foto</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Kolom Kiri -->
                                <div class="space-y-6">
                                    <!-- NIP -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">NIP</label>
                                        <input type="text" 
                                               name="nip" 
                                               value="{{ old('nip', $nip ?? '') }}" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <!-- Email Dosen -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Email Dosen</label>
                                        <input type="email" 
                                               name="email" 
                                               value="{{ old('email', $email ?? $user->username) }}" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <!-- Password -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Password Baru (opsional)</label>
                                        <input type="password" 
                                               name="password" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Kosongkan jika tidak ingin mengubah">
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="space-y-6">
                                    <!-- Nama -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               name="nama" 
                                               value="{{ old('nama', $nama ?? $user->nama_user) }}" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('nama')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email Login -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Email Login <span class="text-red-500">*</span></label>
                                        <input type="email" 
                                               name="user_email" 
                                               value="{{ old('user_email', $user_email ?? $user->username) }}" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('user_email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Konfirmasi Password</label>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Konfirmasi password baru">
                                    </div>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <a href="/dosen/profil" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    Batal
                                </a>
                                <button type="submit" 
                                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>

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
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <div>
                                <p class="font-semibold">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Statistics Card -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Total Mata Kuliah</p>
                                <p class="text-2xl font-bold text-gray-800">3</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-book text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Total Mahasiswa</p>
                                <p class="text-2xl font-bold text-gray-800">25</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Status Akun</p>
                                <p class="text-lg font-bold text-green-600">Aktif</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script -->
    
</body>
</html>
