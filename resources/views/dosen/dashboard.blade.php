<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SPA Sistem Penilaian Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen">
    @include('partials.dosen-navbar')

    @include('partials.dosen-sidebar')

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div class="p-6">
            <!-- Page Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                <p class="text-gray-600 text-sm mt-1">Ringkasan aktivitas dan statistik akademik</p>
            </div>

            <!-- Content Dashboard -->
            <div class="space-y-6">
                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Jumlah Mahasiswa -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium mb-1">Mahasiswa Terdaftar</p>
                                <p class="text-3xl font-bold">25</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <i class="fas fa-user-graduate text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Mata Kuliah -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium mb-1">Mata Kuliah Diampu</p>
                                <p class="text-3xl font-bold">3</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <i class="fas fa-book text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nilai Tertinggi -->
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium mb-1">Nilai Tertinggi</p>
                                <p class="text-3xl font-bold">95.50</p>
                                <p class="text-xs text-purple-100 mt-1">Ahmad Rizki</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <i class="fas fa-arrow-up text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nilai Terendah -->
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium mb-1">Nilai Terendah</p>
                                <p class="text-3xl font-bold">65.00</p>
                                <p class="text-xs text-orange-100 mt-1">Budi Santoso</p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <i class="fas fa-arrow-down text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Cepat -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-bolt text-blue-600 mr-2"></i>Menu Cepat
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="/dosen/nilai-mahasiswa" class="flex items-center space-x-4 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all shadow-md hover:shadow-lg">
                            <div class="bg-blue-600 text-white p-3 rounded-lg">
                                <i class="fas fa-pen-to-square text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Input Nilai</p>
                                <p class="text-xs text-gray-600">Input nilai mahasiswa</p>
                            </div>
                        </a>

                        <a href="/dosen/komponen-penilaian" class="flex items-center space-x-4 p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg hover:from-green-100 hover:to-green-200 transition-all shadow-md hover:shadow-lg">
                            <div class="bg-green-600 text-white p-3 rounded-lg">
                                <i class="fas fa-clipboard-check text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Komponen Penilaian</p>
                                <p class="text-xs text-gray-600">Atur komponen penilaian</p>
                            </div>
                        </a>

                        <a href="/dosen/matakuliahs" class="flex items-center space-x-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition-all shadow-md hover:shadow-lg">
                            <div class="bg-purple-600 text-white p-3 rounded-lg">
                                <i class="fas fa-book text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Kelola Mata Kuliah</p>
                                <p class="text-xs text-gray-600">Kelola data mata kuliah</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Daftar Mata Kuliah -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-list text-purple-600 mr-2"></i>Daftar Mata Kuliah
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kode MK</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama Mata Kuliah</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Semester</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">SKS</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Jumlah Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">TIF101</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">Pemrograman Web</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-700">3</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-700">3</td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            15 mahasiswa
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-700">2</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">TIF102</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">Basis Data</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-700">3</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-700">3</td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            18 mahasiswa
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-700">3</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">TIF103</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">Algoritma dan Struktur Data</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-700">2</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-700">4</td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            20 mahasiswa
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script -->

</body>
</html>
