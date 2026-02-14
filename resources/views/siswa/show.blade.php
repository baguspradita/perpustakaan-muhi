<x-app-layout>
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('siswa.index') }}" class="p-3 bg-slate-100 hover:bg-slate-200 rounded-xl text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Siswa</h2>
            <p class="text-slate-500 font-medium">Informasi lengkap tentang siswa</p>
        </div>
    </div>

    <!-- Kartu Detail Siswa -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Informasi Utama -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <h3 class="text-2xl font-bold text-slate-800 mb-8">Informasi Pribadi</h3>

                <div class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Nama Lengkap</label>
                        <p class="text-lg font-bold text-slate-800">{{ $siswa->nama }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Alamat Email</label>
                        <p class="text-slate-700">{{ $siswa->email }}</p>
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Nomor Telepon</label>
                        <p class="text-slate-700">{{ $siswa->no_telp ?? '-' }}</p>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Alamat</label>
                        <p class="text-slate-700">{{ $siswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Informasi Akademik -->
        <div>
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <h3 class="text-2xl font-bold text-slate-800 mb-8">Informasi Akademik</h3>

                <div class="space-y-6">
                    <!-- Jurusan -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Jurusan</label>
                        <span class="inline-block px-4 py-2 bg-indigo-50 text-indigo-600 font-bold rounded-lg">
                            {{ $siswa->jurusan->nama_jurusan ?? '-' }}
                        </span>
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Kelas</label>
                        <p class="text-lg font-bold text-slate-800">{{ $siswa->kelas ?? '-' }}</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Status</label>
                        <span class="inline-block px-4 py-2 bg-emerald-50 text-emerald-600 font-bold rounded-lg">
                            Siswa Aktif
                        </span>
                    </div>

                    <!-- Bergabung Sejak -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Bergabung Sejak</label>
                        <p class="text-slate-700">{{ $siswa->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-8 flex gap-4">
        <a href="{{ route('siswa.index') }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold rounded-xl transition-all">
            Kembali
        </a>
    </div>
</x-app-layout>
