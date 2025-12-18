<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Mata Kuliah - SPA Sistem Penilaian Akademik</title>
    
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
    @include('partials.dosen-navbar')
    @include('partials.dosen-sidebar')

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 min-h-screen">
        <div class="p-6">
            <!-- Page Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Kelola Mata Kuliah</h2>
                <p class="text-gray-600 text-sm mt-1">Tambah, edit, dan hapus mata kuliah yang Anda ampu</p>
            </div>

            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="/dosen/dashboard" class="hover:text-blue-600"><i class="fas fa-home"></i></a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li class="text-gray-700">Mata Kuliah</li>
                </ol>
            </nav>

            <div class="space-y-6">
            <!-- Header dengan Tombol Tambah -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    
                </div>
                <a href="/dosen/matakuliahs/create" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Mata Kuliah</span>
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Search & Filter Box -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <form method="GET" action="/dosen/matakuliahs" class="flex flex-col md:flex-row gap-3" id="searchForm">
                    <div class="flex-1 relative">
                        <input type="text" name="search" id="searchInput" 
                               value="{{ $search ?? '' }}"
                               placeholder="Cari berdasarkan Kode atau Nama Mata Kuliah..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select name="semester" id="semesterSelect" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Semester</option>
                        @for($i = 1; $i <= 14; $i++)
                        <option value="{{ $i }}" {{ ($semester ?? '') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    @if(($search ?? false) || ($semester ?? false))
                    <a href="/dosen/matakuliahs" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-times mr-2"></i>Reset
                    </a>
                    @endif
                </form>
            </div>

            <!-- Tabel Mata Kuliah -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode MK</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Mata Kuliah</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">SKS</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Dosen Pengampu</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($matakuliahs ?? [] as $index => $matakuliah)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $matakuliah->kode_mk }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $matakuliah->nama_mk }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        Semester {{ $matakuliah->semester }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $matakuliah->sks }} SKS
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $matakuliah->dosen->nama_user ?? session('nama_user') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $komponen = $matakuliah->komponenPenilaian;
                                        $hasKomponen = $komponen && $komponen->total == 100;
                                        $belumLengkap = $komponen && $komponen->total != 100;
                                    @endphp
                                    @if($hasKomponen)
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Siap
                                    </span>
                                    @elseif($belumLengkap)
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Belum Lengkap ({{ $komponen->total }}%)
                                    </span>
                                    @else
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-amber-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Belum ada komponen
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="/dosen/matakuliahs/{{ $matakuliah->id }}/edit" class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="/dosen/matakuliahs/{{ $matakuliah->id }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2 block"></i>
                                    <p>Tidak ada data mata kuliah ditemukan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <p class="text-sm text-blue-700" id="infoCard">
                            <strong>Total Mata Kuliah:</strong> <span id="totalMatakuliah">{{ count($matakuliahs ?? []) }}</span> mata kuliah
                        </p>
                        <p class="text-xs text-blue-600 mt-1">
                            <i class="fas fa-lightbulb"></i> Pastikan setiap mata kuliah memiliki komponen penilaian sebelum input nilai mahasiswa
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script sudah di-include di partial -->
</body>
</html>
