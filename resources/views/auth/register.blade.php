<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Perpustakaan Muhi</title>

    <!-- Link font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Memanggil Tailwind CSS melalui Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-indigo-50/30 font-sans text-slate-900 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg">
        <!-- Logo / Title Centered -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-6">
                <div class="inline-flex items-center gap-4 p-5 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 shadow-md">
                    <img src="{{ asset('assets/logo-muhi.png') }}" alt="Logo Muhi" class="h-16 w-16 object-contain drop-shadow-lg">
                    <div class="text-left">
                        <h1 class="text-2xl font-black text-indigo-600 leading-tight">Perpustakaan</h1>
                        <p class="text-xs font-bold text-slate-500">SEKOLAH MUHI</p>
                    </div>
                </div>
            </div>
            <p id="desc-text" class="text-slate-500 font-medium tracking-wide">Buat akun siswa baru untuk mengakses perpustakaan</p>
        </div>

        <!-- FORM REGISTER CARD -->
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-indigo-100 border border-slate-100">
            <h2 id="form-title" class="text-xl font-bold text-slate-800 mb-6 text-center">Daftar Akun</h2>

            <!-- Pesan Error Validasi -->
            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-bold text-red-700">Terdapat kesalahan:</p>
                </div>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Pilih Tipe Akun (Siswa/Guru) -->
                <div class="p-4 bg-indigo-50 border-2 border-indigo-200 rounded-xl">
                    <label class="block text-sm font-semibold text-indigo-900 mb-3">Jenis Akun <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center p-3 rounded-lg border-2 cursor-pointer transition {{ old('role', 'siswa') == 'siswa' ? 'bg-indigo-100 border-indigo-500' : 'border-slate-200 bg-white hover:bg-slate-50' }}">
                            <input type="radio" name="role" value="siswa" {{ old('role', 'siswa') == 'siswa' ? 'checked' : '' }} class="w-4 h-4 cursor-pointer" required onchange="toggleRoleFields()">
                            <span class="ml-2 font-medium text-slate-700">Siswa</span>
                        </label>
                        <label class="flex items-center p-3 rounded-lg border-2 cursor-pointer transition {{ old('role') == 'guru' ? 'bg-indigo-100 border-indigo-500' : 'border-slate-200 bg-white hover:bg-slate-50' }}">
                            <input type="radio" name="role" value="guru" {{ old('role') == 'guru' ? 'checked' : '' }} class="w-4 h-4 cursor-pointer" required onchange="toggleRoleFields()">
                            <span class="ml-2 font-medium text-slate-700">Guru</span>
                        </label>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                        placeholder="Masukkan nama lengkap">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                        placeholder="contoh@email.com">
                </div>
 
                <!-- SISWA FIELDS -->
                <div id="siswa-fields" class="space-y-5">
                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-2">NISN <span class="text-red-500">*</span></label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('nisn') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                            placeholder="Masukkan 10 digit NISN">
                    </div>

                    <!-- Jurusan & Kelas -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="jurusan_id" class="block text-sm font-semibold text-slate-700 mb-2">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('jurusan_id') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                <option value="">-- Pilih --</option>
                                @foreach($jurusan as $jrs)
                                <option value="{{ $jrs->id }}" {{ old('jurusan_id') == $jrs->id ? 'selected' : '' }}>
                                    {{ $jrs->nama_jurusan }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="kelas" class="block text-sm font-semibold text-slate-700 mb-2">Kelas</label>
                            <select name="kelas" id="kelas"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('kelas') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                <option value="">-- Pilih --</option>
                                <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- GURU FIELDS -->
                <div id="guru-fields" class="space-y-5" style="display: none;">
                    <!-- NIP -->
                    <div>
                        <label for="nip" class="block text-sm font-semibold text-slate-700 mb-2">NIP (Nomor Induk Pegawai) <span class="text-red-500">*</span></label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('nip') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                            placeholder="Masukkan NIP">
                    </div>

                    <!-- Mata Pelajaran -->
                    <div>
                        <label for="mapel" class="block text-sm font-semibold text-slate-700 mb-2">Mata Pelajaran</label>
                        <input type="text" name="mapel" id="mapel" value="{{ old('mapel') }}"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('mapel') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                            placeholder="Contoh: Matematika, Bahasa Indonesia, dll">
                    </div>
                </div>

                <!-- No. Telepon -->
                <div>
                    <label for="no_telp" class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('no_telp') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                        placeholder="08xxxxxxxxxx">
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('alamat') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                        placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-slate-50' }} focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                        placeholder="Minimal 8 karakter">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                        placeholder="Ulangi password">
                </div>

                <!-- Info Role -->
                <div id="role-info" class="flex items-center gap-2 p-3 bg-indigo-50 rounded-xl border border-indigo-100">
                    <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p id="role-text" class="text-xs text-indigo-600 font-medium">Akun yang didaftarkan akan memiliki role <strong>Siswa</strong> secara otomatis.</p>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 active:scale-95">
                    Buat Akun Sekarang
                </button>
            </form>
        </div>

        <!-- Link ke Login -->
        <p class="text-center mt-6 text-slate-500 text-sm font-medium">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Masuk di sini</a>
        </p>

        <!-- Footer -->
        <p class="text-center mt-6 text-slate-400 text-sm font-medium">
            &copy; {{ date('Y') }} Perpustakaan Muhammadiyah 1 Yogyakarta.
        </p>
    </div>

    <script>
    function toggleRoleFields() {
        const roleValue = document.querySelector('input[name="role"]:checked').value;
        const siswaFields = document.getElementById('siswa-fields');
        const guruFields = document.getElementById('guru-fields');
        const roleText = document.getElementById('role-text');
        const formTitle = document.getElementById('form-title');
        const descText = document.getElementById('desc-text');

        if (roleValue === 'siswa') {
            siswaFields.style.display = 'block';
            guruFields.style.display = 'none';
            formTitle.textContent = 'Daftar Akun Siswa';
            descText.textContent = 'Buat akun siswa baru untuk mengakses perpustakaan';
            roleText.innerHTML = 'Akun yang didaftarkan akan memiliki role <strong>Siswa</strong> secara otomatis.';
        } else {
            siswaFields.style.display = 'none';
            guruFields.style.display = 'block';
            formTitle.textContent = 'Daftar Akun Guru';
            descText.textContent = 'Buat akun guru baru untuk mengakses perpustakaan';
            roleText.innerHTML = 'Akun yang didaftarkan akan memiliki role <strong>Guru</strong> secara otomatis.';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', toggleRoleFields);
    </script>

</body>

</html>