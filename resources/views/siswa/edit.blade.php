<x-app-layout>
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('siswa.show', $siswa->id) }}" class="p-3 bg-slate-100 hover:bg-slate-200 rounded-xl text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Data Siswa</h2>
            <p class="text-slate-500 font-medium">Perbarui informasi siswa <span class="text-indigo-600 font-bold">{{ $siswa->nama }}</span></p>
        </div>
    </div>

    <!-- Notifikasi Error Validasi -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold text-red-700">Terdapat kesalahan pada input:</p>
            </div>
            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit -->
    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Informasi Pribadi -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Informasi Pribadi</h3>

                    <div class="space-y-5">
                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-slate-600 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                value="{{ old('nama', $siswa->nama) }}"
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }} text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            >
                            @error('nama')
                                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-600 mb-2">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $siswa->email) }}"
                                placeholder="contoh@email.com"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }} text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            >
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label for="no_telp" class="block text-sm font-semibold text-slate-600 mb-2">Nomor Telepon</label>
                            <input
                                type="text"
                                id="no_telp"
                                name="no_telp"
                                value="{{ old('no_telp', $siswa->no_telp) }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('no_telp') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }} text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            >
                            @error('no_telp')
                                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="alamat" class="block text-sm font-semibold text-slate-600 mb-2">Alamat</label>
                            <textarea
                                id="alamat"
                                name="alamat"
                                rows="3"
                                placeholder="Masukkan alamat lengkap"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('alamat') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }} text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none"
                            >{{ old('alamat', $siswa->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Informasi Akademik -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Informasi Akademik</h3>

                    <div class="space-y-5">
                        <!-- Jurusan -->
                        <div>
                            <label for="jurusan_id" class="block text-sm font-semibold text-slate-600 mb-2">Jurusan</label>
                            <select
                                id="jurusan_id"
                                name="jurusan_id"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('jurusan_id') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }} text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            >
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusan as $jrs)
                                    <option value="{{ $jrs->id }}" {{ old('jurusan_id', $siswa->jurusan_id) == $jrs->id ? 'selected' : '' }}>
                                        {{ $jrs->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelas -->
                        <div>
                            <label for="kelas" class="block text-sm font-semibold text-slate-600 mb-2">Kelas</label>
                            <input
                                type="text"
                                id="kelas"
                                name="kelas"
                                value="{{ old('kelas', $siswa->kelas) }}"
                                placeholder="Contoh: XII RPL 1"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('kelas') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }} text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            >
                            @error('kelas')
                                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Status (read-only) -->
                <div class="bg-indigo-50 rounded-3xl border border-indigo-100 p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-indigo-100 rounded-xl">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="font-bold text-indigo-700 text-sm">Informasi</p>
                    </div>
                    <p class="text-xs text-indigo-600 leading-relaxed">Password siswa tidak dapat diubah melalui halaman ini. Gunakan fitur reset password jika diperlukan.</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex items-center gap-4">
            <button
                type="submit"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-bold rounded-xl transition-all shadow-md shadow-indigo-200 flex items-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('siswa.show', $siswa->id) }}" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold rounded-xl transition-all">
                Batal
            </a>
        </div>
    </form>
</x-app-layout>
