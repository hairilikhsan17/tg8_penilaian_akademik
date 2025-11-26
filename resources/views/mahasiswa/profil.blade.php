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
        
        /* Edit/View Mode Toggle dengan :target */
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
        
        /* Ketika anchor #edit aktif, tampilkan edit mode */
        main:has(#edit:target) #mainContent #viewMode {
            display: none;
        }
        
        main:has(#edit:target) #mainContent #editMode {
            display: block;
        }
        
        main:has(#edit:target) #mainContent #editBtn {
            display: none;
        }
        
        main:has(#edit:target) #mainContent #cancelEditBtn {
            display: flex;
        }
        
        /* Fallback untuk browser yang tidak support :has() */
        @supports not selector(:has(*)) {
            #edit:target ~ div #mainContent #viewMode {
                display: none;
            }
            
            #edit:target ~ div #mainContent #editMode {
                display: block;
            }
            
            #edit:target ~ div #mainContent #editBtn {
                display: none;
            }
            
            #edit:target ~ div #mainContent #cancelEditBtn {
                display: flex;
            }
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
                                H
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-700">Hairil Ikhsan</p>
                                <p class="text-xs text-gray-500">221118</p>
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
                    H
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-white truncate">Hairil Ikhsan</p>
                    <p class="text-xs text-blue-300">221118</p>
                </div>
            </div>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-blue-300">Semester:</span>
                    <span class="text-white font-semibold">1</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-blue-300">IPK:</span>
                    <span class="text-white font-semibold">3.75</span>
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
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" style="display: none;" id="successAlert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <p id="successMessage"></p>
                    </div>
                </div>

                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" style="display: none;" id="errorAlert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <p id="errorMessage"></p>
                    </div>
                </div>

                <!-- Profile Information Card -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Informasi Profil</h3>
                        <a href="/mahasiswa/profil" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center" id="cancelEditBtn">
                            <i class="fas fa-times mr-1"></i> 
                            <span>Batal Edit</span>
                        </a>
                        <a href="#edit" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center" id="editBtn">
                            <i class="fas fa-edit mr-1"></i> 
                            <span>Edit Profil</span>
                        </a>
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
                                            <span id="avatarInitial">M</span>
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
                                    <h4 class="text-2xl font-bold text-gray-800" id="viewNama">Hairil Ikhsan</h4>
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
                                    <p class="text-gray-800" id="viewNim">-</p>
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewNamaFull">-</p>
                                </div>
                            </div>

                            <!-- Email Mahasiswa -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Email Mahasiswa</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewEmail">-</p>
                                </div>
                            </div>

                            <!-- Email Login -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Email Login</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewUserEmail">-</p>
                                </div>
                            </div>

                            <!-- Semester -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Semester Aktif</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewSemester">-</p>
                                </div>
                            </div>

                            <!-- Jurusan -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-600">Jurusan</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-800" id="viewJurusan">-</p>
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
                                            <span id="previewInitial">M</span>
                                        </div>
                                        <label for="foto_profil" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 cursor-pointer hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-camera text-sm"></i>
                                        </label>
                                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="hidden">
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-bold text-gray-800" id="editNama">Hairil Ikhsan</h4>
                                        <p class="text-gray-500 mt-1">Mahasiswa</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik ikon kamera untuk mengganti foto</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- NIM -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">NIM <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               name="nim" 
                                               id="editNim"
                                               value="" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-red-500 text-xs mt-1" id="errorNim" style="display: none;"></p>
                                    </div>

                                    <!-- Nama -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               name="nama" 
                                               id="editNamaInput"
                                               value="" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-red-500 text-xs mt-1" id="errorNama" style="display: none;"></p>
                                    </div>

                                    <!-- Email Mahasiswa -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Email Mahasiswa <span class="text-red-500">*</span></label>
                                        <input type="email" 
                                               name="email" 
                                               id="editEmail"
                                               value="" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-red-500 text-xs mt-1" id="errorEmail" style="display: none;"></p>
                                    </div>

                                    <!-- Email Login -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Email Login <span class="text-red-500">*</span></label>
                                        <input type="email" 
                                               name="user_email" 
                                               id="editUserEmail"
                                               value="" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-red-500 text-xs mt-1" id="errorUserEmail" style="display: none;"></p>
                                    </div>

                                    <!-- Semester -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Semester Aktif <span class="text-red-500">*</span></label>
                                        <select name="semester" 
                                                id="editSemester"
                                                required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="1">Semester 1</option>
                                            <option value="2">Semester 2</option>
                                            <option value="3">Semester 3</option>
                                            <option value="4">Semester 4</option>
                                            <option value="5">Semester 5</option>
                                            <option value="6">Semester 6</option>
                                            <option value="7">Semester 7</option>
                                            <option value="8">Semester 8</option>
                                        </select>
                                        <p class="text-red-500 text-xs mt-1" id="errorSemester" style="display: none;"></p>
                                    </div>

                                    <!-- Jurusan -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Jurusan <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               name="jurusan" 
                                               id="editJurusan"
                                               value="" 
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-red-500 text-xs mt-1" id="errorJurusan" style="display: none;"></p>
                                    </div>

                                    <!-- Password -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                        <input type="password" 
                                               name="password" 
                                               id="editPassword"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-red-500 text-xs mt-1" id="errorPassword" style="display: none;"></p>
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-gray-600">Konfirmasi Password Baru</label>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="editPasswordConfirmation"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                                    <a href="/mahasiswa/profil" 
                                       class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                        Batal
                                    </a>
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


</body>
</html>
