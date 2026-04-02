<x-app-layout>
    <!-- Header Halaman -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('lokasi.index') }}" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tambah Lokasi Baru</h2>
        </div>
        <p class="text-slate-500 font-medium ml-11">Isi form di bawah untuk menambahkan lokasi penyimpanan baru.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 max-w-2xl">
        <form action="{{ route('lokasi.store') }}" method="POST">
            @csrf

            <!-- Input Nama Lokasi -->
            <div class="mb-6">
                <label for="nama_lokasi" class="block text-sm font-bold text-slate-700 mb-2">Nama Lokasi</label>
                <input type="text" class="w-full px-4 py-3 rounded-xl border @error('nama_lokasi') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="nama_lokasi" name="nama_lokasi" value="{{ old('nama_lokasi') }}" placeholder="Contoh: Rak A1, Lemari Kaca 01">
                @error('nama_lokasi')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Input Keterangan -->
            <div class="mb-8">
                <label for="keterangan" class="block text-sm font-bold text-slate-700 mb-2">Keterangan</label>
                <textarea class="w-full px-4 py-3 rounded-xl border @error('keterangan') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none" id="keterangan" name="keterangan" rows="5" placeholder="Masukkan keterangan lokasi (opsional)...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 active:bg-indigo-800 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Lokasi
                </button>
                <a href="{{ route('lokasi.index') }}" class="flex-1 px-6 py-3 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
