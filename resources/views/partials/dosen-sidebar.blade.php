@php
    $dosenId = session('user_id');
    $dosen = \App\Models\DataUserModel::find($dosenId);
    $namaDosen = $dosen ? $dosen->nama_user : session('nama_user', 'Dosen');
    $nipDosen = $dosen ? ($dosen->nip ?? 'NIP-') : 'NIP-';
    $initial = strtoupper(substr($namaDosen, 0, 1));
    $totalMatakuliah = \App\Models\MatakuliahModel::where('dosen_id', $dosenId)->count();
@endphp
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

