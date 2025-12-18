@php
    $dosenId = session('user_id');
    $dosen = \App\Models\DataUserModel::find($dosenId);
    $namaDosen = $dosen ? $dosen->nama_user : session('nama_user', 'Dosen');
    $nipDosen = $dosen ? ($dosen->nip ?? 'NIP-') : 'NIP-';
    $initial = strtoupper(substr($namaDosen, 0, 1));
@endphp
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

