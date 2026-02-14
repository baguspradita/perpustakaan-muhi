<x-app-layout>
    <!-- Header Halaman -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('jurusan.index') }}" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></path></svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Jurusan Baru</h2>
        </div>
        <p class="text-slate-500 font-medium ml-11">Isi form di bawah untuk menambahkan jurusan baru.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 max-w-2xl">
        <form action="{{ route('jurusan.store') }}" method="POST">
            @csrf

            <!-- Input Nama Jurusan -->
            <div class="mb-6">
                <label for="nama_jurusan" class="block text-sm font-bold text-slate-700 mb-2">Nama Jurusan</label>
                <input type="text" class="w-full px-4 py-3 rounded-xl border @error('nama_jurusan') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan') }}" placeholder="Contoh : RPL">
                @error('nama_jurusan')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-8">
                <label for="deskripsi" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                <textarea class="w-full px-4 py-3 rounded-xl border @error('deskripsi') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none" id="deskripsi" name="deskripsi" rows="5" placeholder="Masukkan deskripsi jurusan...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.169 12.476l-4.604-4.604a2 2 0 00-2.828 0l-4.604 4.604a2 2 0 002.828 2.828l4.604-4.604a2 2 0 012.828 0l4.604 4.604a2 2 0 01-2.828 2.828z" clip-rule="evenodd"/></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 active:bg-indigo-800 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></path></svg>
                    Simpan Jurusan
                </button>
                <a href="{{ route('jurusan.index') }}" class="flex-1 px-6 py-3 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
