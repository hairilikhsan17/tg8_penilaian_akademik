<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Saya - Portal Mahasiswa</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/mahasiswas.css">
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .rotate-180 {
            transform: rotate(180deg);
        }
        
        /* Sidebar Toggle dengan Checkbox */
        #sidebarToggleCheckbox {
            display: none;
        }
        
        #sidebarToggleCheckbox:checked ~ nav ~ aside#sidebar {
            transform: translateX(0) !important;
        }
        
        #sidebarToggleCheckbox:checked ~ nav ~ label#sidebarOverlay {
            display: block !important;
        }
        
        /* User Dropdown dengan CSS */
        #userDropdown {
            position: relative;
        }
        
        #dropdownMenu {
            display: none;
        }
        
        #userDropdown:hover #dropdownMenu {
            display: block;
        }
        
        /* Edit/View Mode Toggle - akan dikontrol oleh JavaScript */
        #viewMode {
            display: block;
        }
        
        #editMode {
            display: none;
        }
        
        #editBtn {
            display: flex;
        }
        
        #cancelEditBtn {
            display: none;
        }
        
        /* Mobile sidebar */
        @media (max-width: 1023px) {
            #sidebar {
                transform: translateX(-100%);
            }
            
            #sidebarOverlay {
                display: none;
            }
        }
        
        @media (min-width: 1024px) {
            #sidebarToggle {
                display: none;
            }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen" id="bodyElement">
    <input type="checkbox" id="sidebarToggleCheckbox" class="hidden">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Left side: Logo & Menu Toggle -->
                <div class="flex items-center space-x-4">
                    <label for="sidebarToggleCheckbox" id="sidebarToggle" class="text-gray-600 hover:text-gray-900 focus:outline-none lg:hidden cursor-pointer">
                        <i class="fas fa-bars text-xl"></i>
                    </label>
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-lg">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">Portal Mahasiswa</h1>
                            <p class="text-xs text-gray-500">Sistem Akademik</p>
                        </div>
                    </div>
                </div>

                <!-- Right side: User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bell text-xl"></i>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative" id="userDropdown">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($nama ?? $user->nama_user ?? 'M', 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-700">{{ $nama ?? $user->nama_user ?? 'Mahasiswa' }}</p>
                                <p class="text-xs text-gray-500">{{ $nim ?? $user->nim ?? '-' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 text-sm"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50 hidden">
                            <a href="/mahasiswa/profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil Saya
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="/logout" class="block w-full">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-blue-900 via-indigo-900 to-blue-800 text-white pt-20 z-40 sidebar-transition transform lg:translate-x-0 -translate-x-full overflow-y-auto">
        <div class="px-4 py-6 space-y-2">
            <!-- Dashboard -->
            <a href="/mahasiswa/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="dashboard">
                <i class="fas fa-home text-lg w-5"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Lihat Nilai Akademik -->
            <a href="/mahasiswa/nilai" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="nilai">
                <i class="fas fa-chart-line text-lg w-5"></i>
                <span class="font-medium">Nilai Akademik</span>
            </a>

            <!-- KHS / Transkrip -->
            <a href="/mahasiswa/khs" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="khs">
                <i class="fas fa-file-invoice text-lg w-5"></i>
                <span class="font-medium">KHS / Transkrip</span>
            </a>

            <hr class="my-4 border-blue-700">

            <!-- Profil Mahasiswa -->
            <a href="/mahasiswa/profil" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors menu-item bg-blue-600 hover:bg-blue-700" data-menu="profil">
                <i class="fas fa-user-circle text-lg w-5"></i>
                <span class="font-medium">Profil Saya</span>
            </a>

            <!-- Logout -->
            <form method="POST" action="/logout" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-600 transition-colors text-left">
                    <i class="fas fa-sign-out-alt text-lg w-5"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>

        <!-- Info Mahasiswa Card -->
        <div class="mx-4 my-6 bg-blue-800 bg-opacity-50 rounded-lg p-4 border border-blue-700">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                    {{ strtoupper(substr($nama ?? $user->nama_user ?? 'M', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-white truncate">{{ $nama ?? $user->nama_user ?? 'Mahasiswa' }}</p>
                    <p class="text-xs text-blue-300">{{ $nim ?? $user->nim ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-blue-300">Semester:</span>
                    <span class="text-white font-semibold">{{ $semester ?? $user->semester ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-blue-300">IPK:</span>
                    <span class="text-white font-semibold">{{ $ipk ?? '0.00' }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Sidebar -->
        <div class="px-4 py-4 border-t border-blue-700">
            <div class="text-xs text-blue-300 text-center">
                <p> 2025 SIAKAD</p>
                <p class="mt-1">Version 1.0</p>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <label for="sidebarToggleCheckbox" id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden cursor-pointer"></label>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div id="edit"></div>
        <div class="p-6">
            <!-- Page Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Profil Saya</h2>
                <p class="text-gray-600 text-sm mt-1">Lihat dan kelola informasi profil Anda</p>
            </div>

            <div class="space-y-6" id="mainContent">
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

                <!-- Profile Information Card -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Informasi Profil</h3>
                        <div class="flex items-center space-x-3">
                            <a href="/mahasiswa/profil" class="text-gray-600 hover:text-gray-700 text-sm font-medium flex items-center" id="cancelEditBtn" style="display: none;">
                                <i class="fas fa-times mr-1"></i> 
                                <span>Batal Edit</span>
                            </a>
                            <a href="#edit" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center" id="editBtn">
                                <i class="fas fa-edit mr-1"></i> 
                                <span>Edit Profil</span>
                            </a>
                        </div>
                    </div>
                    
                    <div id="viewMode">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Profile Avatar -->
                            <div class="md:col-span-2 flex items-center space-x-6 pb-6 border-b border-gray-200">
                                <div class="relative group">
                                    <div id="avatarWithFoto" style="display: none;">
                                        <img src="" 
                                             alt="Foto Profil" 
                                             class="w-24 h-24 rounded-full object-cover border-4 border-blue-500">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-full flex items-center justify-center transition-all duration-200 cursor-pointer">
                                            <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <label for="upload-foto-view" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full transition-colors" title="Ganti Foto">
                                                    <i class="fas fa-camera text-sm"></i>
                                                </label>
                                                <form action="/mahasiswa/profil/foto" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition-colors" title="Hapus Foto">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <label for="upload-foto-empty-view" class="cursor-pointer" id="avatarEmpty">
                                        <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold border-4 border-blue-500 relative group">
                                            <span id="avatarInitial">{{ strtoupper(substr($nama ?? $user->nama_user, 0, 1)) }}</span>
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-full flex items-center justify-center transition-all duration-200">
                                                <i class="fas fa-camera text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <!-- Form untuk upload foto (hidden) -->
                                    <form id="upload-form-view" action="/mahasiswa/profil" method="POST" enctype="multipart/form-data" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="nama" value="">
                                        <input type="hidden" name="nim" value="">
                                        <input type="hidden" name="email" value="">
                                        <input type="hidden" name="user_email" value="">
                                        <input type="hidden" name="semester" value="">
                                        <input type="hidden" name="jurusan" value="">
                                        <input type="file" id="upload-foto-view" name="foto_profil" accept="image/*" onchange="this.form.submit()">
                                    </form>
                                    <form id="upload-form-empty-view" action="/mahasiswa/profil" method="POST" enctype="multipart/form-data" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="nama" value="">
                                        <input type="hidden" name="nim" value="">
                                        <input type="hidden" name="email" value="">
                                        <input type="hidden" name="user_email" value="">
                                        <input type="hidden" name="semester" value="">
                                        <input type="hidden" name="jurusan" value="">
                                        <input type="file" id="upload-foto-empty-view" name="foto_profil" accept="image/*" onchange="this.form.submit()">
                                    </form>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-bold text-gray-800" id="viewNama">{{ $nama ?? $user->nama_user }}</h4>
                                    <p class="text-gray-500 mt-1">Mahasiswa</p>
                                    <p class="text-xs text-gray-400 mt-1" id="avatarInfo">
                                        <i class="fas fa-info-circle mr-1"></i> Klik avatar untuk upload foto profil
                                    </p>
                                </div>
                            </div>

                            <!-- NIM -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">NIM</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewNim">{{ $nim ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewNamaFull">{{ $nama ?? $user->nama_user }}</p>
                                </div>
                            </div>

                            <!-- Email Mahasiswa -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Email Mahasiswa</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewEmail">{{ $email ?? $user->username }}</p>
                                </div>
                            </div>

                            <!-- Email Login -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Email Login</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewUserEmail">{{ $user_email ?? $user->username }}</p>
                                </div>
                            </div>

                            <!-- Semester -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Semester Aktif</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewSemester">{{ $semester ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- Jurusan -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Jurusan</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewJurusan">{{ $jurusan ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="editMode" style="display: none;">
                        <form method="POST" action="/mahasiswa/profil" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-6">
                                <!-- Profile Avatar Upload -->
                                <div class="md:col-span-2 flex items-center space-x-6 pb-6 border-b border-gray-200">
                                    <div class="relative">
                                        <div id="preview-foto" class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold border-4 border-blue-500">
                                            <span id="previewInitial">{{ strtoupper(substr($nama ?? $user->nama_user, 0, 1)) }}</span>
                                        </div>
                                        <label for="foto_profil" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 cursor-pointer hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-camera text-sm"></i>
                                        </label>
                                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="hidden">
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-bold text-gray-800" id="editNama">{{ $nama ?? $user->nama_user }}</h4>
                                        <p class="text-gray-500 mt-1">Mahasiswa</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik ikon kamera untuk mengganti foto</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- NIM -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">NIM</label>
                                        <input type="text" 
                                               name="nim" 
                                               id="editNim"
                                               value="{{ old('nim', $nim ?? '') }}" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('nim')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Nama -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               name="nama" 
                                               id="editNamaInput"
                                               value="{{ old('nama', $nama ?? $user->nama_user) }}" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('nama')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email Mahasiswa -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Email Mahasiswa</label>
                                        <input type="email" 
                                               name="email" 
                                               id="editEmail"
                                               value="{{ old('email', $email ?? $user->username) }}" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email Login -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Email Login <span class="text-red-500">*</span></label>
                                        <input type="email" 
                                               name="user_email" 
                                               id="editUserEmail"
                                               value="{{ old('user_email', $user_email ?? $user->username) }}" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('user_email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Semester -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Semester Aktif</label>
                                        <select name="semester" 
                                                id="editSemester"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Pilih Semester</option>
                                            @for($i = 1; $i <= 14; $i++)
                                                <option value="{{ $i }}" {{ old('semester', $semester ?? '') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('semester')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Jurusan -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Jurusan</label>
                                        <input type="text" 
                                               name="jurusan" 
                                               id="editJurusan"
                                               value="{{ old('jurusan', $jurusan ?? '') }}" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('jurusan')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                        <input type="password" 
                                               name="password" 
                                               id="editPassword"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Konfirmasi Password Baru</label>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="editPasswordConfirmation"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('password_confirmation')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                                    <button type="button" 
                                            onclick="toggleEditMode()"
                                            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                        <i class="fas fa-times mr-2"></i> Batal
                                    </button>
                                    <button type="submit" 
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm mb-1">Total Mata Kuliah</p>
                                <p class="text-3xl font-bold" id="statTotalMatakuliah">0</p>
                            </div>
                            <i class="fas fa-book text-4xl text-blue-200"></i>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm mb-1">IPK</p>
                                <p class="text-3xl font-bold" id="statIPK">0.00</p>
                            </div>
                            <i class="fas fa-chart-line text-4xl text-green-200"></i>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm mb-1">Semester Aktif</p>
                                <p class="text-3xl font-bold" id="statSemester">-</p>
                            </div>
                            <i class="fas fa-calendar text-4xl text-purple-200"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Toggle Edit/View Mode dengan JavaScript
        function toggleEditMode() {
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            const editBtn = document.getElementById('editBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            
            if (viewMode && editMode && editBtn && cancelEditBtn) {
                // Toggle display
                if (viewMode.style.display === 'none') {
                    // Show view mode
                    viewMode.style.display = 'block';
                    editMode.style.display = 'none';
                    editBtn.style.display = 'flex';
                    cancelEditBtn.style.display = 'none';
                } else {
                    // Show edit mode
                    viewMode.style.display = 'none';
                    editMode.style.display = 'block';
                    editBtn.style.display = 'none';
                    cancelEditBtn.style.display = 'flex';
                }
            }
        }

        // Handle edit button click
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            
            if (editBtn) {
                editBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleEditMode();
                    // Scroll to top of form
                    document.getElementById('editMode').scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }
            
            if (cancelEditBtn) {
                cancelEditBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleEditMode();
                });
            }

            // Handle hash change (for browser back button)
            window.addEventListener('hashchange', function() {
                if (window.location.hash === '#edit') {
                    toggleEditMode();
                } else {
                    const viewMode = document.getElementById('viewMode');
                    const editMode = document.getElementById('editMode');
                    const editBtn = document.getElementById('editBtn');
                    const cancelEditBtn = document.getElementById('cancelEditBtn');
                    
                    if (viewMode && editMode) {
                        viewMode.style.display = 'block';
                        editMode.style.display = 'none';
                        if (editBtn) editBtn.style.display = 'flex';
                        if (cancelEditBtn) cancelEditBtn.style.display = 'none';
                    }
                }
            });

            // Check if hash is #edit on page load
            if (window.location.hash === '#edit') {
                toggleEditMode();
            }
        });

        // Preview image when file is selected
        document.addEventListener('DOMContentLoaded', function() {
            const fotoInput = document.getElementById('foto_profil');
            if (fotoInput) {
                fotoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.getElementById('preview-foto');
                            if (preview) {
                                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-24 h-24 rounded-full object-cover border-4 border-blue-500">`;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>

</body>
</html>
