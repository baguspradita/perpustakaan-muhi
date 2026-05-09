<x-app-layout>
    <x-slot name="title">Tambah Guru Baru - Perpustakaan Muhi</x-slot>

    <!-- Header Halaman -->
    <div class="mb-10">
        <div class="flex items-center gap-4 mb-3">
            <a href="{{ route('guru.index') }}" class="p-2.5 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-indigo-600 transition-all shadow-sm hover:shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Daftarkan Guru Baru</h2>
                <p class="text-slate-500 font-medium">Lengkapi biodata dan informasi mata pelajaran guru.</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('guru.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Section 1: Informasi Akun -->
            <div class="bg-white rounded-[40px] border border-slate-100 shadow-xl shadow-slate-200/50 p-10 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-indigo-600"></div>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Informasi Akun</h3>
                        <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Data login untuk guru</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Nama Lengkap -->
                    <div class="space-y-2">
                        <label for="nama" class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap guru" 
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300" required>
                        @error('nama') <p class="text-rose-500 text-[10px] font-black uppercase tracking-wider mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Email Aktif <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="guru@domain.com" 
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300" required>
                        @error('email') <p class="text-rose-500 text-[10px] font-black uppercase tracking-wider mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Password <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" 
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300" required>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tight italic">Catatan: Pastikan guru menyimpan password ini untuk login.</p>
                        @error('password') <p class="text-rose-500 text-[10px] font-black uppercase tracking-wider mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Detail Keanggotaan -->
            <div class="bg-white rounded-[40px] border border-slate-100 shadow-xl shadow-slate-200/50 p-10 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-emerald-500"></div>

                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Informasi Keanggotaan</h3>
                        <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Identitas guru & Mata Pelajaran</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- NIP -->
                    <div class="space-y-2">
                        <label for="nip" class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Nomor Induk Pegawai (NIP) <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP guru" 
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300" required>
                        @error('nip') <p class="text-rose-500 text-[10px] font-black uppercase tracking-wider mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Mapel -->
                    <div class="space-y-2">
                        <label for="mapel" class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Mata Pelajaran <span class="text-rose-500">*</span></label>
                        <input type="text" name="mapel" id="mapel" value="{{ old('mapel') }}" placeholder="Contoh: Matematika, Bahasa Inggris" 
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-800 placeholder:text-slate-300" required>
                        @error('mapel') <p class="text-rose-500 text-[10px] font-black uppercase tracking-wider mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('guru.index') }}" class="text-sm font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Batal & Kembali</a>
                <button type="submit" class="px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-3xl transition-all shadow-xl shadow-indigo-100 flex items-center gap-3 group">
                    Daftarkan Guru
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
