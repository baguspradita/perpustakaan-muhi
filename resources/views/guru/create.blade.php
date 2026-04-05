<x-app-layout>
    <x-slot name="title">Tambah Guru - Perpustakaan Muhi</x-slot>

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('guru.index') }}" class="p-2 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Guru Baru</h2>
        </div>
        <p class="text-slate-500 font-medium ml-12">Silakan isi formulir di bawah untuk menambahkan guru baru.</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-8">
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg">
                    <p class="font-bold mb-2">❌ Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guru.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- User Selection -->
                <div>
                    <label for="user_id" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Pilih User Guru <span class="text-rose-500">*</span>
                    </label>
                    <select name="user_id" id="user_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800" required>
                        <option value="" disabled selected>Pilih user guru...</option>
                        @foreach($availableUsers as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->nama }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                    @if(count($availableUsers) == 0)
                        <p class="text-orange-600 text-sm mt-2 font-medium">💡 Tidak ada user dengan role 'guru' yang tersedia. Silakan buat user dengan role 'guru' terlebih dahulu di menu Register.</p>
                    @endif
                </div>

                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Nomor NIP <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}" placeholder="Contoh: 1234567890123456" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800" required>
                    @error('nip')
                        <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mata Pelajaran -->
                <div>
                    <label for="mapel" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Mata Pelajaran <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="mapel" id="mapel" value="{{ old('mapel') }}" placeholder="Contoh: Matematika, Bahasa Indonesia, IPA, dll" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800" required>
                    @error('mapel')
                        <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('guru.index') }}" class="px-6 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors shadow-md hover:shadow-lg">
                        Simpan Guru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
