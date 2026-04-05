<x-app-layout>
    <x-slot name="title">Pengaturan Akun - Perpustakaan Muhi</x-slot>

    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Pengaturan Akun</h2>
        <p class="text-slate-500 font-medium mt-1">Kelola informasi profil dan biodata Anda di sini.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
        <div class="w-8 h-8 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-600 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- FORM CARD -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-md border border-slate-200 overflow-hidden">
                <div class="p-8 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Biodata Diri</h3>
                    <p class="text-sm text-slate-500 mt-1">Pastikan data Anda selalu up-to-date untuk memudahkan proses peminjaman buku.</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div class="md:col-span-2">
                            <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email (Readonly) -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email (ID Login)</label>
                            <input type="email" value="{{ $user->email }}" readonly
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed">
                            <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Email tidak dapat diubah sendiri demi keamanan data.
                            </p>
                        </div>

                        <!-- No. Telepon -->
                        <div>
                            <label for="no_telp" class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $user->no_telp) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                placeholder="08xxxxxxxxxx">
                            @error('no_telp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if($user->role === 'siswa')
                        <!-- Jurusan -->
                        <div>
                            <label for="jurusan_id" class="block text-sm font-semibold text-slate-700 mb-2">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                <option value="">-- Pilih --</option>
                                @foreach($jurusan as $jrs)
                                <option value="{{ $jrs->id }}" {{ old('jurusan_id', $user->jurusan_id) == $jrs->id ? 'selected' : '' }}>
                                    {{ $jrs->nama_jurusan }}
                                </option>
                                @endforeach
                            </select>
                            @error('jurusan_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Kelas -->
                        <div>
                            <label for="kelas" class="block text-sm font-semibold text-slate-700 mb-2">Kelas</label>
                            <select name="kelas" id="kelas"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                <option value="">-- Pilih --</option>
                                <option value="10" {{ old('kelas', $user->kelas) == '10' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ old('kelas', $user->kelas) == '11' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ old('kelas', $user->kelas) == '12' ? 'selected' : '' }}>12</option>
                            </select>
                            @error('kelas') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        @else

                        @endif

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-slate-100">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- INFO CARD -->
        <div class="space-y-6">
            <div class="bg-indigo-600 rounded-3xl p-8 text-white shadow-xl shadow-indigo-200 relative overflow-hidden">
                <!-- Decoration -->
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>

                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Informasi Penting</h3>
                    <p class="text-indigo-100 text-sm leading-relaxed mb-6">
                        Pastikan Nomor Telepon dan Alamat Anda sudah benar agar petugas dapat menghubungi Anda terkait status peminjaman buku.
                    </p>
                    <div class="p-4 bg-white/10 rounded-2xl border border-white/20">
                        <p class="text-[10px] text-indigo-200 font-bold uppercase tracking-wider mb-2">Status Akun</p>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                            <span class="text-sm font-bold capitalize">{{ $user->role }} Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Overview Widget -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-md">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-slate-100 border-4 border-indigo-50 flex items-center justify-center text-indigo-600 text-3xl font-black mb-4">
                        {{ substr(auth()->user()->nama, 0, 1) }}
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">{{ $user->nama }}</h3>
                    <p class="text-sm font-medium text-slate-500 mb-6">{{ $user->email }}</p>

                    <div class="w-full space-y-3">
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                            <span class="text-xs font-bold text-slate-400 uppercase">Peran</span>
                            <span class="text-xs font-bold text-indigo-600 capitalize">{{ $user->role }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                            <span class="text-xs font-bold text-slate-400 uppercase">Bergabung</span>
                            <span class="text-xs font-bold text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>