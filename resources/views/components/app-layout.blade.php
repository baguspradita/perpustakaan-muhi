<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Perpustakaan Muhi' }}</title>
    
    <!-- Menggunakan font Google 'Instrument Sans' untuk tampilan modern -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Memanggil CSS dari Vite (Tailwind CSS v4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-900 overflow-x-hidden">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR: Bagian navigasi kiri -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 transform -translate-x-full transition-transform duration-300 lg:relative lg:translate-x-0">
            <!-- Logo / Nama Aplikasi -->
            <div class="px-6 py-8">
                <div class="flex items-center justify-center lg:justify-start gap-3">
                    <img src="{{ asset('assets/logo-muhi.png') }}" alt="Logo Muhi" class="h-14 w-14 object-contain drop-shadow-lg">
                    <div class="hidden lg:block">
                        <h1 class="text-lg font-black text-indigo-600 leading-tight">Perpustakaan</h1>
                        <p class="text-xs font-bold text-slate-500">MUHI</p>
                    </div>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="mt-4 px-4 space-y-1">
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <!-- Katalog Buku Link -->
                <a href="{{ route('buku.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('buku.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Katalog Buku
                </a>

                <!-- Daftar Siswa Link (Hanya untuk Admin/Petugas) -->
                @if(auth()->user()->role === 'petugas')
                <a href="{{ route('siswa.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('siswa.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0"></path></svg>
                    Daftar Siswa
                </a>
                @endif

                <!-- Contoh Link Lain (Hanya placeholder) -->
                <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Peminjaman
                </a>
            </nav>

            <!-- Bottom Information / Profile Mini -->
            <div class="absolute bottom-0 w-full p-4 border-t border-slate-100">
                <div class="flex items-center space-x-3 p-2 bg-slate-50 rounded-xl">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold uppercase">
                            {{ substr(auth()->user()->nama ?? 'A', 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-slate-900 truncate">{{ auth()->user()->nama ?? 'Admin' }}</p>
                        <p class="text-[10px] text-slate-500 truncate capitalize">{{ auth()->user()->role ?? 'Petugas' }}</p>
                    </div>
                    <!-- Form Logout -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-1 text-slate-400 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA: Bagian kanan layar -->
        <main class="flex-1 overflow-y-auto focus:outline-none">
            
            <!-- TOPBAR: Navbar atas -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 lg:hidden font-instrument">
                <div class="px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/logo-muhi.png') }}" alt="Logo Muhi" class="h-10 w-10 object-contain drop-shadow-lg">
                        <div>
                            <p class="text-sm font-black text-indigo-600">Perpustakaan</p>
                            <p class="text-xs font-bold text-slate-500 -mt-1">MUHI</p>
                        </div>
                    </div>
                    <button class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </header>

            <!-- KONTEN HALAMAN -->
            <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
