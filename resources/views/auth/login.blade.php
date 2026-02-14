<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Muhi</title>
    
    <!-- Link font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Memanggil Tailwind CSS melalui Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-indigo-50/30 font-sans text-slate-900 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <!-- Logo / Title Centered -->
        <div class="text-center mb-10">
            <div class="flex justify-center mb-6">
                <div class="inline-flex items-center gap-4 p-5 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 shadow-sm">
                    <img src="{{ asset('assets/logo-muhi.png') }}" alt="Logo Muhi" class="h-16 w-16 object-contain drop-shadow-lg">
                    <div class="text-left">
                        <h1 class="text-2xl font-black text-indigo-600 leading-tight">Perpustakaan</h1>
                        <p class="text-xs font-bold text-slate-500">SEKOLAH MUHI</p>
                    </div>
                </div>
            </div>
            <p class="text-slate-500 font-medium tracking-wide">Sistem Informasi Perpustakaan Sekolah</p>
        </div>

        <!-- FORM LOGIN CARD -->
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-indigo-100 border border-slate-100">
            <h2 class="text-xl font-bold text-slate-800 mb-6 text-center">Selamat Datang Kembali</h2>

            <!-- Pesan Error (Jika ada) -->
            @error('email')
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ $message }}
            </div>
            @enderror

            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 placeholder-slate-400"
                           placeholder="admin@mail.com">
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2 text-left">Kata Sandi</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-slate-50 placeholder-slate-400"
                           placeholder="••••••••">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 active:scale-95">
                    Masuk Sekarang
                </button>
            </form>
        </div>

        <!-- Footer / Bantuan -->
        <p class="text-center mt-10 text-slate-400 text-sm font-medium">
            &copy; {{ date('Y') }} Perpustakaan Muhammadiyah 1 Yogyakarta.
        </p>
    </div>

</body>
</html>
