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
        
        /* Responsive Table Styles */
        @media (max-width: 768px) {
            /* Reduce padding on mobile */
            .table-responsive th,
            .table-responsive td {
                padding: 0.5rem 0.25rem !important;
                font-size: 0.7rem !important;
            }
            
            /* Make sticky columns work better on mobile */
            .table-responsive th.sticky,
            .table-responsive td.sticky {
                position: sticky;
                left: 0;
                z-index: 20;
                background: white;
                box-shadow: 2px 0 4px rgba(0,0,0,0.1);
            }
            
            .table-responsive th.sticky-nim,
            .table-responsive td.sticky-nim {
                left: 2.5rem;
                z-index: 19;
            }
            
            .table-responsive th.sticky-nama,
            .table-responsive td.sticky-nama {
                left: 6rem;
                z-index: 18;
                min-width: 120px;
            }
            
            /* Smaller input fields on mobile */
            .table-responsive input[type="number"] {
                width: 100%;
                max-width: 60px;
                font-size: 0.7rem;
                padding: 0.25rem;
            }
            
            /* Scroll indicator */
            .table-wrapper {
                position: relative;
            }
            
            .table-wrapper::after {
                content: '← Scroll →';
                position: absolute;
                bottom: 10px;
                right: 10px;
                background: rgba(0,0,0,0.7);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                font-size: 0.75rem;
                pointer-events: none;
                animation: fadeOut 3s ease-in-out forwards;
            }
            
            @keyframes fadeOut {
                0%, 50% { opacity: 1; }
                100% { opacity: 0; }
            }
            
            /* Header adjustments */
            .table-responsive thead th {
                white-space: nowrap;
                font-size: 0.65rem;
            }
            
            /* Button adjustments */
            .table-responsive .btn-hapus-tugas,
            .table-responsive .btn-hapus-project {
                font-size: 0.6rem;
                padding: 0.125rem;
            }
        }
        
        @media (max-width: 640px) {
            /* Even smaller on very small screens */
            .table-responsive th,
            .table-responsive td {
                padding: 0.375rem 0.125rem !important;
                font-size: 0.65rem !important;
            }
            
            .table-responsive input[type="number"] {
                max-width: 50px;
                font-size: 0.65rem;
                padding: 0.2rem;
            }
            
            /* Hide some less important columns on very small screens */
            .table-responsive .hide-mobile {
                display: none;
            }
        }
        
        /* Smooth scrolling */
        .table-wrapper {
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }
        
        /* Scrollbar styling for mobile */
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
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
                            @php
                                $dosenId = session('user_id');
                                $dosen = \App\Models\DataUserModel::find($dosenId);
                                $namaDosen = $dosen ? $dosen->nama_user : session('nama_user', 'Dosen');
                                $nipDosen = $dosen ? ($dosen->nip ?? 'NIP-') : 'NIP-';
                                $initial = strtoupper(substr($namaDosen, 0, 1));
                            @endphp
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ $initial }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-700">{{ $namaDosen }}</p>
                                <p class="text-xs text-gray-500">{{ $nipDosen }}</p>
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
                @php
                    $totalMatakuliah = \App\Models\MatakuliahModel::where('dosen_id', $dosenId)->count();
                @endphp
                <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center text-white font-bold text-xl" style="aspect-ratio: 1/1; min-width: 4rem; min-height: 4rem;">
                    {{ $initial }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white whitespace-nowrap">{{ $namaDosen }}</p>
                    <p class="text-xs text-gray-300 mt-1">{{ $nipDosen }}</p>
                </div>
            </div>
            <div class="text-xs space-y-1">
                <div class="flex justify-between">
                    <span class="text-gray-300">Mata Kuliah:</span>
                    <span class="text-white font-semibold">{{ $totalMatakuliah }}</span>
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
        <div class="p-3 sm:p-6">
            <!-- Page Title -->
            <div class="mb-4 sm:mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Input Nilai Mahasiswa</h2>
                <p class="text-gray-600 text-xs sm:text-sm mt-1">Input nilai untuk mata kuliah {{ $matakuliah->nama_mk }}</p>
            </div>

            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="/dosen/dashboard" class="hover:text-blue-600"><i class="fas fa-home"></i></a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li><a href="/dosen/nilai-mahasiswa" class="hover:text-blue-600">Input Nilai</a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li class="text-gray-700">{{ $matakuliah->nama_mk }}</li>
                </ol>
            </nav>

            <div class="space-y-6">
                <!-- Info Mata Kuliah -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-l-4 border-blue-500 rounded-lg p-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $matakuliah->nama_mk }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                <span class="font-semibold">Kode:</span> {{ $matakuliah->kode_mk }} | 
                                <span class="font-semibold">Semester:</span> {{ $matakuliah->semester }} | 
                                <span class="font-semibold">SKS:</span> {{ $matakuliah->sks }}
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                                <p class="text-xs text-gray-500 mb-1">Komponen Penilaian</p>
                                <div class="flex flex-wrap gap-2 text-xs">
                                    @if($komponen->kehadiran > 0)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">KEHADIRAN: {{ $komponen->kehadiran }}%</span>
                                    @endif
                                    @if($komponen->tugas > 0)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded">TUGAS: {{ $komponen->tugas }}%</span>
                                    @endif
                                    @if($komponen->kuis > 0)
                                        <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded">QUIZ: {{ $komponen->kuis }}%</span>
                                    @endif
                                    @if($komponen->project > 0)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">PROJECT: {{ $komponen->project }}%</span>
                                    @endif
                                    @if($komponen->uts > 0)
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded">UTS: {{ $komponen->uts }}%</span>
                                    @endif
                                    @if($komponen->uas > 0)
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded">UAS: {{ $komponen->uas }}%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Input Nilai -->
                <form method="POST" action="/dosen/matakuliahs/{{ $matakuliah->id }}/nilai" class="space-y-6">
                    @csrf
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-3 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                <div>
                                    <h4 class="text-base sm:text-lg font-semibold">Input Nilai Mahasiswa</h4>
                                    <p class="text-xs sm:text-sm text-indigo-100 mt-1">Masukkan nilai untuk setiap komponen penilaian (0-100)</p>
                                </div>
                                <div class="flex items-center space-x-2 flex-wrap gap-2">
                                    @if($komponen->tugas > 0)
                                    <button type="button" id="btnTambahTugas" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                                        <i class="fas fa-plus mr-1 sm:mr-2"></i><span class="hidden sm:inline">Tambah </span>Tugas
                                    </button>
                                    @endif
                                    @if($komponen->project > 0)
                                    <button type="button" id="btnTambahProject" class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                                        <i class="fas fa-plus mr-1 sm:mr-2"></i><span class="hidden sm:inline">Tambah </span>Project
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto table-wrapper">
                            <table class="min-w-full divide-y divide-gray-200 table-responsive">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider sticky left-12 bg-gray-50 z-10 sticky-nim">NIM</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider sticky left-32 bg-gray-50 z-10 min-w-[200px] sticky-nama">Nama</th>
                                        @if($komponen->kehadiran > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-blue-600 font-bold">KEHADIRAN</span>
                                                <span class="text-blue-600 font-bold">({{ $komponen->kehadiran }}%)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->tugas > 0)
                                        @php
                                            $jumlahTugas = $komponen->jumlah_tugas ?? 1;
                                        @endphp
                                        @for($i = 1; $i <= $jumlahTugas; $i++)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider tugas-header" data-index="{{ $i }}" data-komponen="tugas" data-bobot="{{ $komponen->tugas }}" data-col-index="{{ $i - 1 }}">
                                            <div class="flex flex-col items-center">
                                                <span class="text-green-600 font-bold">TUGAS {{ $i }}</span>
                                                <span class="text-green-600 font-bold text-xs">({{ $komponen->tugas }}%)</span>
                                            </div>
                                        </th>
                                        @endfor
                                        @endif
                                        @if($komponen->kuis > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-purple-600 font-bold">QUIZ</span>
                                                <span class="text-purple-600 font-bold">({{ $komponen->kuis }}%)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->project > 0)
                                        @php
                                            $jumlahProject = $komponen->jumlah_project ?? 1;
                                        @endphp
                                        @for($i = 1; $i <= $jumlahProject; $i++)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider project-header" data-index="{{ $i }}" data-komponen="project" data-bobot="{{ $komponen->project }}" data-col-index="{{ $i - 1 }}">
                                            <div class="flex flex-col items-center">
                                                <span class="text-blue-600 font-bold">PROJECT {{ $i }}</span>
                                                <span class="text-blue-600 font-bold text-xs">({{ $komponen->project }}%)</span>
                                            </div>
                                        </th>
                                        @endfor
                                        @endif
                                        @if($komponen->uts > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-red-600 font-bold">UTS</span>
                                                <span class="text-red-600 font-bold">({{ $komponen->uts }}%)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->uas > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <div class="flex flex-col items-center">
                                                <span class="text-red-600 font-bold">UAS</span>
                                                <span class="text-red-600 font-bold">({{ $komponen->uas }}%)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->kehadiran > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-blue-100 border-l-2 border-blue-300">
                                            <div class="flex flex-col items-center">
                                                <span class="text-blue-700 font-bold">Nilai Hadir</span>
                                                <span class="text-blue-600 text-xs">(Otomatis)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->tugas > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-green-100">
                                            <div class="flex flex-col items-center">
                                                <span class="text-green-700 font-bold">Nilai Tugas</span>
                                                <span class="text-green-600 text-xs">(Otomatis)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->project > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-indigo-100">
                                            <div class="flex flex-col items-center">
                                                <span class="text-indigo-700 font-bold">Nilai Project</span>
                                                <span class="text-indigo-600 text-xs">(Otomatis)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->uas > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-red-100">
                                            <div class="flex flex-col items-center">
                                                <span class="text-red-700 font-bold">Nilai Final (UAS)</span>
                                                <span class="text-red-600 text-xs">(Otomatis)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->kuis > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-purple-100">
                                            <div class="flex flex-col items-center">
                                                <span class="text-purple-700 font-bold">Nilai Quiz</span>
                                                <span class="text-purple-600 text-xs">(Otomatis)</span>
                                            </div>
                                        </th>
                                        @endif
                                        @if($komponen->uts > 0)
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-orange-100">
                                            <div class="flex flex-col items-center">
                                                <span class="text-orange-700 font-bold">Nilai UTS</span>
                                                <span class="text-orange-600 text-xs">(Otomatis)</span>
                                            </div>
                                        </th>
                                        @endif
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
                                    @forelse($mahasiswas as $index => $mahasiswa)
                                    @php
                                        $nilai = $nilaiMap[$mahasiswa->id] ?? null;
                                        $rowIndex = $index + 1;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors" data-mahasiswa-id="{{ $mahasiswa->id }}">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 sticky left-0 bg-white sticky">{{ $rowIndex }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap sticky left-12 bg-white sticky-nim">
                                            <span class="text-sm font-semibold text-gray-900">{{ $mahasiswa->nim }}</span>
                                        </td>
                                        <td class="px-4 py-3 sticky left-32 bg-white min-w-[200px] sticky-nama">
                                            <span class="text-sm font-medium text-gray-900">{{ $mahasiswa->nama_user }}</span>
                                        </td>
                                        @if($komponen->kehadiran > 0)
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[{{ $mahasiswa->id }}][kehadiran]"
                                                   value="{{ $nilai->kehadiran ?? '' }}"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-komponen="kehadiran"
                                                   data-bobot="{{ $komponen->kehadiran }}"
                                                   class="nilai-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500 md:w-20 sm:w-16">
                                        </td>
                                        @endif
                                        @if($komponen->tugas > 0)
                                        @php
                                            $jumlahTugas = $komponen->jumlah_tugas ?? 1;
                                            $tugasValues = [];
                                            if ($nilai && $nilai->tugas) {
                                                if (is_string($nilai->tugas)) {
                                                    $decoded = json_decode($nilai->tugas, true);
                                                    $tugasValues = is_array($decoded) ? array_values($decoded) : [];
                                                } else {
                                                    $tugasValues = is_array($nilai->tugas) ? array_values($nilai->tugas) : [$nilai->tugas];
                                                }
                                            }
                                            // Pastikan array memiliki jumlah elemen sesuai jumlahTugas
                                            while (count($tugasValues) < $jumlahTugas) {
                                                $tugasValues[] = '';
                                            }
                                        @endphp
                                        @for($i = 0; $i < $jumlahTugas; $i++)
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[{{ $mahasiswa->id }}][tugas][{{ $i }}]"
                                                   value="{{ isset($tugasValues[$i]) && $tugasValues[$i] !== '' ? $tugasValues[$i] : '' }}"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-komponen="tugas"
                                                   data-bobot="{{ $komponen->tugas }}"
                                                   data-jumlah="{{ $jumlahTugas }}"
                                                   data-index="{{ $i }}"
                                                   class="nilai-input tugas-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        </td>
                                        @endfor
                                        @endif
                                        @if($komponen->kuis > 0)
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[{{ $mahasiswa->id }}][kuis]"
                                                   value="{{ $nilai->kuis ?? '' }}"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-komponen="kuis"
                                                   data-bobot="{{ $komponen->kuis }}"
                                                   class="nilai-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        </td>
                                        @endif
                                        @if($komponen->project > 0)
                                        @php
                                            $jumlahProject = $komponen->jumlah_project ?? 1;
                                            $projectValues = [];
                                            if ($nilai && $nilai->project) {
                                                if (is_string($nilai->project)) {
                                                    $decoded = json_decode($nilai->project, true);
                                                    $projectValues = is_array($decoded) ? array_values($decoded) : [];
                                                } else {
                                                    $projectValues = is_array($nilai->project) ? array_values($nilai->project) : [$nilai->project];
                                                }
                                            }
                                            // Pastikan array memiliki jumlah elemen sesuai jumlahProject
                                            while (count($projectValues) < $jumlahProject) {
                                                $projectValues[] = '';
                                            }
                                        @endphp
                                        @for($i = 0; $i < $jumlahProject; $i++)
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[{{ $mahasiswa->id }}][project][{{ $i }}]"
                                                   value="{{ isset($projectValues[$i]) && $projectValues[$i] !== '' ? $projectValues[$i] : '' }}"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-komponen="project"
                                                   data-bobot="{{ $komponen->project }}"
                                                   data-jumlah="{{ $jumlahProject }}"
                                                   data-index="{{ $i }}"
                                                   class="nilai-input project-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </td>
                                        @endfor
                                        @endif
                                        @if($komponen->uts > 0)
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[{{ $mahasiswa->id }}][uts]"
                                                   value="{{ $nilai->uts ?? '' }}"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-komponen="uts"
                                                   data-bobot="{{ $komponen->uts }}"
                                                   class="nilai-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                        </td>
                                        @endif
                                        @if($komponen->uas > 0)
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <input type="number" 
                                                   name="entries[{{ $mahasiswa->id }}][uas]"
                                                   value="{{ $nilai->uas ?? '' }}"
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   data-komponen="uas"
                                                   data-bobot="{{ $komponen->uas }}"
                                                   class="nilai-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                        </td>
                                        @endif
                                        @if($komponen->kehadiran > 0)
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-blue-100 border-l-2 border-blue-300">
                                            <span class="nilai-hadir text-sm font-semibold text-blue-800">-</span>
                                        </td>
                                        @endif
                                        @if($komponen->tugas > 0)
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-green-100">
                                            <span class="nilai-tugas text-sm font-semibold text-green-800">-</span>
                                        </td>
                                        @endif
                                        @if($komponen->project > 0)
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-indigo-100">
                                            <span class="nilai-project text-sm font-semibold text-indigo-800">-</span>
                                        </td>
                                        @endif
                                        @if($komponen->uas > 0)
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-red-100">
                                            <span class="nilai-final text-sm font-semibold text-red-800">-</span>
                                        </td>
                                        @endif
                                        @if($komponen->kuis > 0)
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-purple-100">
                                            <span class="nilai-quiz text-sm font-semibold text-purple-800">-</span>
                                        </td>
                                        @endif
                                        @if($komponen->uts > 0)
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-orange-100">
                                            <span class="nilai-uts text-sm font-semibold text-orange-800">-</span>
                                        </td>
                                        @endif
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-yellow-50">
                                            <span class="nilai-akhir text-sm font-bold text-gray-900">{{ $nilai ? number_format($nilai->nilai_akhir, 2) : '-' }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center bg-yellow-50">
                                            @php
                                                $hurufMutu = $nilai ? $nilai->huruf_mutu : '';
                                                $colors = $hurufMutu ? \App\Models\InputNilaiModel::getHurufMutuColors($hurufMutu) : ['bgColor' => 'bg-gray-100', 'textColor' => 'text-gray-600', 'borderColor' => 'border-gray-300'];
                                            @endphp
                                            <span class="huruf-mutu px-2 py-1 text-xs font-semibold rounded border {{ $colors['borderColor'] }} {{ $colors['bgColor'] }} {{ $colors['textColor'] }}">{{ $hurufMutu ?: '-' }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    @php
                                        $totalKolom = 3; // No, NIM, Nama
                                        if($komponen->kehadiran > 0) $totalKolom++;
                                        if($komponen->tugas > 0) $totalKolom++;
                                        if($komponen->kuis > 0) $totalKolom++;
                                        if($komponen->project > 0) $totalKolom++;
                                        if($komponen->uts > 0) $totalKolom++;
                                        if($komponen->uas > 0) $totalKolom++;
                                        $totalKolom += 2; // Nilai Akhir, Huruf Mutu
                                    @endphp
                                    <tr>
                                        <td colspan="{{ $totalKolom }}" class="px-4 py-8 text-center text-gray-500">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Tidak ada mahasiswa pada semester {{ $matakuliah->semester }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <p class="text-xs sm:text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span class="hidden sm:inline">Total mahasiswa: <strong>{{ $mahasiswas->count() }}</strong> | </span>
                                <span class="sm:hidden">Total: <strong>{{ $mahasiswas->count() }}</strong> | </span>
                                Nilai akan dihitung otomatis
                            </p>
                            <div class="flex items-center space-x-2 sm:space-x-3 w-full sm:w-auto">
                                <a href="/dosen/nilai-mahasiswa" 
                                   class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-center text-xs sm:text-sm">
                                    <i class="fas fa-arrow-left mr-1 sm:mr-2"></i><span class="hidden sm:inline">Kembali</span><span class="sm:hidden">Back</span>
                                </a>
                                <button type="submit" 
                                        class="flex-1 sm:flex-initial px-4 sm:px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl text-xs sm:text-sm">
                                    <i class="fas fa-save mr-1 sm:mr-2"></i><span class="hidden sm:inline">Simpan Nilai</span><span class="sm:hidden">Simpan</span>
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
                                <li>Huruf mutu akan ditentukan otomatis: A (≥90), A- (85-89), B+ (80-84), B (75-79), B- (70-74), C+ (65-69), C (60-64), C- (55-59), D (50-54), E (<50)</li>
                                <li>Setiap nilai huruf mewakili hasil belajar mahasiswa dan digunakan dalam perhitungan indeks prestasi berdasarkan bobot nilai dan jumlah SKS mata kuliah</li>
                                <li>Anda dapat menyimpan sebagian nilai saja, tidak harus semua sekaligus</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Popup untuk Pesan Error -->
    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Tidak Dapat Menghapus</h3>
                <p class="text-gray-600 text-center mb-4" id="errorModalMessage"></p>
                <div class="flex justify-center">
                    <button type="button" id="errorModalClose" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        <i class="fas fa-check mr-2"></i>Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

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

        // Calculate nilai akhir and huruf mutu dynamically
        function calculateNilaiAkhir(row) {
            const inputs = row.querySelectorAll('.nilai-input');
            
            // Get komponen values
            let kehadiran = 0;
            let tugas = 0;
            let kuis = 0;
            let project = 0;
            let uts = 0;
            let uas = 0;
            
            // Get bobot values
            let bobotKehadiran = 0;
            let bobotTugas = 0;
            let bobotKuis = 0;
            let bobotProject = 0;
            let bobotUts = 0;
            let bobotUas = 0;
            
            inputs.forEach(inp => {
                const komponen = inp.getAttribute('data-komponen');
                const bobot = parseFloat(inp.getAttribute('data-bobot')) || 0;
                const nilai = parseFloat(inp.value) || 0;
                
                if (komponen === 'kehadiran') {
                    kehadiran = nilai;
                    bobotKehadiran = bobot;
                } else if (komponen === 'tugas') {
                    // Calculate average of all tugas inputs (only count filled inputs)
                    const tugasInputs = row.querySelectorAll('.tugas-input');
                    let tugasTotal = 0;
                    let tugasCount = 0;
                    tugasInputs.forEach(tInp => {
                        const tValue = tInp.value.trim();
                        if (tValue !== '') {
                            const tNilai = parseFloat(tValue);
                            if (!isNaN(tNilai)) {
                                tugasTotal += tNilai;
                                tugasCount++;
                            }
                        }
                    });
                    tugas = tugasCount > 0 ? tugasTotal / tugasCount : 0;
                    bobotTugas = bobot;
                } else if (komponen === 'kuis') {
                    kuis = nilai;
                    bobotKuis = bobot;
                } else if (komponen === 'project') {
                    // Calculate average of all project inputs (only count filled inputs)
                    const projectInputs = row.querySelectorAll('.project-input');
                    let projectTotal = 0;
                    let projectCount = 0;
                    projectInputs.forEach(pInp => {
                        const pValue = pInp.value.trim();
                        if (pValue !== '') {
                            const pNilai = parseFloat(pValue);
                            if (!isNaN(pNilai)) {
                                projectTotal += pNilai;
                                projectCount++;
                            }
                        }
                    });
                    project = projectCount > 0 ? projectTotal / projectCount : 0;
                    bobotProject = bobot;
                } else if (komponen === 'uts') {
                    uts = nilai;
                    bobotUts = bobot;
                } else if (komponen === 'uas') {
                    uas = nilai;
                    bobotUas = bobot;
                }
            });
            
            // Calculate nilai per komponen untuk ditampilkan dan simpan nilainya
            let nilaiHadirValue = 0;
            let nilaiTugasValue = 0;
            let nilaiProjectValue = 0;
            let nilaiFinalValue = 0;
            let nilaiQuizValue = 0;
            let nilaiUtsValue = 0;
            
            // Nilai Hadir: (kehadiran / 25) * bobotKehadiran
            const nilaiHadirSpan = row.querySelector('.nilai-hadir');
            if (nilaiHadirSpan && bobotKehadiran > 0) {
                if (kehadiran > 0) {
                    nilaiHadirValue = (kehadiran / 25) * bobotKehadiran;
                    nilaiHadirSpan.textContent = nilaiHadirValue.toFixed(1);
                } else {
                    nilaiHadirSpan.textContent = '-';
                }
            }
            
            // Nilai Tugas: (rata-rata tugas / 100) * bobotTugas
            const nilaiTugasSpan = row.querySelector('.nilai-tugas');
            if (nilaiTugasSpan && bobotTugas > 0) {
                if (tugas > 0) {
                    nilaiTugasValue = (tugas / 100) * bobotTugas;
                    nilaiTugasSpan.textContent = nilaiTugasValue.toFixed(1);
                } else {
                    nilaiTugasSpan.textContent = '-';
                }
            }
            
            // Nilai Project: (rata-rata project / 100) * bobotProject
            const nilaiProjectSpan = row.querySelector('.nilai-project');
            if (nilaiProjectSpan && bobotProject > 0) {
                if (project > 0) {
                    nilaiProjectValue = (project / 100) * bobotProject;
                    nilaiProjectSpan.textContent = nilaiProjectValue.toFixed(1);
                } else {
                    nilaiProjectSpan.textContent = '-';
                }
            }
            
            // Nilai Final (UAS): (uas / 100) * bobotUas
            const nilaiFinalSpan = row.querySelector('.nilai-final');
            if (nilaiFinalSpan && bobotUas > 0) {
                if (uas > 0) {
                    nilaiFinalValue = (uas / 100) * bobotUas;
                    nilaiFinalSpan.textContent = nilaiFinalValue.toFixed(1);
                } else {
                    nilaiFinalSpan.textContent = '-';
                }
            }
            
            // Nilai Quiz: (kuis / 100) * bobotKuis
            const nilaiQuizSpan = row.querySelector('.nilai-quiz');
            if (nilaiQuizSpan && bobotKuis > 0) {
                if (kuis > 0) {
                    nilaiQuizValue = (kuis / 100) * bobotKuis;
                    nilaiQuizSpan.textContent = nilaiQuizValue.toFixed(1);
                } else {
                    nilaiQuizSpan.textContent = '-';
                }
            }
            
            // Nilai UTS: (uts / 100) * bobotUts
            const nilaiUtsSpan = row.querySelector('.nilai-uts');
            if (nilaiUtsSpan && bobotUts > 0) {
                if (uts > 0) {
                    nilaiUtsValue = (uts / 100) * bobotUts;
                    nilaiUtsSpan.textContent = nilaiUtsValue.toFixed(1);
                } else {
                    nilaiUtsSpan.textContent = '-';
                }
            }
            
            // Calculate total nilai akhir dari penjumlahan semua nilai rekap
            // Nilai Akhir = Nilai Hadir + Nilai Tugas + Nilai Project + Nilai Final + Nilai Quiz + Nilai UTS
            let totalNilai = nilaiHadirValue + nilaiTugasValue + nilaiProjectValue + nilaiFinalValue + nilaiQuizValue + nilaiUtsValue;
            
            // Update nilai akhir
            const nilaiAkhirSpan = row.querySelector('.nilai-akhir');
            if (nilaiAkhirSpan) {
                nilaiAkhirSpan.textContent = totalNilai > 0 ? totalNilai.toFixed(2) : '-';
            }
            
            // Update huruf mutu (sistem lengkap: A, A-, B+, B, B-, C+, C, C-, D, E)
            const hurufMutuSpan = row.querySelector('.huruf-mutu');
            if (hurufMutuSpan && totalNilai > 0) {
                let hurufMutu = '';
                let bgColor = '';
                let textColor = '';
                let borderColor = '';
                
                if (totalNilai >= 90) {
                    hurufMutu = 'A';
                    bgColor = 'bg-green-100';
                    textColor = 'text-green-800';
                    borderColor = 'border-green-600';
                } else if (totalNilai >= 85) {
                    hurufMutu = 'A-';
                    bgColor = 'bg-green-100';
                    textColor = 'text-green-800';
                    borderColor = 'border-green-600';
                } else if (totalNilai >= 80) {
                    hurufMutu = 'B+';
                    bgColor = 'bg-blue-100';
                    textColor = 'text-blue-800';
                    borderColor = 'border-blue-600';
                } else if (totalNilai >= 75) {
                    hurufMutu = 'B';
                    bgColor = 'bg-blue-100';
                    textColor = 'text-blue-800';
                    borderColor = 'border-blue-600';
                } else if (totalNilai >= 70) {
                    hurufMutu = 'B-';
                    bgColor = 'bg-blue-100';
                    textColor = 'text-blue-800';
                    borderColor = 'border-blue-600';
                } else if (totalNilai >= 65) {
                    hurufMutu = 'C+';
                    bgColor = 'bg-yellow-100';
                    textColor = 'text-yellow-800';
                    borderColor = 'border-yellow-600';
                } else if (totalNilai >= 60) {
                    hurufMutu = 'C';
                    bgColor = 'bg-yellow-100';
                    textColor = 'text-yellow-800';
                    borderColor = 'border-yellow-600';
                } else if (totalNilai >= 55) {
                    hurufMutu = 'C-';
                    bgColor = 'bg-yellow-100';
                    textColor = 'text-yellow-800';
                    borderColor = 'border-yellow-600';
                } else if (totalNilai >= 50) {
                    hurufMutu = 'D';
                    bgColor = 'bg-orange-100';
                    textColor = 'text-orange-800';
                    borderColor = 'border-orange-600';
                } else {
                    hurufMutu = 'E';
                    bgColor = 'bg-red-100';
                    textColor = 'text-red-800';
                    borderColor = 'border-red-600';
                }
                
                hurufMutuSpan.textContent = hurufMutu;
                hurufMutuSpan.className = `huruf-mutu px-2 py-1 text-xs font-semibold rounded border ${borderColor} ${bgColor} ${textColor}`;
            } else if (hurufMutuSpan && totalNilai === 0) {
                hurufMutuSpan.textContent = '-';
                hurufMutuSpan.className = 'huruf-mutu px-2 py-1 text-xs font-semibold rounded border border-gray-300 bg-gray-100 text-gray-600';
            }
        }
        
        // Add event listeners to all nilai inputs
        document.querySelectorAll('.nilai-input').forEach(input => {
            input.addEventListener('input', function() {
                const row = this.closest('tr');
                calculateNilaiAkhir(row);
            });
        });
        
        // Calculate nilai akhir for all rows on page load
        document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
            calculateNilaiAkhir(row);
        });
        
        // Function to add new tugas column
        let currentTugasCount = {{ $komponen->jumlah_tugas ?? 1 }};
        document.getElementById('btnTambahTugas')?.addEventListener('click', function() {
            currentTugasCount++;
            const bobot = {{ $komponen->tugas }};
            
            // Add header
            const tugasHeaders = document.querySelectorAll('.tugas-header');
            const lastTugasHeader = tugasHeaders[tugasHeaders.length - 1];
            const newHeader = lastTugasHeader.cloneNode(true);
            newHeader.setAttribute('data-index', currentTugasCount);
            newHeader.setAttribute('data-col-index', currentTugasCount - 1);
            
            // Update header content dengan struktur yang benar termasuk tombol hapus
            const headerContent = newHeader.querySelector('.flex.flex-col');
            if (headerContent) {
                // Create new structure with delete button
                const bobotTugas = {{ $komponen->tugas }};
                headerContent.innerHTML = `
                    <div class="flex items-center justify-center gap-2">
                        <span class="text-green-600 font-bold">TUGAS ${currentTugasCount}</span>
                        <button type="button" class="btn-hapus-tugas text-red-500 hover:text-red-700 text-xs" data-col-index="${currentTugasCount - 1}" title="Hapus kolom Tugas ${currentTugasCount}">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                    <span class="text-green-600 font-bold text-xs">(${bobotTugas}%)</span>
                `;
                
                // Add event listener to delete button
                const deleteBtn = headerContent.querySelector('.btn-hapus-tugas');
                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function() {
                        hapusKolomTugas(currentTugasCount - 1);
                    });
                }
            }
            
            lastTugasHeader.after(newHeader);
            
            // Add input field for each student row
            document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
                const mahasiswaId = row.getAttribute('data-mahasiswa-id');
                const tugasInputs = row.querySelectorAll('.tugas-input');
                const lastTugasInput = tugasInputs[tugasInputs.length - 1];
                const newInput = lastTugasInput.cloneNode(true);
                newInput.setAttribute('name', `entries[${mahasiswaId}][tugas][${currentTugasCount - 1}]`);
                newInput.value = '';
                newInput.setAttribute('data-index', currentTugasCount - 1);
                newInput.classList.add('tugas-input', 'nilai-input');
                
                // Add event listener to new input
                newInput.addEventListener('input', function() {
                    calculateNilaiAkhir(row);
                });
                
                const newTd = document.createElement('td');
                newTd.className = 'px-4 py-3 whitespace-nowrap';
                newTd.appendChild(newInput);
                lastTugasInput.closest('td').after(newTd);
            });
            
            // Update hidden input
            document.getElementById('hidden_jumlah_tugas').value = currentTugasCount;
        });
        
        // Function to add new project column
        let currentProjectCount = {{ $komponen->jumlah_project ?? 1 }};
        document.getElementById('btnTambahProject')?.addEventListener('click', function() {
            currentProjectCount++;
            const bobot = {{ $komponen->project }};
            
            // Add header
            const projectHeaders = document.querySelectorAll('.project-header');
            const lastProjectHeader = projectHeaders[projectHeaders.length - 1];
            const newHeader = lastProjectHeader.cloneNode(true);
            newHeader.setAttribute('data-index', currentProjectCount);
            newHeader.setAttribute('data-col-index', currentProjectCount - 1);
            
            // Update header content dengan struktur yang benar termasuk tombol hapus
            const headerContent = newHeader.querySelector('.flex.flex-col');
            if (headerContent) {
                // Create new structure with delete button
                const bobotProject = {{ $komponen->project }};
                headerContent.innerHTML = `
                    <div class="flex items-center justify-center gap-2">
                        <span class="text-blue-600 font-bold">PROJECT ${currentProjectCount}</span>
                        <button type="button" class="btn-hapus-project text-red-500 hover:text-red-700 text-xs" data-col-index="${currentProjectCount - 1}" title="Hapus kolom Project ${currentProjectCount}">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                    <span class="text-blue-600 font-bold text-xs">(${bobotProject}%)</span>
                `;
                
                // Add event listener to delete button
                const deleteBtn = headerContent.querySelector('.btn-hapus-project');
                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function() {
                        hapusKolomProject(currentProjectCount - 1);
                    });
                }
            }
            
            lastProjectHeader.after(newHeader);
            
            // Add input field for each student row
            document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
                const mahasiswaId = row.getAttribute('data-mahasiswa-id');
                const projectInputs = row.querySelectorAll('.project-input');
                const lastProjectInput = projectInputs[projectInputs.length - 1];
                const newInput = lastProjectInput.cloneNode(true);
                newInput.setAttribute('name', `entries[${mahasiswaId}][project][${currentProjectCount - 1}]`);
                newInput.value = '';
                newInput.setAttribute('data-index', currentProjectCount - 1);
                newInput.classList.add('project-input', 'nilai-input');
                
                // Add event listener to new input
                newInput.addEventListener('input', function() {
                    calculateNilaiAkhir(row);
                });
                
                const newTd = document.createElement('td');
                newTd.className = 'px-4 py-3 whitespace-nowrap';
                newTd.appendChild(newInput);
                lastProjectInput.closest('td').after(newTd);
            });
            
            // Update hidden input
            document.getElementById('hidden_jumlah_project').value = currentProjectCount;
        });
        
        // Function to delete tugas column
        function hapusKolomTugas(colIndex) {
            // Check if any input in this column has a value
            const allTugasInputs = document.querySelectorAll('.tugas-input');
            let hasValue = false;
            let mahasiswaWithValue = [];
            
            allTugasInputs.forEach(input => {
                const inputColIndex = parseInt(input.getAttribute('data-index'));
                if (inputColIndex === colIndex && input.value.trim() !== '') {
                    hasValue = true;
                    const row = input.closest('tr[data-mahasiswa-id]');
                    if (row) {
                        const namaMahasiswa = row.querySelector('td:nth-child(3) span')?.textContent || 'Mahasiswa';
                        mahasiswaWithValue.push(namaMahasiswa);
                    }
                }
            });
            
            if (hasValue) {
                showErrorModal('Kolom Tugas ini tidak bisa dihapus karena sudah terisi nilai dari mahasiswa lain.', mahasiswaWithValue);
                return;
            }
            
            // Get current count
            const currentCount = parseInt(document.getElementById('hidden_jumlah_tugas').value);
            
            // Can't delete if only one column left
            if (currentCount <= 1) {
                alert('Minimal harus ada 1 kolom Tugas.');
                return;
            }
            
            // Confirm deletion
            if (!confirm('Apakah Anda yakin ingin menghapus kolom Tugas ini?')) {
                return;
            }
            
            // Remove header
            const headers = document.querySelectorAll('.tugas-header');
            headers.forEach(header => {
                const headerColIndex = parseInt(header.getAttribute('data-col-index'));
                if (headerColIndex === colIndex) {
                    header.remove();
                }
            });
            
            // Remove input columns from all rows
            document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
                const tugasInputs = row.querySelectorAll('.tugas-input');
                tugasInputs.forEach(input => {
                    const inputColIndex = parseInt(input.getAttribute('data-index'));
                    if (inputColIndex === colIndex) {
                        input.closest('td').remove();
                    }
                });
            });
            
            // Update indices and labels
            updateTugasIndices();
            
            // Update hidden input
            document.getElementById('hidden_jumlah_tugas').value = currentCount - 1;
            currentTugasCount = currentCount - 1;
            
            // Recalculate nilai akhir for all rows
            document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
                calculateNilaiAkhir(row);
            });
        }
        
        // Function to delete project column
        function hapusKolomProject(colIndex) {
            // Check if any input in this column has a value
            const allProjectInputs = document.querySelectorAll('.project-input');
            let hasValue = false;
            let mahasiswaWithValue = [];
            
            allProjectInputs.forEach(input => {
                const inputColIndex = parseInt(input.getAttribute('data-index'));
                if (inputColIndex === colIndex && input.value.trim() !== '') {
                    hasValue = true;
                    const row = input.closest('tr[data-mahasiswa-id]');
                    if (row) {
                        const namaMahasiswa = row.querySelector('td:nth-child(3) span')?.textContent || 'Mahasiswa';
                        mahasiswaWithValue.push(namaMahasiswa);
                    }
                }
            });
            
            if (hasValue) {
                showErrorModal('Kolom Project ini tidak bisa dihapus karena sudah terisi nilai dari mahasiswa lain.', mahasiswaWithValue);
                return;
            }
            
            // Get current count
            const currentCount = parseInt(document.getElementById('hidden_jumlah_project').value);
            
            // Can't delete if only one column left
            if (currentCount <= 1) {
                alert('Minimal harus ada 1 kolom Project.');
                return;
            }
            
            // Confirm deletion
            if (!confirm('Apakah Anda yakin ingin menghapus kolom Project ini?')) {
                return;
            }
            
            // Remove header
            const headers = document.querySelectorAll('.project-header');
            headers.forEach(header => {
                const headerColIndex = parseInt(header.getAttribute('data-col-index'));
                if (headerColIndex === colIndex) {
                    header.remove();
                }
            });
            
            // Remove input columns from all rows
            document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
                const projectInputs = row.querySelectorAll('.project-input');
                projectInputs.forEach(input => {
                    const inputColIndex = parseInt(input.getAttribute('data-index'));
                    if (inputColIndex === colIndex) {
                        input.closest('td').remove();
                    }
                });
            });
            
            // Update indices and labels
            updateProjectIndices();
            
            // Update hidden input
            document.getElementById('hidden_jumlah_project').value = currentCount - 1;
            currentProjectCount = currentCount - 1;
            
            // Recalculate nilai akhir for all rows
            document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
                calculateNilaiAkhir(row);
            });
        }
        
        // Function to update tugas indices after deletion
        function updateTugasIndices() {
            const headers = Array.from(document.querySelectorAll('.tugas-header')).sort((a, b) => {
                return parseInt(a.getAttribute('data-col-index')) - parseInt(b.getAttribute('data-col-index'));
            });
            
            headers.forEach((header, newIndex) => {
                const newColIndex = newIndex;
                header.setAttribute('data-index', newIndex + 1);
                header.setAttribute('data-col-index', newColIndex);
                header.querySelector('.text-green-600.font-bold').textContent = `TUGAS ${newIndex + 1}`;
                
                // Update delete button (jika ada - hanya untuk kolom yang baru ditambahkan)
                const deleteBtn = header.querySelector('.btn-hapus-tugas');
                if (deleteBtn) {
                    deleteBtn.setAttribute('data-col-index', newColIndex);
                    deleteBtn.setAttribute('title', `Hapus kolom Tugas ${newIndex + 1}`);
                }
            });
            
            // Update input indices
            document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
                const tugasInputs = Array.from(row.querySelectorAll('.tugas-input')).sort((a, b) => {
                    return parseInt(a.getAttribute('data-index')) - parseInt(b.getAttribute('data-index'));
                });
                
                tugasInputs.forEach((input, newIndex) => {
                    const mahasiswaId = row.getAttribute('data-mahasiswa-id');
                    input.setAttribute('data-index', newIndex);
                    input.setAttribute('name', `entries[${mahasiswaId}][tugas][${newIndex}]`);
                });
            });
        }
        
        // Function to update project indices after deletion
        function updateProjectIndices() {
            const headers = Array.from(document.querySelectorAll('.project-header')).sort((a, b) => {
                return parseInt(a.getAttribute('data-col-index')) - parseInt(b.getAttribute('data-col-index'));
            });
            
            headers.forEach((header, newIndex) => {
                const newColIndex = newIndex;
                header.setAttribute('data-index', newIndex + 1);
                header.setAttribute('data-col-index', newColIndex);
                header.querySelector('.text-blue-600.font-bold').textContent = `PROJECT ${newIndex + 1}`;
                
                // Update delete button (jika ada - hanya untuk kolom yang baru ditambahkan)
                const deleteBtn = header.querySelector('.btn-hapus-project');
                if (deleteBtn) {
                    deleteBtn.setAttribute('data-col-index', newColIndex);
                    deleteBtn.setAttribute('title', `Hapus kolom Project ${newIndex + 1}`);
                }
            });
            
            // Update input indices
            document.querySelectorAll('tr[data-mahasiswa-id]').forEach(row => {
                const projectInputs = Array.from(row.querySelectorAll('.project-input')).sort((a, b) => {
                    return parseInt(a.getAttribute('data-index')) - parseInt(b.getAttribute('data-index'));
                });
                
                projectInputs.forEach((input, newIndex) => {
                    const mahasiswaId = row.getAttribute('data-mahasiswa-id');
                    input.setAttribute('data-index', newIndex);
                    input.setAttribute('name', `entries[${mahasiswaId}][project][${newIndex}]`);
                });
            });
        }
        
        // Function to show error modal
        function showErrorModal(message, mahasiswaList = []) {
            const modal = document.getElementById('errorModal');
            const messageEl = document.getElementById('errorModalMessage');
            
            let fullMessage = message;
            if (mahasiswaList.length > 0) {
                fullMessage += '<br><br><strong>Mahasiswa yang sudah mengisi:</strong><ul class="list-disc list-inside mt-2 text-sm">';
                mahasiswaList.forEach(mhs => {
                    fullMessage += '<li>' + mhs + '</li>';
                });
                fullMessage += '</ul>';
            }
            
            messageEl.innerHTML = fullMessage;
            modal.classList.remove('hidden');
        }
        
        // Close error modal
        document.getElementById('errorModalClose')?.addEventListener('click', function() {
            document.getElementById('errorModal').classList.add('hidden');
        });
        
        // Close modal when clicking outside
        document.getElementById('errorModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
        
        // Event listeners untuk tombol hapus akan ditambahkan secara dinamis
        // ketika kolom baru ditambahkan via JavaScript
        
        // Add hidden inputs to store jumlah tugas and project
        const form = document.querySelector('form');
        const hiddenTugas = document.createElement('input');
        hiddenTugas.type = 'hidden';
        hiddenTugas.name = 'jumlah_tugas';
        hiddenTugas.id = 'hidden_jumlah_tugas';
        hiddenTugas.value = currentTugasCount;
        form.appendChild(hiddenTugas);
        
        const hiddenProject = document.createElement('input');
        hiddenProject.type = 'hidden';
        hiddenProject.name = 'jumlah_project';
        hiddenProject.id = 'hidden_jumlah_project';
        hiddenProject.value = currentProjectCount;
        form.appendChild(hiddenProject);
    </script>
</body>
</html>
