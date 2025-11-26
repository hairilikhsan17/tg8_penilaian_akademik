<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Portal Mahasiswa</title>
    
    
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
                                <p class="text-xs text-gray-500">NIM-221118</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 text-sm"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50 hidden">
                            <a href="/mahasiswa/profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil Saya
                            </a>
                            <hr class="my-2">
                            <button type="button" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
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
            <button type="button" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-red-600 transition-colors text-left">
                <i class="fas fa-sign-out-alt text-lg w-5"></i>
                <span class="font-medium">Logout</span>
            </button>
        </div>

        <!-- Info Mahasiswa Card -->
        <div class="mx-4 my-6 bg-blue-800 bg-opacity-50 rounded-lg p-4 border border-blue-700">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                    H
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-white truncate">Hairil Ikhsan</p>
                    <p class="text-xs text-blue-300">NIM-221118</p>
                </div>
            </div>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-blue-300">Semester:</span>
                    <span class="text-white font-semibold">3</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-blue-300">IPK:</span>
                    <span class="text-white font-semibold">3.50</span>
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
            <div class="mb-6" id="pageTitleSection" style="display: none;">
                <h2 class="text-2xl font-bold text-gray-800" id="pageTitle">Dashboard</h2>
                <p class="text-gray-600 text-sm mt-1" id="pageDescription" style="display: none;"></p>
            </div>

            <!-- Breadcrumb -->
            <nav class="mb-6" id="breadcrumbSection" style="display: none;">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="/mahasiswa/dashboard" class="hover:text-blue-600"><i class="fas fa-home"></i></a></li>
                    <li id="breadcrumbContent"></li>
                </ol>
            </nav>

            <!-- Alert Messages -->
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg hidden" id="successAlert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-green-700 font-medium" id="successMessage"></p>
                </div>
            </div>

            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg hidden" id="errorAlert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                    <p class="text-red-700 font-medium" id="errorMessage"></p>
                </div>
            </div>

            <!-- Content -->
            <div id="mainContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </main>

    <!-- Sidebar Toggle Script -->
    
</body>
</html>











