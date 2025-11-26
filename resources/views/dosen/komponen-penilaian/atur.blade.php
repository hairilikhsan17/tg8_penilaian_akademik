<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Komponen Penilaian - SPA Sistem Penilaian Akademik</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/mahasiswas.css">
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .rotate-180 {
            transform: rotate(180deg);
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
                                A
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-700">Amirawati M.kom</p>
                                <p class="text-xs text-gray-500">NIP-123456</p>
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
            <a href="/dosen/komponen-penilaian" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors menu-item bg-blue-600 hover:bg-blue-700" data-menu="komponen-penilaian">
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
            <a href="/dosen/profil" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="profil">
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
                    A
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white whitespace-nowrap">Amirawati M.kom</p>
                    <p class="text-xs text-gray-300 mt-1">NIP-123456</p>
                </div>
            </div>
            <div class="text-xs space-y-1">
                <div class="flex justify-between">
                    <span class="text-gray-300">Mata Kuliah:</span>
                    <span class="text-white font-semibold">3</span>
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
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="/dosen/dashboard" class="hover:text-blue-600"><i class="fas fa-home"></i></a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li><a href="/dosen/komponen-penilaian" class="hover:text-blue-600">Komponen Penilaian</a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li class="text-gray-700">Atur</li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Atur Komponen Penilaian</h2>
                <p class="text-gray-600 text-sm mt-1">Tentukan bobot penilaian untuk mata kuliah</p>
            </div>

            <div class="space-y-6">
                <!-- Info Mata Kuliah -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-blue-500 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800" id="matakuliahNama">Basis Data</h3>
                            <p class="text-sm text-gray-600 mt-1" id="matakuliahInfo">
                                <span class="font-semibold">Kode:</span> <span id="matakuliahKode">TIF102</span> | 
                                <span class="font-semibold">Semester:</span> <span id="matakuliahSemester">3</span> | 
                                <span class="font-semibold">SKS:</span> <span id="matakuliahSKS">3</span>
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="text-xs text-gray-500 mb-1">Total Bobot</p>
                                <p id="total-display" class="text-2xl font-bold text-blue-600">0%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <form method="POST" action="/dosen/komponen-penilaian" class="space-y-6" id="komponen-form">
                        @csrf
                        <input type="hidden" name="matakuliah_id" id="matakuliahId" value="2">

                        <!-- Info Penting -->
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mr-3 mt-0.5"></i>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Ketentuan:</p>
                                    <ul class="list-disc list-inside space-y-1 text-xs">
                                        <li>Total bobot semua komponen harus <strong>tepat 100%</strong></li>
                                        <li>Nilai minimum per komponen: 0%, maksimum: 100%</li>
                                        <li>Komponen penilaian ini akan digunakan untuk menghitung nilai akhir mahasiswa</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Hadir (Kehadiran) -->
                            <div class="bg-gray-50 rounded-lg p-5 border-2 border-gray-200">
                                <label for="kehadiran" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user-check text-blue-600 mr-2"></i>Hadir <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-3">
                                    <input type="number" 
                                           id="kehadiran" 
                                           name="kehadiran" 
                                           required
                                           min="0"
                                           max="100"
                                           oninput="updateTotal()"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-lg font-semibold text-center">
                                    <span class="text-gray-600 font-medium text-lg">%</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Bobot untuk penilaian kehadiran mahasiswa</p>
                            </div>

                            <!-- Tugas -->
                            <div class="bg-gray-50 rounded-lg p-5 border-2 border-gray-200">
                                <label for="tugas" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tasks text-green-600 mr-2"></i>Tugas <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-3">
                                    <input type="number" 
                                           id="tugas" 
                                           name="tugas" 
                                           required
                                           min="0"
                                           max="100"
                                           oninput="updateTotal()"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-lg font-semibold text-center">
                                    <span class="text-gray-600 font-medium text-lg">%</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Bobot untuk penilaian tugas mahasiswa</p>
                            </div>

                            <!-- Quiz -->
                            <div class="bg-gray-50 rounded-lg p-5 border-2 border-gray-200">
                                <label for="kuis" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-question-circle text-purple-600 mr-2"></i>Quiz <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-3">
                                    <input type="number" 
                                           id="kuis" 
                                           name="kuis" 
                                           required
                                           min="0"
                                           max="100"
                                           oninput="updateTotal()"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-lg font-semibold text-center">
                                    <span class="text-gray-600 font-medium text-lg">%</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Bobot untuk penilaian kuis/quiz</p>
                            </div>

                            <!-- Project -->
                            <div class="bg-gray-50 rounded-lg p-5 border-2 border-gray-200">
                                <label for="project" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-project-diagram text-indigo-600 mr-2"></i>Project <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-3">
                                    <input type="number" 
                                           id="project" 
                                           name="project" 
                                           required
                                           min="0"
                                           max="100"
                                           oninput="updateTotal()"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-lg font-semibold text-center">
                                    <span class="text-gray-600 font-medium text-lg">%</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Bobot untuk penilaian project</p>
                            </div>

                            <!-- Mid (UTS) -->
                            <div class="bg-gray-50 rounded-lg p-5 border-2 border-gray-200">
                                <label for="uts" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-clipboard-list text-orange-600 mr-2"></i>Mid (UTS) <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-3">
                                    <input type="number" 
                                           id="uts" 
                                           name="uts" 
                                           required
                                           min="0"
                                           max="100"
                                           oninput="updateTotal()"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all text-lg font-semibold text-center">
                                    <span class="text-gray-600 font-medium text-lg">%</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Bobot untuk Ujian Tengah Semester</p>
                            </div>

                            <!-- Final (UAS) -->
                            <div class="bg-gray-50 rounded-lg p-5 border-2 border-gray-200 md:col-span-2">
                                <label for="uas" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-graduation-cap text-red-600 mr-2"></i>Final (UAS) <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-3 max-w-md">
                                    <input type="number" 
                                           id="uas" 
                                           name="uas" 
                                           required
                                           min="0"
                                           max="100"
                                           oninput="updateTotal()"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-lg font-semibold text-center">
                                    <span class="text-gray-600 font-medium text-lg">%</span>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Bobot untuk Ujian Akhir Semester</p>
                            </div>
                        </div>

                        <!-- Total Display (Mobile) -->
                        <div class="md:hidden bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-4 text-white">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">Total Bobot:</span>
                                <span id="total-display-mobile" class="text-2xl font-bold">0%</span>
                            </div>
                            <div id="total-status" class="mt-2 text-xs">
                                <span class="text-yellow-200"><i class="fas fa-exclamation-triangle"></i> Kurang 100%</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="/dosen/komponen-penilaian" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" 
                                    id="submit-btn"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-save mr-2"></i>Simpan Komponen Penilaian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script -->
    
</body>
</html>
