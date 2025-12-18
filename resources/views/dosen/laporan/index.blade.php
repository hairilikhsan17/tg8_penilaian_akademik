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
            @php
                $dosenId = session('user_id');
                $dosen = \App\Models\DataUserModel::find($dosenId);
                $namaDosen = $dosen ? $dosen->nama_user : session('nama_user', 'Dosen');
                $nipDosen = $dosen ? ($dosen->nip ?? 'NIP-') : 'NIP-';
                $initial = strtoupper(substr($namaDosen, 0, 1));
                $totalMatakuliah = \App\Models\MatakuliahModel::where('dosen_id', $dosenId)->count();
            @endphp
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center text-white font-bold text-xl">
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
                        <select name="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Semester</option>
                            @foreach($semesters as $semester)
                                <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                                    Semester {{ $semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mata Kuliah</label>
                        <select name="matakuliah_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Mata Kuliah</option>
                            @foreach($matakuliahs as $mk)
                                <option value="{{ $mk->id }}" {{ request('matakuliah_id') == $mk->id ? 'selected' : '' }}>
                                    {{ $mk->kode_mk }} - {{ $mk->nama_mk }} (S{{ $mk->semester }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        @if(request('semester') || request('matakuliah_id'))
                            <a href="/dosen/laporan-nilai" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                <i class="fas fa-times mr-2"></i>Reset
                            </a>
                        @endif
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
                        <a href="/dosen/laporan-nilai/pdf?{{ http_build_query(request()->query()) }}" id="btnCetakPdf" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-md hover:shadow-lg">
                            <i class="fas fa-file-pdf mr-2"></i>Cetak PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tabel Nilai -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                    <h4 class="text-lg font-semibold">Rekap Nilai Mahasiswa</h4>
                    <p class="text-sm text-indigo-100 mt-1">Total data: <strong>{{ $nilai->total() }}</strong> nilai</p>
                </div>
                @if($nilai->count() > 0)
                @php
                    // Tentukan kolom mana yang harus ditampilkan berdasarkan komponen penilaian
                    $showKehadiran = false;
                    $showKuis = false;
                    $showUts = false;
                    $showUas = false;
                    $showTugas = false;
                    $showProject = false;
                    
                    // Cek dari semua nilai yang ditampilkan
                    foreach($nilai as $item) {
                        $komponen = $item->matakuliah->komponenPenilaian ?? null;
                        if ($komponen) {
                            if ($komponen->kehadiran > 0) $showKehadiran = true;
                            // Quiz dan UTS selalu ditampilkan di rekap jika komponen penilaian ada
                            if (isset($komponen->kuis)) $showKuis = true;
                            if (isset($komponen->uts)) $showUts = true;
                            if ($komponen->uas > 0) $showUas = true;
                            if ($komponen->tugas > 0) $showTugas = true;
                            if ($komponen->project > 0) $showProject = true;
                        }
                    }
                    
                    // Buat array komponen yang dikonfigurasi sesuai urutan komponen penilaian
                    $komponenRekap = [];
                    if ($showKehadiran) {
                        $komponenRekap[] = ['name' => 'kehadiran', 'label' => 'Nilai Hadir', 'bg' => 'bg-blue-100', 'border' => 'border-l-2 border-blue-300'];
                    }
                    if ($showTugas) {
                        $komponenRekap[] = ['name' => 'tugas', 'label' => 'Nilai Tugas', 'bg' => 'bg-green-100', 'border' => ''];
                    }
                    if ($showProject) {
                        $komponenRekap[] = ['name' => 'project', 'label' => 'Nilai Project', 'bg' => 'bg-indigo-100', 'border' => ''];
                    }
                    if ($showUas) {
                        $komponenRekap[] = ['name' => 'uas', 'label' => 'Nilai Final (UAS)', 'bg' => 'bg-red-100', 'border' => ''];
                    }
                    if ($showKuis) {
                        $komponenRekap[] = ['name' => 'kuis', 'label' => 'Nilai Quiz', 'bg' => 'bg-purple-100', 'border' => ''];
                    }
                    if ($showUts) {
                        $komponenRekap[] = ['name' => 'uts', 'label' => 'Nilai UTS', 'bg' => 'bg-orange-100', 'border' => ''];
                    }
                @endphp
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
                                @if($showKehadiran)
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-blue-50">Hadir</th>
                                @endif
                                @if($showTugas && $maxTugas > 0)
                                @for($i = 1; $i <= $maxTugas; $i++)
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-green-50">
                                    <div class="flex flex-col items-center">
                                        <span>TUGAS {{ $i }}</span>
                                    </div>
                                </th>
                                @endfor
                                @endif
                                @if($showKuis)
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-purple-50">Quiz</th>
                                @endif
                                @if($showProject && $maxProject > 0)
                                @for($i = 1; $i <= $maxProject; $i++)
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-indigo-50">
                                    <div class="flex flex-col items-center">
                                        <span>PROJECT {{ $i }}</span>
                                    </div>
                                </th>
                                @endfor
                                @endif
                                @if($showUts)
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-orange-50">UTS</th>
                                @endif
                                @if($showUas)
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-red-50">UAS</th>
                                @endif
                                @foreach($komponenRekap as $komp)
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider {{ $komp['bg'] }} {{ $komp['border'] }}">
                                    <div class="flex flex-col items-center">
                                        <span>{{ $komp['label'] }}</span>
                                    </div>
                                </th>
                                @endforeach
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-yellow-50">Nilai Akhir</th>
                                <th class="px-2 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-yellow-50">Huruf Mutu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($nilai as $index => $item)
                            @php
                                $hurufMutu = $item->huruf_mutu ?? '';
                                $colors = $hurufMutu ? \App\Models\InputNilaiModel::getHurufMutuColors($hurufMutu) : ['bgColor' => 'bg-gray-100', 'textColor' => 'text-gray-600'];
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700">{{ $nilai->firstItem() + $index }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $item->matakuliah->kode_mk ?? '-' }}</span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="text-sm font-medium text-gray-900">{{ $item->matakuliah->nama_mk ?? '-' }}</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700">{{ $item->matakuliah->semester ?? '-' }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $item->mahasiswa->nim ?? '-' }}</span>
                                </td>
                                <td class="px-2 py-3">
                                    <span class="text-sm text-gray-900">{{ $item->mahasiswa->nama_user ?? '-' }}</span>
                                </td>
                                @php
                                    $komponenItem = $item->matakuliah->komponenPenilaian ?? null;
                                @endphp
                                @if($showKehadiran)
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-blue-50">
                                    <span class="text-sm font-medium text-gray-700">{{ $item->kehadiran ? number_format($item->kehadiran, 2) : '-' }}</span>
                                </td>
                                @endif
                                @php
                                    $tugasArray = [];
                                    if ($item->tugas) {
                                        if (is_string($item->tugas)) {
                                            $decoded = json_decode($item->tugas, true);
                                            $tugasArray = is_array($decoded) ? $decoded : [];
                                        } elseif (is_array($item->tugas)) {
                                            $tugasArray = $item->tugas;
                                        } else {
                                            $tugasArray = [(float)$item->tugas];
                                        }
                                    }
                                @endphp
                                @if($showTugas && $maxTugas > 0)
                                @for($i = 0; $i < $maxTugas; $i++)
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-green-50">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ isset($tugasArray[$i]) && $tugasArray[$i] !== null && $tugasArray[$i] !== '' ? number_format((float)$tugasArray[$i], 2) : '-' }}
                                    </span>
                                </td>
                                @endfor
                                @endif
                                @if($showKuis)
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-purple-50">
                                    <span class="text-sm font-medium text-gray-700">{{ $item->kuis ? number_format($item->kuis, 2) : '-' }}</span>
                                </td>
                                @endif
                                @php
                                    $projectArray = [];
                                    if ($item->project) {
                                        if (is_string($item->project)) {
                                            $decoded = json_decode($item->project, true);
                                            $projectArray = is_array($decoded) ? $decoded : [];
                                        } elseif (is_array($item->project)) {
                                            $projectArray = $item->project;
                                        } else {
                                            $projectArray = [(float)$item->project];
                                        }
                                    }
                                @endphp
                                @if($showProject && $maxProject > 0)
                                @for($i = 0; $i < $maxProject; $i++)
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-indigo-50">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ isset($projectArray[$i]) && $projectArray[$i] !== null && $projectArray[$i] !== '' ? number_format((float)$projectArray[$i], 2) : '-' }}
                                    </span>
                                </td>
                                @endfor
                                @endif
                                @if($showUts)
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-orange-50">
                                    <span class="text-sm font-medium text-gray-700">{{ $item->uts ? number_format($item->uts, 2) : '-' }}</span>
                                </td>
                                @endif
                                @if($showUas)
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-red-50">
                                    <span class="text-sm font-medium text-gray-700">{{ $item->uas ? number_format($item->uas, 2) : '-' }}</span>
                                </td>
                                @endif
                                @php
                                    // Calculate average for Tugas (hanya nilai yang sudah diisi)
                                    $rataRataTugas = 0;
                                    $tugasCount = 0;
                                    if (!empty($tugasArray)) {
                                        foreach ($tugasArray as $tugasVal) {
                                            if ($tugasVal !== null && $tugasVal !== '' && is_numeric($tugasVal)) {
                                                $rataRataTugas += (float)$tugasVal;
                                                $tugasCount++;
                                            }
                                        }
                                        if ($tugasCount > 0) {
                                            $rataRataTugas = $rataRataTugas / $tugasCount;
                                        } else {
                                            $rataRataTugas = 0;
                                        }
                                    }
                                    
                                    // Calculate average for Project (hanya nilai yang sudah diisi)
                                    $rataRataProject = 0;
                                    $projectCount = 0;
                                    if (!empty($projectArray)) {
                                        foreach ($projectArray as $projectVal) {
                                            if ($projectVal !== null && $projectVal !== '' && is_numeric($projectVal)) {
                                                $rataRataProject += (float)$projectVal;
                                                $projectCount++;
                                            }
                                        }
                                        if ($projectCount > 0) {
                                            $rataRataProject = $rataRataProject / $projectCount;
                                        } else {
                                            $rataRataProject = 0;
                                        }
                                    }
                                    
                                    // Hitung semua nilai rekap untuk perhitungan nilai akhir
                                    $komponenItem = $item->matakuliah->komponenPenilaian ?? null;
                                    $nilaiHadirRekap = 0;
                                    $nilaiTugasRekap = 0;
                                    $nilaiProjectRekap = 0;
                                    $nilaiFinalRekap = 0;
                                    $nilaiQuizRekap = 0;
                                    $nilaiUtsRekap = 0;
                                    
                                    if ($komponenItem) {
                                        // Nilai Hadir: (kehadiran_input / 25) * bobot_kehadiran
                                        $kehadiranInput = $item->kehadiran ?? 0;
                                        $bobotKehadiran = $komponenItem->kehadiran ?? 0;
                                        if ($kehadiranInput > 0 && $bobotKehadiran > 0) {
                                            $nilaiHadirRekap = ($kehadiranInput / 25) * $bobotKehadiran;
                                        }
                                        
                                        // Nilai Tugas: (rata-rata_tugas / 100) * bobot_tugas
                                        $bobotTugas = $komponenItem->tugas ?? 0;
                                        if ($rataRataTugas > 0 && $bobotTugas > 0) {
                                            $nilaiTugasRekap = ($rataRataTugas / 100) * $bobotTugas;
                                        }
                                        
                                        // Nilai Quiz: (kuis_input / 100) * bobot_kuis
                                        $kuisInput = $item->kuis ?? 0;
                                        $bobotKuis = $komponenItem->kuis ?? 0;
                                        if ($kuisInput > 0 && $bobotKuis > 0) {
                                            $nilaiQuizRekap = ($kuisInput / 100) * $bobotKuis;
                                        }
                                        
                                        // Nilai Project: (rata-rata_project / 100) * bobot_project
                                        $bobotProject = $komponenItem->project ?? 0;
                                        if ($rataRataProject > 0 && $bobotProject > 0) {
                                            $nilaiProjectRekap = ($rataRataProject / 100) * $bobotProject;
                                        }
                                        
                                        // Nilai UTS: (uts_input / 100) * bobot_uts
                                        $utsInput = $item->uts ?? 0;
                                        $bobotUts = $komponenItem->uts ?? 0;
                                        if ($utsInput > 0 && $bobotUts > 0) {
                                            $nilaiUtsRekap = ($utsInput / 100) * $bobotUts;
                                        }
                                        
                                        // Nilai Final (UAS): (uas_input / 100) * bobot_uas
                                        $uasInput = $item->uas ?? 0;
                                        $bobotUas = $komponenItem->uas ?? 0;
                                        if ($uasInput > 0 && $bobotUas > 0) {
                                            $nilaiFinalRekap = ($uasInput / 100) * $bobotUas;
                                        }
                                    }
                                    
                                    // Gunakan nilai_akhir yang sudah disimpan di database (sudah dihitung dengan benar di controller)
                                    $nilaiAkhirBaru = $item->nilai_akhir ?? 0;
                                @endphp
                                @foreach($komponenRekap as $komp)
                                @php
                                    // Tampilkan nilai rekap sesuai komponen
                                    $nilaiRekap = '-';
                                    if ($komp['name'] == 'kehadiran') {
                                        $nilaiRekap = $nilaiHadirRekap > 0 ? $nilaiHadirRekap : '-';
                                    } elseif ($komp['name'] == 'tugas') {
                                        $nilaiRekap = $nilaiTugasRekap > 0 ? $nilaiTugasRekap : '-';
                                    } elseif ($komp['name'] == 'kuis') {
                                        $nilaiRekap = $nilaiQuizRekap > 0 ? $nilaiQuizRekap : '-';
                                    } elseif ($komp['name'] == 'project') {
                                        $nilaiRekap = $nilaiProjectRekap > 0 ? $nilaiProjectRekap : '-';
                                    } elseif ($komp['name'] == 'uts') {
                                        $nilaiRekap = $nilaiUtsRekap > 0 ? $nilaiUtsRekap : '-';
                                    } elseif ($komp['name'] == 'uas') {
                                        $nilaiRekap = $nilaiFinalRekap > 0 ? $nilaiFinalRekap : '-';
                                    }
                                @endphp
                                <td class="px-2 py-3 whitespace-nowrap text-center {{ $komp['bg'] }} {{ $komp['border'] }}">
                                    <span class="text-sm font-semibold text-gray-800">{{ $nilaiRekap !== '-' ? number_format($nilaiRekap, 1) : '-' }}</span>
                                </td>
                                @endforeach
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-yellow-50">
                                    <span class="text-sm font-bold text-gray-900">{{ $nilaiAkhirBaru > 0 ? number_format($nilaiAkhirBaru, 2) : '-' }}</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center bg-yellow-50">
                                    @if($hurufMutu)
                                        <span class="px-2 py-1 text-xs font-semibold rounded border {{ $colors['borderColor'] }} {{ $colors['bgColor'] }} {{ $colors['textColor'] }}">{{ $hurufMutu }}</span>
                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $nilai->links() }}
                </div>
                @else
                <div class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-info-circle text-4xl mb-4 text-gray-400"></i>
                    <p class="text-lg font-semibold">Tidak ada data nilai</p>
                    <p class="text-sm mt-2">Belum ada nilai yang diinput untuk mata kuliah yang Anda ampu.</p>
                </div>
                @endif
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

