<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KHS / Transkrip Nilai - Portal Mahasiswa</title>
    
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
                            @php
                                $mahasiswaId = session('user_id');
                                $mahasiswaData = \App\Models\DataUserModel::find($mahasiswaId);
                                $namaMahasiswa = $mahasiswaData ? $mahasiswaData->nama_user : session('nama_user', 'Mahasiswa');
                                $nimMahasiswa = $mahasiswaData ? ($mahasiswaData->nim ?? '-') : '-';
                                $initialMahasiswa = strtoupper(substr($namaMahasiswa, 0, 1));
                            @endphp
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ $initialMahasiswa }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-700">{{ $namaMahasiswa }}</p>
                                <p class="text-xs text-gray-500">{{ $nimMahasiswa }}</p>
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
            <a href="/mahasiswa/khs" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors menu-item bg-blue-600 hover:bg-blue-700" data-menu="khs">
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
            @php
                $semesterAktif = $mahasiswa->semester ?? '-';
            @endphp
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                    {{ $initialMahasiswa }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-white truncate">{{ $namaMahasiswa }}</p>
                    <p class="text-xs text-blue-300">{{ $nimMahasiswa }}</p>
                </div>
            </div>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-blue-300">Semester:</span>
                    <span class="text-white font-semibold">{{ $semesterAktif }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-blue-300">IPK:</span>
                    <span class="text-white font-semibold">{{ number_format($ipk, 2) }}</span>
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
                <h2 class="text-2xl font-bold text-gray-800">KHS / Transkrip Nilai</h2>
                <p class="text-gray-600 text-sm mt-1">Lihat dan cetak Kartu Hasil Studi (KHS) Anda</p>
            </div>

            <div class="space-y-6">
            <!-- Header dengan Tombol Cetak -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Kartu Hasil Studi (KHS)</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Nama: <span class="font-semibold">{{ $mahasiswa->nama_user ?? '-' }}</span> | 
                            NIM: <span class="font-semibold">{{ $mahasiswa->nim ?? '-' }}</span>
                        </p>
                    </div>
                    <a href="/mahasiswa/cetak-khs" target="_blank" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium flex items-center space-x-2">
                        <i class="fas fa-file-pdf"></i>
                        <span>Cetak PDF</span>
                    </a>
                </div>

                <!-- Info IPK -->
                @if($nilai->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                        <p class="text-sm text-blue-100 mb-1">Total SKS</p>
                        <p class="text-2xl font-bold">{{ $totalSKS }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4 text-white">
                        <p class="text-sm text-green-100 mb-1">IPK (Indeks Prestasi Kumulatif)</p>
                        <p class="text-2xl font-bold">{{ number_format($ipk, 2) }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                        <p class="text-sm text-purple-100 mb-1">Total Mata Kuliah</p>
                        <p class="text-2xl font-bold">{{ $nilai->count() }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Tabel KHS -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-list text-purple-600 mr-2"></i>Daftar Mata Kuliah
                </h3>

                @if($nilai->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kode MK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Mata Kuliah</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Semester</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">SKS</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Nilai Akhir</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Huruf Mutu</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Bobot</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalSKSRow = 0;
                                $totalBobotRow = 0;
                            @endphp
                            @foreach($nilai as $index => $item)
                            @php
                                $sks = $item->matakuliah->sks ?? 0;
                                $nilaiAkhir = $item->nilai_akhir ?? 0;
                                $hurufMutu = $item->huruf_mutu ?? '';
                                
                                // Konversi huruf mutu ke bobot
                                if ($hurufMutu) {
                                    $bobot = \App\Models\InputNilaiModel::hurufMutuToBobot($hurufMutu);
                                } else {
                                    // Jika belum ada huruf mutu, hitung dari nilai akhir
                                    $hurufMutuDariNilai = '';
                                    if ($nilaiAkhir >= 90) $hurufMutuDariNilai = 'A';
                                    elseif ($nilaiAkhir >= 85) $hurufMutuDariNilai = 'A-';
                                    elseif ($nilaiAkhir >= 80) $hurufMutuDariNilai = 'B+';
                                    elseif ($nilaiAkhir >= 75) $hurufMutuDariNilai = 'B';
                                    elseif ($nilaiAkhir >= 70) $hurufMutuDariNilai = 'B-';
                                    elseif ($nilaiAkhir >= 65) $hurufMutuDariNilai = 'C+';
                                    elseif ($nilaiAkhir >= 60) $hurufMutuDariNilai = 'C';
                                    elseif ($nilaiAkhir >= 55) $hurufMutuDariNilai = 'C-';
                                    elseif ($nilaiAkhir >= 50) $hurufMutuDariNilai = 'D';
                                    else $hurufMutuDariNilai = 'E';
                                    $bobot = \App\Models\InputNilaiModel::hurufMutuToBobot($hurufMutuDariNilai);
                                }
                                
                                $nilaiKualitas = $sks * $bobot;
                                $totalSKSRow += $sks;
                                $totalBobotRow += $nilaiKualitas;
                                
                                // Warna untuk huruf mutu
                                $colors = $hurufMutu ? \App\Models\InputNilaiModel::getHurufMutuColors($hurufMutu) : ['bgColor' => 'bg-gray-100', 'textColor' => 'text-gray-600'];
                                $gradeBg = $colors['bgColor'];
                                $gradeText = $colors['textColor'];
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-left text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $item->matakuliah->kode_mk ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-medium text-gray-900">{{ $item->matakuliah->nama_mk ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">{{ $item->matakuliah->semester ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">{{ $sks }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">
                                    {{ $nilaiAkhir > 0 ? number_format($nilaiAkhir, 2) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($hurufMutu && $hurufMutu != '-')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $gradeBg }} {{ $gradeText }}">
                                            {{ $hurufMutu }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            -
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">
                                    {{ $nilaiKualitas > 0 ? number_format($nilaiKualitas, 2) : '-' }}
                                </td>
                            </tr>
                            @endforeach
                            <!-- Total Row -->
                            <tr class="bg-gray-50 font-semibold">
                                <td class="px-4 py-3 text-left text-sm text-gray-700"></td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700"></td>
                                <td class="px-4 py-3 text-sm text-gray-700"></td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">TOTAL</td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">{{ $totalSKSRow }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">--</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-700">--</td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700">{{ number_format($totalBobotRow, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-clipboard-list text-5xl mb-4"></i>
                    <p class="text-lg font-medium mb-2">Belum ada data KHS</p>
                    <p class="text-sm">Data KHS akan ditampilkan setelah ada nilai yang diinput oleh dosen</p>
                </div>
                @endif
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 text-xl mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-blue-800 font-medium mb-1">Informasi KHS / Transkrip Nilai</p>
                        <ul class="text-sm text-blue-700 space-y-1 list-disc list-inside">
                            <li>KHS menampilkan semua nilai mata kuliah yang telah Anda ambil</li>
                            <li>IPK dihitung berdasarkan bobot nilai (A=4.00, A-=3.75, B+=3.50, B=3.00, B-=2.75, C+=2.50, C=2.00, C-=1.75, D=1.00, E=0.00) dikalikan dengan SKS</li>
                            <li>Anda dapat mencetak KHS dalam format PDF untuk keperluan administrasi</li>
                            <li>Klik tombol "Cetak PDF" untuk mengunduh atau mencetak KHS</li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script -->
    <script>
        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        }

        // User dropdown functionality
        const userDropdown = document.getElementById('userDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');

        if (userDropdown) {
            userDropdown.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!userDropdown.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
