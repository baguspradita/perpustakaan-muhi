<x-app-layout>
    <!-- Header Halaman Dashboard -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard</h2>
        <p class="text-slate-500 font-medium">Selamat datang kembali, {{ auth()->user()->nama }}! Berikut ringkasan hari ini.</p>
    </div>

    <!-- Statistik Cards (Grid secara responsif) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <!-- Kartu Total Buku -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 rounded-2xl">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Total Koleksi Buku</p>
            <h3 class="text-4xl font-black text-slate-800">{{ $stats['total_buku'] }}</h3>
        </div>

        <!-- Kartu Total Siswa -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 rounded-2xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Siswa Terdaftar</p>
            <h3 class="text-4xl font-black text-slate-800">{{ $stats['total_siswa'] }}</h3>
        </div>

        <!-- Kartu Peminjaman Aktif -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 rounded-2xl">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Riwayat Peminjaman</p>
            <h3 class="text-4xl font-black text-slate-800">{{ $stats['total_peminjaman'] }}</h3>
        </div>

    </div>

    <!-- Section Contoh: Buku Terbaru atau Aktivitas (Placeholder) -->
    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
        <h4 class="text-lg font-bold text-slate-800 mb-4">Panduan Cepat</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <p class="font-bold text-indigo-600 mb-1">Cari Buku</p>
                <p class="text-sm text-slate-500">Gunakan menu Katalog Buku untuk melihat koleksi perpustakaan secara lengkap.</p>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <p class="font-bold text-indigo-600 mb-1">Mulai Meminjam</p>
                <p class="text-sm text-slate-500">Akses menu Peminjaman untuk mencatat transaksi keluar buku oleh siswa.</p>
            </div>
        </div>
    </div>
</x-app-layout>
