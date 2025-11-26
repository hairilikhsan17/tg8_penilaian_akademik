<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Mahasiswa - SPA Sistem Penilaian Akademik</title>
    
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
            <a href="/dosen/komponen-penilaian" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="komponen-penilaian">
                <i class="fas fa-clipboard-check text-lg w-5"></i>
                <span class="font-medium">Komponen Penilaian</span>
            </a>
            <a href="/dosen/nilai-mahasiswa" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors menu-item bg-blue-600 hover:bg-blue-700" data-menu="nilai-mahasiswa">
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
            <!-- Page Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Input Nilai Mahasiswa</h2>
                <p class="text-gray-600 text-sm mt-1">Input nilai untuk mata kuliah Pemrograman Web</p>
            </div>

            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="/dosen/dashboard" class="hover:text-blue-600"><i class="fas fa-home"></i></a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li><a href="/dosen/nilai-mahasiswa" class="hover:text-blue-600">Input Nilai</a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li class="text-gray-700">Pemrograman Web</li>
                </ol>
            </nav>

            <div class="space-y-6">
                <!-- Info Mata Kuliah -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-blue-500 rounded-lg p-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Pemrograman Web</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                <span class="font-semibold">Kode:</span> IF301 | 
                                <span class="font-semibold">Semester:</span> 3 | 
                                <span class="font-semibold">SKS:</span> 3
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                                <p class="text-xs text-gray-500 mb-1">Komponen Penilaian</p>
                                <div class="flex flex-wrap gap-2 text-xs">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">KEHADIR: 10%</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded">TUGAS: 20%</span>
                                    <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded">QUIZ: 10%</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">PROJECT: 10%</span>
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded">UTS: 20%</span>
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded">UAS: 30%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Input Nilai -->
                <form method="POST" action="/dosen/nilai-mahasiswa" class="space-y-6">
                    @csrf
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                            <h4 class="text-lg font-semibold">Input Nilai Mahasiswa</h4>
                            <p class="text-sm text-indigo-100 mt-1">Masukkan nilai untuk setiap komponen penilaian (0-100)</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider sticky left-12 bg-gray-50 z-10">NIM</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider sticky left-32 bg-gray-50 z-10 min-w-[200px]">Nama</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-blue-600 font-bold">KEHADIR</span>
                                                <span class="text-blue-600 font-bold">(10%)</span>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-green-600 font-bold">TUGAS</span>
                                                <span class="text-green-600 font-bold">(20%)</span>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-purple-600 font-bold">QUIZ</span>
                                                <span class="text-purple-600 font-bold">(10%)</span>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-blue-600 font-bold">PROJECT</span>
                                                <span class="text-blue-600 font-bold">(10%)</span>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-red-600 font-bold">UTS</span>
                                                <span class="text-red-600 font-bold">(20%)</span>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-red-600 font-bold">UAS</span>
                                                <span class="text-red-600 font-bold">(30%)</span>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-yellow-50">
                                            <div class="flex flex-col items-center">
                                                <span>Nilai Akhir</span>
                                                <span class="text-gray-600 text-xs">(Otomatis)</span>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-yellow-50">
                                            <div class="flex flex-col items-center">
                                                <span>Huruf Mutu</span>
                                                <span class="text-gray-600 text-xs">(Otomatis)</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 sticky left-0 bg-white">1</td>
                                        <td class="px-4 py-3 whitespace-nowrap sticky left-12 bg-white">
                                            <span class="text-sm font-semibold text-gray-900">1234567890</span>
                                        </td>
                                        <td class="px-4 py-3 sticky left-32 bg-white min-w-[200px]">
                                            <span class="text-sm font-medium text-gray-900">Ahmad Rizki</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[1][kehadiran]"
                                                   value="90"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[1][tugas]"
                                                   value="85"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[1][quiz]"
                                                   value="88"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[1][project]"
                                                   value="92"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[1][uts]"
                                                   value="87"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[1][uas]"
                                                   value="90"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-yellow-50">
                                            <span class="text-sm font-bold text-gray-900">88.60</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-yellow-50">
                                            <span class="px-2 py-1 text-xs font-semibold rounded border border-green-600 bg-green-100 text-green-800">A</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 sticky left-0 bg-white">2</td>
                                        <td class="px-4 py-3 whitespace-nowrap sticky left-12 bg-white">
                                            <span class="text-sm font-semibold text-gray-900">12345678</span>
                                        </td>
                                        <td class="px-4 py-3 sticky left-32 bg-white min-w-[200px]">
                                            <span class="text-sm font-medium text-gray-900">Budi Santoso</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[2][kehadiran]"
                                                   value="85"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[2][tugas]"
                                                   value="80"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[2][quiz]"
                                                   value="82"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[2][project]"
                                                   value="85"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[2][uts]"
                                                   value="78"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[2][uas]"
                                                   value="80"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-yellow-50">
                                            <span class="text-sm font-bold text-gray-900">81.30</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-yellow-50">
                                            <span class="px-2 py-1 text-xs font-semibold rounded border border-blue-600 bg-blue-100 text-blue-800">B</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 sticky left-0 bg-white">3</td>
                                        <td class="px-4 py-3 whitespace-nowrap sticky left-12 bg-white">
                                            <span class="text-sm font-semibold text-gray-900">12345678</span>
                                        </td>
                                        <td class="px-4 py-3 sticky left-32 bg-white min-w-[200px]">
                                            <span class="text-sm font-medium text-gray-900">Siti Nurhaliza</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[3][kehadiran]"
                                                   value="88"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[3][tugas]"
                                                   value="85"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[3][quiz]"
                                                   value="87"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[3][project]"
                                                   value="90"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[3][uts]"
                                                   value="85"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[3][uas]"
                                                   value="88"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-yellow-50">
                                            <span class="text-sm font-bold text-gray-900">87.10</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-yellow-50">
                                            <span class="px-2 py-1 text-xs font-semibold rounded border border-green-600 bg-green-100 text-green-800">A</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-2"></i>
                                Total mahasiswa: <strong>3</strong> | 
                                Nilai akan dihitung otomatis berdasarkan bobot komponen penilaian
                            </p>
                            <div class="flex items-center space-x-3">
                                <a href="/dosen/nilai-mahasiswa" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                </a>
                                <button type="submit" 
                                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl">
                                    <i class="fas fa-save mr-2"></i>Simpan Nilai
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Info Card -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mr-3 mt-0.5"></i>
                        <div class="text-sm text-blue-700">
                            <p class="font-semibold mb-2">Cara Input Nilai:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Masukkan nilai untuk setiap komponen penilaian (0-100)</li>
                                <li>Nilai akhir akan dihitung otomatis berdasarkan bobot komponen yang telah ditentukan</li>
                                <li>Huruf mutu akan ditentukan otomatis: A (≥85), B (75-84), C (65-74), D (55-64), E (<55)</li>
                                <li>Anda dapat menyimpan sebagian nilai saja, tidak harus semua sekaligus</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script -->
    
</body>
</html>
