<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nilai - SPA Sistem Penilaian Akademik</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <a href="/dosen/laporan-nilai" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors menu-item bg-blue-600 hover:bg-blue-700" data-menu="laporan-nilai">
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
                <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center text-white font-bold text-xl">
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
        <div class="p-6 space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Laporan Nilai</h2>
                <p class="text-gray-600 text-sm mt-1">Rekap nilai mahasiswa per mata kuliah</p>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-filter mr-2 text-blue-600"></i>Filter Laporan
                </h3>
                <form method="GET" action="/dosen/laporan-nilai" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option>Semua Semester</option>
                            <option>Semester 1</option>
                            <option>Semester 2</option>
                            <option selected>Semester 3</option>
                            <option>Semester 4</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mata Kuliah</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option>Semua Mata Kuliah</option>
                            <option>TIF101 - Pemrograman Web (S3)</option>
                            <option>TIF102 - Basis Data (S3)</option>
                            <option>TIF103 - Algoritma dan Struktur Data (S2)</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="button" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Export Buttons -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-blue-500 rounded-lg p-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="font-semibold text-gray-800">
                            <i class="fas fa-file-export mr-2 text-blue-600"></i>Export Laporan
                        </h4>
                        <p class="text-sm text-gray-600 mt-1">Cetak laporan dalam format PDF</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="/dosen/laporan-nilai/pdf" id="btnCetakPdf" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-md hover:shadow-lg">
                            <i class="fas fa-file-pdf mr-2"></i>Cetak PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tabel Nilai -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                    <h4 class="text-lg font-semibold">Rekap Nilai Mahasiswa</h4>
                    <p class="text-sm text-indigo-100 mt-1">Total data: <strong>2</strong> nilai</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-2 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kode MK</th>
                                <th class="px-2 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Mata Kuliah</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">SMT</th>
                                <th class="px-2 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIM</th>
                                <th class="px-2 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Mahasiswa</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-blue-50">Hadir</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-green-50">Tugas</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-purple-50">Quiz</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-indigo-50">Project</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-orange-50">UTS</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-red-50">UAS</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-yellow-50">Nilai Akhir</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-yellow-50">Huruf Mutu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700">1</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">TIF101</span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="text-sm font-medium text-gray-900">Pemrograman Web</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700">3</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">1234567890</span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="text-sm text-gray-900">Ahmad Rizki</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-blue-50">
                                    <span class="text-sm font-medium text-gray-700">90.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-green-50">
                                    <span class="text-sm font-medium text-gray-700">85.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-purple-50">
                                    <span class="text-sm font-medium text-gray-700">88.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-indigo-50">
                                    <span class="text-sm font-medium text-gray-700">92.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-orange-50">
                                    <span class="text-sm font-medium text-gray-700">87.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-red-50">
                                    <span class="text-sm font-medium text-gray-700">90.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-yellow-50">
                                    <span class="text-sm font-bold text-gray-900">88.50</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-yellow-50">
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">A</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700">2</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">TIF101</span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="text-sm font-medium text-gray-900">Pemrograman Web</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700">3</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">1234567891</span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="text-sm text-gray-900">Budi Santoso</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-blue-50">
                                    <span class="text-sm font-medium text-gray-700">85.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-green-50">
                                    <span class="text-sm font-medium text-gray-700">80.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-purple-50">
                                    <span class="text-sm font-medium text-gray-700">82.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-indigo-50">
                                    <span class="text-sm font-medium text-gray-700">85.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-orange-50">
                                    <span class="text-sm font-medium text-gray-700">78.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-red-50">
                                    <span class="text-sm font-medium text-gray-700">80.00</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-yellow-50">
                                    <span class="text-sm font-bold text-gray-900">81.20</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-yellow-50">
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">B</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold mb-2">Informasi Laporan:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Laporan menampilkan semua nilai mahasiswa dari mata kuliah yang Anda ampu.</li>
                            <li>Gunakan filter untuk menyaring data berdasarkan semester atau mata kuliah tertentu.</li>
                            <li>Anda dapat mencetak laporan dalam format PDF.</li>
                            <li>Kolom nilai ditampilkan dengan 2 angka desimal.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script -->
    
</body>
</html>

