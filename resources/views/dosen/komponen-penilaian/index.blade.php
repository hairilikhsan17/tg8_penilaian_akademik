<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komponen Penilaian - SPA Sistem Penilaian Akademik</title>
    
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
                <h2 class="text-2xl font-bold text-gray-800">Komponen Penilaian</h2>
                <p class="text-gray-600 text-sm mt-1">Kelola bobot penilaian untuk setiap mata kuliah</p>
            </div>

            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="/dosen/dashboard" class="hover:text-blue-600"><i class="fas fa-home"></i></a></li>
                    <li><span class="text-gray-500">/</span></li>
                    <li class="text-gray-700">Komponen Penilaian</li>
                </ol>
            </nav>

            <!-- Alert Messages -->
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-red-700 font-semibold mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-red-600 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="space-y-6">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm mb-1">Total Mata Kuliah</p>
                            <p class="text-3xl font-bold">{{ $totalMatakuliah }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm mb-1">Sudah Ada Komponen</p>
                            <p class="text-3xl font-bold">{{ $sudahAdaKomponen }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm mb-1">Belum Ada Komponen</p>
                            <p class="text-3xl font-bold">{{ $belumAdaKomponen }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search & Filter Box -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <form method="GET" action="/dosen/komponen-penilaian" class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1 relative">
                        <input type="text" name="search" 
                               value="{{ $search ?? '' }}"
                               placeholder="Cari berdasarkan Kode atau Nama Mata Kuliah..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="sudah" {{ ($status ?? '') === 'sudah' ? 'selected' : '' }}>Sudah Ada Komponen</option>
                        <option value="belum" {{ ($status ?? '') === 'belum' ? 'selected' : '' }}>Belum Ada Komponen</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                </form>
            </div>

            <!-- Tabel Komponen Penilaian -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode MK</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Mata Kuliah</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">SKS</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Bobot Penilaian</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($matakuliahs as $index => $matakuliah)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ ($matakuliahs->currentPage() - 1) * $matakuliahs->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $matakuliah->kode_mk }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $matakuliah->nama_mk }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        Semester {{ $matakuliah->semester }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm font-semibold text-gray-900">{{ $matakuliah->sks }} SKS</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($matakuliah->komponenPenilaian)
                                        <div class="flex flex-col space-y-1 text-xs">
                                            <div class="flex items-center justify-center space-x-2">
                                                <span class="text-gray-600">Hadir:</span>
                                                <span class="font-semibold text-blue-600">{{ $matakuliah->komponenPenilaian->kehadiran }}%</span>
                                            </div>
                                            <div class="flex items-center justify-center space-x-2">
                                                <span class="text-gray-600">Tugas:</span>
                                                <span class="font-semibold text-green-600">{{ $matakuliah->komponenPenilaian->tugas }}%</span>
                                            </div>
                                            <div class="flex items-center justify-center space-x-2">
                                                <span class="text-gray-600">Quiz:</span>
                                                <span class="font-semibold text-purple-600">{{ $matakuliah->komponenPenilaian->kuis }}%</span>
                                            </div>
                                            <div class="flex items-center justify-center space-x-2">
                                                <span class="text-gray-600">Project:</span>
                                                <span class="font-semibold text-indigo-600">{{ $matakuliah->komponenPenilaian->project }}%</span>
                                            </div>
                                            <div class="flex items-center justify-center space-x-2">
                                                <span class="text-gray-600">UTS:</span>
                                                <span class="font-semibold text-orange-600">{{ $matakuliah->komponenPenilaian->uts }}%</span>
                                            </div>
                                            <div class="flex items-center justify-center space-x-2">
                                                <span class="text-gray-600">UAS:</span>
                                                <span class="font-semibold text-red-600">{{ $matakuliah->komponenPenilaian->uas }}%</span>
                                            </div>
                                            <div class="pt-1 border-t border-gray-200 mt-1">
                                                <span class="font-bold text-gray-800">Total: {{ $matakuliah->komponenPenilaian->total }}%</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($matakuliah->komponenPenilaian)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Siap
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if($matakuliah->komponenPenilaian)
                                        <a href="/dosen/komponen-penilaian/{{ $matakuliah->komponenPenilaian->id }}/edit" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow hover:shadow-lg text-sm">
                                            <i class="fas fa-clipboard-check mr-2"></i>Edit
                                        </a>
                                    @else
                                        <a href="/dosen/matakuliahs/{{ $matakuliah->id }}/komponen" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow hover:shadow-lg text-sm">
                                            <i class="fas fa-clipboard-check mr-2"></i>Atur
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-clipboard-check text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Tidak ada data mata kuliah</p>
                                        <p class="text-sm mt-2">
                                            @if(request('search') || request('status'))
                                                Tidak ditemukan mata kuliah dengan filter yang dipilih
                                            @else
                                                Belum ada mata kuliah terdaftar.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($matakuliahs->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $matakuliahs->links() }}
                </div>
                @endif
            </div>

            <!-- Info Card -->
            <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-indigo-500 mr-3"></i>
                    <div>
                        <p class="text-sm text-indigo-700">
                            <strong>Penting:</strong> Setiap mata kuliah wajib memiliki komponen penilaian dengan total bobot 100% sebelum melakukan input nilai mahasiswa.
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script -->

</body>
</html>
