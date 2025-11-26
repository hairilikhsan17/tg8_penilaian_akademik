<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nilai Akademik - Portal Mahasiswa</title>
    
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
            <a href="/mahasiswa/nilai" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors menu-item bg-blue-600 hover:bg-blue-700" data-menu="nilai">
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
            <a href="/mahasiswa/profil" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors menu-item" data-menu="profil">
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
                    <span class="text-white font-semibold">3</span>
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
    <div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden lg:hidden"></div>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div class="p-6">
            <!-- Page Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Nilai Akademik</h2>
                <p class="text-gray-600 text-sm mt-1">Lihat daftar nilai mata kuliah Anda</p>
            </div>

            <div class="space-y-6">
            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-filter text-blue-600 mr-2"></i>Filter Nilai
                </h3>
                <form method="GET" action="/mahasiswa/nilai" class="flex items-end space-x-4" id="filterForm">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Berdasarkan Semester</label>
                        <select name="semester" id="semesterSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Semester</option>
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="/mahasiswa/nilai" id="resetBtn" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-medium hidden">
                        <i class="fas fa-times mr-2"></i>Reset
                    </a>
                </form>
            </div>

            <!-- Tabel Nilai -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-list text-purple-600 mr-2"></i>Daftar Nilai Mata Kuliah
                    </h3>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold" id="totalBadge">
                        Total: <span id="totalNilai">1</span> mata kuliah
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase">No</th>
                                <th class="px-2 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kode MK</th>
                                <th class="px-2 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Mata Kuliah</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase">SMT</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase">SKS</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-blue-50">Hadir</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-green-50">Tugas</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-purple-50">Quiz</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-indigo-50">Project</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-orange-50">UTS</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-red-50">UAS</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-yellow-50">Nilai Akhir</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-green-50">Huruf Mutu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-2 py-3 text-center text-sm text-gray-700">1</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">TIF101</span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="text-sm font-medium text-gray-900">Pemrograman Web</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700">3</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700">3</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700 bg-blue-50">90.00</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700 bg-green-50">85.00</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700 bg-purple-50">88.00</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700 bg-indigo-50">92.00</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700 bg-orange-50">87.00</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700 bg-red-50">90.00</td>
                                <td class="px-2 py-3 whitespace-nowrap text-center font-semibold text-gray-900 bg-yellow-50">88.50</td>
                                <td class="px-2 py-3 text-center bg-green-50">
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">
                                        A
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 text-xl mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-blue-800 font-medium mb-1">Informasi Nilai Akademik</p>
                        <ul class="text-sm text-blue-700 space-y-1 list-disc list-inside">
                            <li>Nilai ditampilkan berdasarkan mata kuliah yang telah diinput oleh dosen</li>
                            <li>Gunakan filter semester untuk menyaring data berdasarkan semester tertentu</li>
                            <li>Huruf mutu: A (≥85), B (75-84), C (65-74), D (55-64), E (<55)</li>
                            <li>Nilai akhir dihitung berdasarkan komponen penilaian yang ditetapkan dosen</li>
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
